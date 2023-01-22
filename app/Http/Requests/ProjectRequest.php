<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'project_name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'customer_phone_number' => 'string|max:255',
            'development_name' => 'string|max:255',
            'property_type' => 'string|max:255',
            'area_name' => 'string|max:255',
            'gps_position' => 'string|max:255',
            'image_file' => 'sometimes|required',
        ];
    }
}
