<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseAutorizeAdminCheckRequest;
use App\Models\Employee;
use App\Models\Post;

class EmployeePostController extends Controller
{
    public function update(
        BaseAutorizeAdminCheckRequest $request,
        Employee $employee,
        Post $post
    ) {
        $employee->employeePost()->updateOrCreate([], [
            'post_id' => $post->id,
        ]);
    }
}
