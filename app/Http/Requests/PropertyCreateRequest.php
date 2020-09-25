<?php

namespace App\Http\Requests;

use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;

class PropertyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        return $user->can('add-property');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Property::VALIDATION;
        $rules['name'] = ['required', 'string', 'unique:properties,name,NULL,id'];
        $rules['price'] = ['required','numeric', 'min:1'];
        $rules['units'] = ['numeric', 'min:1'];
        return $rules;
    }
}
