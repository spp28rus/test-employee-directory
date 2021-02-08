<?php

namespace App\Http\Requests;

class EmployeePostUpdateRequest extends BaseAutorizeAdminCheckRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_id' => 'required|integer'
        ];
    }
}
