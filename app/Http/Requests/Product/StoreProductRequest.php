<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:200',
            'quantity' => 'integer|min:0',
            'color' => 'required|string|max:100',
            'description' => 'nullable|string',
            'dinar_price' => 'required|numeric|min:0',
            'dolar_price' => 'required|numeric|min:0',
            'dolar_data' => 'required|numeric|min:0',
            'category_id' => 'required',
            'company_id' => 'required',
            'published' => 'nullable|boolean',
            'inStock' => 'nullable|boolean',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
            'deleted_by' => 'nullable|integer',
            'deleted_at' => 'nullable',


        ];
    }
}
