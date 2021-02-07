<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $slug
 */
class Role extends Model
{
    const ADMIN_SLUG = 'admin';
    const USER_SLUG = 'user';

    public $timestamps = false;

    public static function getBySlug(string $slug)
    {
        return self::where('slug', $slug)->first();
    }

    public function users()
    {
        return $this->belongsToMany(UserRole::class);
    }
}
