<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 */
class Skill extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'title',
    ];
}
