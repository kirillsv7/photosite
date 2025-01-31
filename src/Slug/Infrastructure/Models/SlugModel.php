<?php

namespace Source\Slug\Infrastructure\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Source\Shared\Models\BaseModel;

/**
 * @property-read  string $id
 * @property-read  string $slug
 * @property-read  string $sluggable_type
 * @property-read  string $sluggable_id
 * @property-read  CarbonImmutable $created_at
 * @property-read  ?CarbonImmutable $updated_at
 */
final class SlugModel extends BaseModel
{
    use HasUuids;

    protected $table = 'slugs';

    protected $fillable = [
        'slug',
        'sluggable_type',
        'sluggable_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }

    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function sluggable(): MorphTo
    {
        return $this->morphTo();
    }
}
