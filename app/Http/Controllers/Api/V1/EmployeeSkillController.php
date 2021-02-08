<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeSkillUpdateRequest;
use App\Http\Resources\SkillsResource;
use App\Models\Employee;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;

class EmployeeSkillController extends Controller
{
    public function update(
        EmployeeSkillUpdateRequest $request,
        Employee $employee
    ) {
        DB::beginTransaction();

        $employee->employeeSkills()->delete();

        foreach ($request->skill_ids as $skillId) {
            $employee->employeeSkills()->create([
                'skill_id' => $skillId,
            ]);
        }

        DB::commit();

        return new SkillsResource(
            Skill::all()
        );
    }
}
