<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $employee_id
 * @property int $post_id
 * @property Employee $employee
 * @property Post $post
 */
class EmployeePost extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'employee_id',
        'post_id',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
