<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
        return [
            'customer'         => 'required|array',
            'invoice_no'       => 'required|string|max:255',
            'invoice_date'     => 'required|date',
            'invoice_due_date' => 'nullable|date',
            'notes'            => 'nullable|string',
            'products'         => 'required|array',
        ];
    }
}
