<?php

namespace App\Http\Resources;

use App\Models\Employee;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeesPublicInfoResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($employee) {
            /**
             * @var Employee $employee
             */

            return [
                'post' => $employee->employeePost ? $employee->employeePost->post : null,
                'skills' => $employee->employeeSkills,
            ];
        });
    }
}
