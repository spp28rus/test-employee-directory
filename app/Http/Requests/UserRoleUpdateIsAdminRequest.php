<?php

namespace App\Http\Requests;

class UserRoleUpdateIsAdminRequest extends BaseAutorizeAdminCheckRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_admin' => 'required|boolean',
        ];
    }
}
