<?php

namespace Source\Photo\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
