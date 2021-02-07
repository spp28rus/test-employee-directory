<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => 'required|integer',
            'sort_by' => 'sometimes|string',
            'filter_text' => 'sometimes|string',
            'post_id' => 'sometimes|integer',
            'skill_id' => 'sometimes|integer',
        ];
    }
}
