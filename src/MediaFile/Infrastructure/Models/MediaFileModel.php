<?php

namespace Source\MediaFile\Infrastructure\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Source\MediaFile\Infrastructure\Factories\MediaFileFactory;
use Source\Shared\Models\BaseModel;

final class MediaFileModel extends BaseModel
{
    use HasUuids;
    use HasFactory;

    protected $table = 'media_files';

    protected $fillable = [
        'original_name',
        'info',
        'storage_info',
        'sizes',
        'mimetype',
        'mediable_type',
        'mediable_id',
    ];

    protected function casts(): array
    {
        return [
            'info' => 'array',
            'storage_info' => 'array',
            'sizes' => 'array',
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

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
