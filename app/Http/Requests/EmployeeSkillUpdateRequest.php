<?php

namespace App\Http\Requests;

class EmployeeSkillUpdateRequest extends BaseAutorizeAdminCheckRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'skill_ids' => 'required|array'
        ];
    }
}
