<?php

namespace App\Http\Requests\Employee;

use App\Models\PermessionModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

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
            'name' => 'required|string|max:200',
            'type' => 'required|string|max:200',
            'phone' => 'required|string|max:11',
            'address' => 'required|string|max:200',
            'gender' => 'required|integer',
            'age' => 'required|integer',
            // 'image' => 'nullable|longtext|',
            'salary' => 'required|numeric|min:0',
            'description' => 'nullable|string',

            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',


            'created_by' => 'nullable|integer',
            'user_id' => 'integer',
            'updated_by' => 'nullable|integer',
            'deleted_by' => 'nullable|integer',
            'deleted_at' => 'nullable',

        ];
    }
}
