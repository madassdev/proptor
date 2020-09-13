<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('edit-user') or auth()->user()->id == $this->route('user')->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'full_name' => 'string',
            'email' => 'email|unique:users,email,'.$this->route('user')->id,
            'mobile' => 'numeric',
            'password' => 'min:6',
            'permissions'=>'array',
            'permissions.*'=>'exists:permissions,name'
        ];
    }
}
