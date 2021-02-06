<?php

namespace Tests\Feature;

use App\Exceptions\EmployeeLimitSkillCountException;
use App\Models\Employee;
use App\Models\EmployeePost;
use App\Models\EmployeeSkill;
use App\Models\Post;
use App\Models\Skill;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeRelationsTest extends TestCase
{
    use DatabaseTransactions;

    public function testEmployeeRelations()
    {
        /**
         * @var Employee
         */
        $employee = factory(Employee::class)->create();

        /**
         * @var Post
         */
        $post = factory(Post::class)->create();

        $employee->employeePost()->create([
            'post_id' => $post->id,
        ]);

        $limitSkillCount = $post->limit_skill_count ?? 5;

        for ($index = 0; $index < $limitSkillCount; $index++) {
            /**
             * @var Skill
             */
            $skill = factory(Skill::class)->create();

            $employee->employeeSkills()->create([
                'skill_id' => $skill->id,
            ]);
        }

        $limitSkillCountCheckOk = false;

        /**
         * @var Skill
         */
        $skill = factory(Skill::class)->create();

        try {
            $employee->employeeSkills()->create([
                'skill_id' => $skill->id,
            ]);
        } catch (EmployeeLimitSkillCountException $exception) {
            $limitSkillCountCheckOk = true;
        }

        $this->assertTrue($limitSkillCountCheckOk);

        // cascade deleting check
        $user = $employee->user;
        $userId = $user->id;
        $employeeId = $employee->id;

        $user->delete();

        $this->assertTrue(
            is_null(Employee::where('user_id', $userId)->first())
        );

        $this->assertTrue(
            is_null(EmployeePost::where('employee_id', $employeeId)->first())
        );

        $this->assertTrue(
            is_null(EmployeeSkill::where('employee_id', $employeeId)->first())
        );
    }
}
