<?php

namespace Modules\User\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\User\ValueObjects\Email;

class WriteUserRepository implements WriteUserRepositoryContract
{
    public function create(string $firstName, string $lastName, Email $email): int
    {
        return DB::table('users')->insertGetId([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email->toNative(),
        ]);
    }
}
