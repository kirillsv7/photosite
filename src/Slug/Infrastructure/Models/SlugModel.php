<?php

namespace Source\Slug\Infrastructure\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Source\Category\Infrastructure\Models\CategoryModel;
use Source\Photo\Infrastructure\Models\PhotoModel;
use Source\Shared\Models\BaseModel;

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
