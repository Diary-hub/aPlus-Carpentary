<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use Inertia\Inertia;


class CompanyController extends Controller
{


    public function index()
    {
        $companies = Company::all();
        return Inertia::render('Admin/Company/Index', ['companies' => $companies]);
    }

    public function store(StoreCompanyRequest $request)
    {
        // Ensure the user is an admin
        if (auth()->user()->isAdmin != 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }




        // Create and save the product using mass assignment
        $company = Company::create($request->validated());



        return redirect()->route('admin.companies.index')->with('success', 'Company Created Successfully');
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
        return redirect()->route('admin.companies.index')->with('success', 'Company Deleted Successfully');
    }
}
