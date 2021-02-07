<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property EmployeePost $employeePost
 * @property Collection<EmployeeSkill> $employeeSkills
 */
class Employee extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employeePost()
    {
        return $this->hasOne(EmployeePost::class);
    }

    public function employeeSkills()
    {
        return $this->hasMany(EmployeeSkill::class);
    }

    public static function getRelationsOfInfo()
    {
        return [
            'user',
            'employeePost',
            'employeePost.post',
            'employeeSkills',
            'employeeSkills.skill',
        ];
    }
}
