<?php

namespace App\Http\Resources;

use App\Models\Employee;
use App\Models\Role;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var Employee
         */
        $employee = $this->resource;

        /**
         * @var User
         */
        $user = $employee->user;

        $result = [
            'id' => $employee->id,
            'user' => $user,
            'post' => $employee->employeePost ? $employee->employeePost->post : null,
            'skills' => $employee->employeeSkills,
            'created_at' => $employee->created_at->toDateTimeString(),
        ];

        /**
         * @var User
         */
        if ($authUser = Auth::user()
            and $authUser->hasRole(Role::ADMIN_SLUG)
        ) {
            $result['is_admin'] = $user->hasRole(Role::ADMIN_SLUG);
        }

        return $result;
    }
}
