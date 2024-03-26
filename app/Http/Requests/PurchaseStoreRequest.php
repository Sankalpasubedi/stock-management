<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseStoreRequest extends FormRequest
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
            'vendor' => ['required'],
            'product' => ['required'],
            'stock' => ['required'],
            'total' => ['required'],
            'payable' => ['nullable'],
            'bill_end_date' => ['nullable'],
            'billNum' => ['required'],
            "vat" => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'billNum.required' => ['Bill number is required']
        ];
    }
}
