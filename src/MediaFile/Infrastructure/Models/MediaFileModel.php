<?php

namespace Source\MediaFile\Infrastructure\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Source\MediaFile\Infrastructure\Factories\MediaFileFactory;
use Source\Shared\Models\BaseModel;

/**
 * @property-read string $id
 * @property-read string $original_filename
 * @property-read string $filename
 * @property-read array<string, string> $storage_info
 * @property-read array<int, string> $sizes
 * @property-read string $extension
 * @property-read string $mimetype
 * @property-read ?array<string, mixed> $info
 * @property-read string $mediable_type
 * @property-read string $mediable_id
 * @property-read CarbonImmutable $created_at
 * @property-read ?CarbonImmutable $updated_at
 */
final class MediaFileModel extends BaseModel
{
    /** @use HasFactory<MediaFileFactory> */
    use HasFactory;
    use HasUuids;

    protected $table = 'media_files';

    protected $fillable = [
        'original_filename',
        'storage_info',
        'sizes',
        'extension',
        'mimetype',
        'info',
        'mediable_type',
        'mediable_id',
    ];

    protected function casts(): array
    {
        return [
            'storage_info' => 'array',
            'sizes' => 'array',
            'info' => 'array',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }

    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    public static function newFactory(): MediaFileFactory
    {
        return MediaFileFactory::new();
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
