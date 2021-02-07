<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseAutorizeAdminCheckRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;

class EmployeePageController extends Controller
{
    public function index(BaseAutorizeAdminCheckRequest $request, Employee $employee)
    {
        return view('employee', [
            'id' => $employee->id,
        ]);
    }
}
