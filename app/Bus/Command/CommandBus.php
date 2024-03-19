<?php

namespace App\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $command): mixed;

    public function register(array $map): void;
}
