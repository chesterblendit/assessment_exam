<?php

namespace Modules\Notification\Commands;

use App\Bus\Command\Command;
use Modules\Notification\ValueObjects\Payload;

class LogNotificationCommand extends Command
{
    public function __construct(
        private readonly Payload $payload
    ) {}

    public function getPayload(): Payload
    {
        return $this->payload;
    }
}
