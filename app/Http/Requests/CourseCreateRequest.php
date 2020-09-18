<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('add-course');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'slug' => 'string',
            'permalink' => 'string',
            
            'price' => 'required|numeric|min:0',
            'general_price' => 'numeric|gte:price|min:0',
            'description' => 'string',
            'short_description' => 'string',
            'categories' => 'array',
            'categories.*' => 'numeric|exists:categories,id'
        ];

    }
}
