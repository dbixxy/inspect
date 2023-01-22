<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IssueRequest extends FormRequest
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
            'inspect_id' => 'sometimes|required',
            'plan_id' => 'sometimes|required',
            'position_x' => 'sometimes|required|integer',
            'position_y' => 'sometimes|required|integer',
            'problem' => 'sometimes|required|string',
            'suggest' => 'sometimes|required|string',
            'files' => 'sometimes|required',
        ];
    }
}
