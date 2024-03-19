<?php

namespace Modules\User\Commands;

use App\Bus\Command\Command;
use Modules\User\ValueObjects\Email;

class CreateUserCommand extends Command
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly Email $email
    ) {}

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
