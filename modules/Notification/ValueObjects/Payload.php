<?php

namespace Modules\Notification\ValueObjects;

use App\Models\User;
use InvalidArgumentException;

class Payload
{
    public function __construct(protected User $payload)
    {
        if (!$payload instanceof User) {
            throw new InvalidArgumentException("Invalid payload provided");
        }
    }

    public static function from(object $payload): Payload
    {
        return new self($payload);
    }

    public function toArray(): array
    {
        return $this->payload->toArray();
    }
}
