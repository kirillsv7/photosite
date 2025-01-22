<?php

namespace Source\MediaFile\Infrastructure\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Source\MediaFile\Infrastructure\Models\MediaFileModel;

final class MediaFileFactory extends Factory
{
    protected $model = MediaFileModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
