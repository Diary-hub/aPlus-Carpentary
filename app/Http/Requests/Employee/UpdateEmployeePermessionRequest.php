<?php

namespace App\Http\Requests\Employee;

use App\Models\PermessionModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEmployeePermessionRequest extends FormRequest
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
            'canViewCategory' => 'required',
            'isAdmin' => 'required',
            'canViewProduct' => 'required',
            'canViewCompany' => 'required',
            'canEditProduct' => 'required',
            'canEditCompany' => 'required',
            'canEditCategory' => 'required',
            'canAddProduct' => 'required',
            'canViewEmployee' => 'required',
            'canEditEmployee' => 'required',

            'user_id' => 'nullable|integer',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
            'deleted_by' => 'nullable|integer',
            'deleted_at' => 'nullable',


        ];
    }
}
