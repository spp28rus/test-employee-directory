<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeePostUpdateRequest;
use App\Http\Resources\PostsResource;
use App\Models\Employee;
use App\Models\Post;

class EmployeePostController extends Controller
{
    public function update(
        EmployeePostUpdateRequest $request,
        Employee $employee
    ) {
        $postId = $request->post_id;

        if (! $postId) {
            $employee->employeePost()->delete();
        } else {
            $employee->employeePost()->updateOrCreate([], [
                'post_id' => $postId,
            ]);
        }

        return new PostsResource(
            Post::all()
        );
    }
}
