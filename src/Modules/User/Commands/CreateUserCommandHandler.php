<?php

namespace Modules\User\Commands;

use App\Bus\Command\CommandHandler;
use Modules\User\Repositories\WriteUserRepository;

class CreateUserCommandHandler extends CommandHandler
{
    public function __construct(
        protected WriteUserRepository $repository,
    ) {}

    public function handle(CreateUserCommand $command): int
    {
        return $this->repository->create(
            firstName: $command->getFirstName(),
            lastName: $command->getLastName(),
            email: $command->getEmail(),
        );
    }
}
