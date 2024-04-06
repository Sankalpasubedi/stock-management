<?php

namespace App\Http\Requests;

use App\Rules\ValidateProductStock;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalesStoreRequest extends FormRequest
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
            'customer' => ['required'],
            'product' => ['required'],
            'stock' => ['required'],
            'total' => ['required'],
            'receivable' => ['nullable',
                'numeric',
                'lte:totalBill'],
            'date' => ['nullable'],
            'bill_end_date' => ['nullable'],
            'billNum' => ['required',
                Rule::unique('bills', 'bill_no')],
            "vat" => ['nullable']
        ];
    }

    public function messages()
    {
        return [
            'billNum.required' => 'Bill number is required',
            'billNum.unique' => 'Please enter different Bill Number',
            'receivable.lte' => 'The credit amount exceeds total amount'
        ];
    }
}
