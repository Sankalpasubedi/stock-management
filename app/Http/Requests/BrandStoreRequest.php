<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required'],
            'address'=>['required'],
            'phone_no'=>['required','integer'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name field is required',
            'address.required' => 'Address field is required',
            'phone_no.required' => 'Number field is required',
            'phone_no.integer' => 'Number should not have letters'
        ];
    }
}
