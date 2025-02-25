<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\PermessionModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class CompanyController extends Controller
{


    public function index()
    {
        $companies = Company::all();
        $user = User::with(['permission', 'employee'])->find(Auth::id());
        $permission = $user->permission;

        if ($permission->isAdmin === 1) {
            return Inertia::render('Admin/Company/Index', ['companies' => $companies]);
        } else if ($permission->canViewCompany) {

            return Inertia::render('User/Company/Index', ['permission' => $permission, 'companies' => $companies]);
        }
    }

    public function store(StoreCompanyRequest $request)
    {

        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1 && $permission->canEditCompany != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }




        // Create and save the product using mass assignment
        $company = Company::create($request->validated());



        return redirect()->back()->with('success', 'Company Created Successfully');
    }

    public function edit()
    {
    }
    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = Company::findOrFail($id);

        // Update the product with validated data
        $company->update($request->validated());

        return redirect()->back()->with('success', 'Company Updated Successfully');
    }




    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->back()->with('success', 'Company Deleted Successfully');
    }
}
