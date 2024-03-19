<?php

namespace Modules\Notification\Repositories;

use Illuminate\Support\Facades\Log;
use Modules\Notification\ValueObjects\Payload;

class LogNotificationRepository implements LogNotificationRepositoryContract
{
    public function log(Payload $payload): void
    {
        Log::channel('notification')->debug('', $payload->toArray());
    }
}
