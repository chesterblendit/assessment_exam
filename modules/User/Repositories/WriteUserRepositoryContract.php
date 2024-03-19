<?php

namespace Modules\User\Repositories;

use Modules\User\ValueObjects\Email;

interface WriteUserRepositoryContract
{
    public function create(string $firstName, string $lastName, Email $email): int;
}
