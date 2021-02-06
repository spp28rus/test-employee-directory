<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property int $limit_skill_count
*/
class Post extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'limit_skill_count',
    ];

    protected $casts = [
        'limit_skill_count' => 'integer',
    ];
}
