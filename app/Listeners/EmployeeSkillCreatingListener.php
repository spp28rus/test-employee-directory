<?php

namespace App\Listeners;

use App\Events\EmployeeSkillCreatingEvent;
use App\Exceptions\EmployeeLimitSkillCountException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeSkillCreatingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EmployeeSkillCreatingEvent $event)
    {
        $employeeSkill = $event->getEmployeeSkill();

        $employee = $employeeSkill->employee;
        $employeePost = $employee->employeePost;

        $currentCountSkills = $employee->employeeSkills->count();
        $limitSkillCount = $employeePost->post->limit_skill_count;

        if ($currentCountSkills >= $limitSkillCount) {
            throw new EmployeeLimitSkillCountException();
        }
    }
}
