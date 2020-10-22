<?php

namespace App\Http\Requests;

use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;

class PropertyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        return $user->can('edit-property');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Property::VALIDATION;
        $rules['name'] = ['required', 'string', 'unique:properties,name,'.$this->property->id,];
        return $rules;

    }
}
