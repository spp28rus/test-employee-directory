<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeesPublicInfoResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeePublicInfoController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::whereHas('employeePost', function ($query) {
            $query->whereNotNull('id');
        })->with(
            Employee::getRelationsOfInfo()
        )->paginate(10);

        return new EmployeesPublicInfoResource($employees);
    }
}
