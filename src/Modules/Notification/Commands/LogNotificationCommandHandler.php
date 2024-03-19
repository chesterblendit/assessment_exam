<?php

namespace Modules\Notification\Commands;

use App\Bus\Command\CommandHandler;
use Modules\Notification\Repositories\LogNotificationRepository;

class LogNotificationCommandHandler extends CommandHandler
{
    public function __construct(
        protected LogNotificationRepository $repository,
    ) {}

    public function handle(LogNotificationCommand $command): void
    {
        $this->repository->log(
            payload: $command->getPayload(),
        );
    }
}
