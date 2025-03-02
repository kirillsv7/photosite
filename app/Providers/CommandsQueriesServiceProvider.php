<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Source\Category\Application\Commands\CategoryCreateCommand;
use Source\Category\Application\Commands\CategoryStoreCommand;
use Source\Category\Application\Handlers\CategoryCreateHandler;
use Source\Category\Application\Handlers\CategoryGetHandler;
use Source\Category\Application\Handlers\CategoryStoreHandler;
use Source\Category\Application\Queries\CategoryGetQuery;
use Source\MediaFile\Application\Commands\MediaFileCreateCommand;
use Source\MediaFile\Application\Handlers\MediaFileCreateHandler;
use Source\Photo\Application\Commands\PhotoCreateCommand;
use Source\Photo\Application\Commands\PhotoStoreCommand;
use Source\Photo\Application\Handlers\PhotoCreateHandler;
use Source\Photo\Application\Handlers\PhotoGetHandler;
use Source\Photo\Application\Handlers\PhotoStoreHandler;
use Source\Photo\Application\Queries\PhotoGetQuery;
use Source\Shared\Commands\Contracts\CommandBus;
use Source\Shared\Commands\LaravelCommandBus;
use Source\Shared\Queries\Contracts\QueryBus;
use Source\Shared\Queries\LaravelQueryBus;
use Source\Slug\Application\Commands\SlugCreateCommand;
use Source\Slug\Application\Handlers\SlugCreateHandler;

class CommandsQueriesServiceProvider extends ServiceProvider
{
    /**
     * @var array<array-key, string>
     */
    public $singletons = [
        CommandBus::class => LaravelCommandBus::class,
        QueryBus::class   => LaravelQueryBus::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $commandBus = app(CommandBus::class);

        $queryBus = app(QueryBus::class);

        $commandBus->map([
            CategoryCreateCommand::class => CategoryCreateHandler::class,
            CategoryStoreCommand::class  => CategoryStoreHandler::class,

            MediaFileCreateCommand::class => MediaFileCreateHandler::class,

            SlugCreateCommand::class => SlugCreateHandler::class,

            PhotoCreateCommand::class => PhotoCreateHandler::class,
            PhotoStoreCommand::class  => PhotoStoreHandler::class,
        ]);

        $queryBus->map([
            CategoryGetQuery::class => CategoryGetHandler::class,

            PhotoGetQuery::class => PhotoGetHandler::class,
        ]);
    }
}
