<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeSkillUpdateRequest;
use App\Models\Employee;
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
    }
}
