<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseAutorizeAdminCheckRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index(BaseAutorizeAdminCheckRequest $request, Employee $employee)
    {
        return view('employee', [
            'id' => $employee->id,
        ]);
    }
}
