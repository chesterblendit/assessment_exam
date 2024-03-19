<?php

namespace App\Providers;

use App\Bus\Command\CommandBus;
use App\Bus\Command\IlluminateCommandBus;
use App\Bus\Query\IlluminateQueryBus;
use App\Bus\Query\QueryBus;
use App\Jobs\UserNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Notification\Commands\LogNotificationCommand;
use Modules\Notification\Commands\LogNotificationCommandHandler;
use Modules\User\Commands\CreateUserCommand;
use Modules\User\Commands\CreateUserCommandHandler;
use Modules\User\Queries\FindUserQuery;
use Modules\User\Queries\FindUserQueryHandler;
use Modules\User\Repositories\ReadUserRepository;
use Modules\User\Repositories\ReadUserRepositoryContract;
use Modules\User\Repositories\WriteUserRepository;
use Modules\User\Repositories\WriteUserRepositoryContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $singletons = [
            CommandBus::class => IlluminateCommandBus::class,
            QueryBus::class => IlluminateQueryBus::class,
            WriteUserRepositoryContract::class => WriteUserRepository::class,
            ReadUserRepositoryContract::class => ReadUserRepository::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $commandBus = app(CommandBus::class);
        $commandBus->register([
            CreateUserCommand::class => CreateUserCommandHandler::class,
            LogNotificationCommand::class => LogNotificationCommandHandler::class,
        ]);

        $queryBus = app(QueryBus::class);
        $queryBus->register([
            FindUserQuery::class => FindUserQueryHandler::class,
        ]);
    }
}
