<?php

namespace App\Http\Controllers;

use App\Bus\Command\CommandBus;
use App\Bus\Query\QueryBus;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Notification\Commands\LogNotificationCommand;
use Modules\Notification\ValueObjects\Payload;
use Modules\User\Commands\CreateUserCommand;
use Modules\User\Queries\FindUserQuery;
use Modules\User\ValueObjects\Email;

class UserController
{
    public function __construct(
        protected CommandBus $commandBus,
        protected QueryBus $queryBus,
    ) {}

    public function __invoke(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $this->store($request);
            $user = $this->queryBus->ask(new FindUserQuery($id));

            $this->notify((array) $user);
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'User created successfully', 'data' => $user]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()], 500);
        }
    }

    private function store(Request $request): int
    {
        return $this->commandBus->dispatch(
            new CreateUserCommand(
                firstName: $request->firstName,
                lastName: $request->lastName,
                email: Email::from($request->email),
                // firstName: fake()->firstName(),
                // lastName: fake()->lastName,
                // email: Email::from(fake()->email),
            )
        );
    }

    private function notify(array $user): void
    {
        $this->commandBus->dispatch(
            new LogNotificationCommand(
                payload: Payload::from(new User($user)),
            )
        );
    }
}
