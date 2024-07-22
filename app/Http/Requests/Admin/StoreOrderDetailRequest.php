<?php

namespace App\Http\Requests\Admin;

use App\Models\PermessionModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOrderDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1 && $permission->canEditOrder != 1) {
                return false;
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
            'qyas_id' => 'required|integer',
            'employee_id' => 'required|integer',
            'color' => 'required|string|max:200',
            'price' => 'required',
            'resource_type' => 'required|string|max:200',
            'description' => 'nullable|string',
            'price_meter' => 'required',
            'meter' => 'required',
            'total_meter_price' => 'required',

            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
            'deleted_by' => 'nullable|integer',
            'deleted_at' => 'nullable',

        ];
    }
}
