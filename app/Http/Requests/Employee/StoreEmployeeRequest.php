<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'phone' => 'required|string|max:11',
            'address' => 'required|string|max:200',
            'gender' => 'required|integer',
            'age' => 'required|integer',
            // 'image' => 'nullable|longtext|',
            'salary' => 'required|numeric|min:0',
            'description' => 'nullable|string',

            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',


            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
            'deleted_by' => 'nullable|integer',
            'deleted_at' => 'nullable',

        ];
    }
}
