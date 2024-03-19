<?php

namespace Modules\Notification\Repositories;

use Modules\Notification\ValueObjects\Payload;

interface LogNotificationRepositoryContract
{
    public function log(Payload $payload): void;
}
