<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeePermessionRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\EmployeeImage;
use App\Models\PermessionModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['employee_images', 'user.permission'])->get();
        $users = User::get();
        $user = User::with(['permission', 'employee'])->find(Auth::id());
        $permission = $user->permission;

        if ($permission->isAdmin === 1) {
            return Inertia::render('Admin/Employee/Index', ['permission' => $permission, 'employees' => $employees, 'users' => $users]);
        } else if ($permission->canViewEmployee) {
            return Inertia::render('User/Employee/Index', ['permission' => $permission, 'employees' => $employees, 'users' => $users]);
        }
    }

    public function store(StoreEmployeeRequest $request)
    {

        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1 && $permission->canEditEmployee != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }





        // Create and save the employee using mass assignment
        $employee = Employee::create($request->validated());


        // Ensure the directory exists
        if (!File::exists(public_path('employee_images'))) {
            File::makeDirectory(public_path('employee_images'), 0755, true);
        }


        // Handle the image uploads
        if ($request->hasFile('employee_images')) {
            foreach ($request->file('employee_images') as $image) {
                if ($image->isValid()) {
                    // Generate a unique name for the image
                    $uniqueName = $request->name . '-' . time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                    // Store the image in the 'public/employee_images' directory
                    $path = $image->storeAs('public/employee_images', $uniqueName);

                    // Create a new EmployeeImage record
                    EmployeeImage::create([
                        'employee_id' => $employee->id,
                        'image' => Storage::url($path), // Get the URL for the stored file
                    ]);
                } else {
                    // Handle the case where the file is not valid
                    return response()->json(['error' => 'Invalid file upload'], 400);
                }
            }
        }



        return redirect()->back()->with('success', 'Employee Created Successfully');
    }

    public function edit()
    {
    }
    public function update(UpdateEmployeeRequest $request, $id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1 && $permission->canEditEmployee != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }


        $employee = Employee::findOrFail($id);

        // Update the employee with validated data
        $employee->update($request->validated());

        // Ensure the directory exists
        if (!File::exists(public_path('employee_images'))) {
            File::makeDirectory(public_path('employee_images'), 0755, true);
        }


        // Handle the image uploads
        if ($request->hasFile('employee_images')) {
            foreach ($request->file('employee_images') as $image) {
                if ($image->isValid()) {
                    // Generate a unique name for the image
                    $uniqueName = $request->name . '-' . time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                    // Store the image in the 'public/employee_images' directory
                    $path = $image->storeAs('public/employee_images', $uniqueName);

                    // Create a new EmployeeImage record
                    EmployeeImage::create([
                        'employee_id' => $employee->id,
                        'image' => Storage::url($path), // Get the URL for the stored file
                    ]);
                } else {
                    // Handle the case where the file is not valid
                    return response()->json(['error' => 'Invalid file upload'], 400);
                }
            }
        }


        return redirect()->back()->with('success', 'Employee Updated Successfully');
    }



    public function updatePermession(UpdateEmployeePermessionRequest $request, $id)
    {

        $employeePermessions = PermessionModel::where('user_id', $id)->get()->first();


        $employeePermessions->isAdmin = $request->isAdmin;
        $employeePermessions->canViewProduct = $request->canViewProduct;
        $employeePermessions->canViewCompany = $request->canViewCompany;
        $employeePermessions->canViewCategory = $request->canViewCategory;
        $employeePermessions->canEditProduct = $request->canEditProduct;
        $employeePermessions->canEditCompany = $request->canEditCompany;
        $employeePermessions->canEditCategory = $request->canEditCategory;
        $employeePermessions->canAddProduct = $request->canAddProduct;
        $employeePermessions->canViewEmployee = $request->canViewEmployee;
        $employeePermessions->canEditEmployee = $request->canEditEmployee;
        $employeePermessions->canViewQyasat = $request->canViewQyasat;
        $employeePermessions->canEditQyasat = $request->canEditQyasat;
        $employeePermessions->canViewOrder = $request->canViewOrder;
        $employeePermessions->canEditOrder = $request->canEditOrder;




        $employeePermessions->save();

        // // Update the employee with validated data
        // $employeePermessions->update($request->validated());

        return redirect()->back()->with('success', 'Permessions Updated Successfully');
    }


    public function deleteImage($id)
    {
        $image = EmployeeImage::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Image Deleted Successfully');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->back()->with('success', 'Employee Deleted Successfully');
    }
}
