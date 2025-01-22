<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Interfaces\ImageManagerInterface;
use Source\Category\Domain\Repositories\CategoryRepository as CategoryRepositoryContract;
use Source\Category\Infrastructure\Repositories\CategoryRepository;
use Source\MediaFile\Domain\Contracts\MediaFileNameGenerator;
use Source\MediaFile\Domain\Contracts\MediaFileRouteGenerator;
use Source\MediaFile\Domain\Contracts\Storage;
use Source\MediaFile\Domain\Repositories\MediaFileRepository as MediaFileRepositoryContract;
use Source\MediaFile\Infrastructure\Repositories\MediaFileRepository;
use Source\MediaFile\Infrastructure\Services\GeneralMediaFileNameGenerator;
use Source\MediaFile\Infrastructure\Services\InterventionImageManager;
use Source\MediaFile\Infrastructure\Services\PublicStorageMediaFileRouteGenerator;
use Source\MediaFile\Infrastructure\Storages\PublicStorage;
use Source\Photo\Domain\Repositories\PhotoRepository as PhotoRepositoryContract;
use Source\Photo\Infrastructure\Repositories\PhotoRepository;
use Source\Slug\Domain\Repositories\SlugRepository as SlugRepositoryContract;
use Source\Slug\Infrastructure\Repositories\SlugRepository;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        CategoryRepositoryContract::class => CategoryRepository::class,
        PhotoRepositoryContract::class => PhotoRepository::class,
        MediaFileRepositoryContract::class => MediaFileRepository::class,
        SlugRepositoryContract::class => SlugRepository::class,

        MediaFileNameGenerator::class => GeneralMediaFileNameGenerator::class,
        MediaFileRouteGenerator::class => PublicStorageMediaFileRouteGenerator::class,

        Storage::class => PublicStorage::class,

        ImageManagerInterface::class => InterventionImageManager::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict();
    }
}
