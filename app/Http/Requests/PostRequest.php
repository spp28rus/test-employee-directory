<?php

namespace App\Http\Requests;

class PostRequest extends BaseAutorizeAdminCheckRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:40',
        ];
    }
}
