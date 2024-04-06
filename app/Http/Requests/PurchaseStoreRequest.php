<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'payable' => ['nullable',
                'numeric',
                'lte:totalBill'
            ],
            'bill_end_date' => ['nullable'],
            'billNum' => ['required',
                Rule::unique('bills', 'bill_no')
            ],
            "vat" => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'billNum.required' => 'Bill number is required',
            'billNum.unique' => 'Please enter different Bill Number',
            'payable.lte' => 'The credit amount exceeds total amount'
        ];
    }
}
