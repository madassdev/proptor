<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
        // if(resolve('context') == 'prop'){

            $rules = [
                "full_name" => 'required',
                // "email" => 'required|email',
                "email" => 'required|email|unique:users',
                "mobile" => 'string',
                "password" => "required|min:6",
            ];
        // }

        // if(resolve('context') == 'main'){

        //     $rules = [
        //         "email" => 'required'
        //     ];
        // }
        
        // $rules = [];
        return $rules;
    }
}
