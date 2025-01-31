<?php

namespace Source\Photo\Infrastructure\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read  string $id
 * @property-read string $title
 * @property-read CarbonImmutable $created_at
 * @property-read ?CarbonImmutable $updated_at
 */
class PhotoModel extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $table = 'photos';

    protected $fillable = [
        'id',
        'title',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }
}
