<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->guard('api')->user();
        $course = $this->route('course');
        return 
            // User is a Tutor
            ($user->tutor and 
            // Tutor owns Course
            $course->tutor_id == $user->tutor->id) or
            //  User is Admin
            ($user->hasRole('admin'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Fetch the Course's Modules to be used for unique validation, and pass it down the 
        // request object for use in the controller without having to query database again.
        $this->modules = $modules = $this->route('course')->modules;

        return [
            'title' => ['required', function ($attribute, $value, $fail) use($modules){
                // Check modules for existing title
                if($modules->contains('title', $value)){
                    $fail('The module '.$attribute.' already exists.');
                }
            }],
            'slug'=>'string',
            'description' => 'min:10',
        ];
    }
}
