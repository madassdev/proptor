<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->guard('api')->user();
        return 
                // Tutor that can only edit his own course
                $user->tutor and $this->route('course')->tutor->user->id == $user->id
                //Special privileges
                or(
                    // Admin
                    $user->hasRole(['admin'])
                    // Moderator that can edit any course
                    or ($user->hasRole(['moderator']) and $user->can('edit-course'))
                );

           
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string',
            'price' => 'numeric|min:0',
            'general_price' => 'numeric|gte:price|min:0',
            'description' => 'string',
            'short_description' => 'string',
            'categories' => 'array',
            'categories.*' => 'numeric|exists:categories,id'
        ];
    }
}
