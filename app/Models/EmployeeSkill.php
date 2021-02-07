<?php

namespace App\Models;

use App\Events\EmployeeSkillCreatingEvent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $employee_id
 * @property int $skill_id
 * @property Employee $employee
 * @property Skill $skill
 */
class EmployeeSkill extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'employee_id',
        'skill_id',
    ];

    protected $dispatchesEvents = [
        'creating' => EmployeeSkillCreatingEvent::class,
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
