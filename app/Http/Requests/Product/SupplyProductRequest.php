<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class SupplyProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow access only if the user is an admin
        return auth()->check() && auth()->user()->isAdmin == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:200',
            'quantity' => 'required|integer|min:0',
            'dinar_price' => 'required|numeric|min:0',
            'dolar_price' => 'required|numeric|min:0',
            'dolar_data' => 'required|numeric|min:0',
            'product_id' => 'required',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
            'deleted_by' => 'nullable|integer',
            'deleted_at' => 'nullable',


        ];
    }
}
