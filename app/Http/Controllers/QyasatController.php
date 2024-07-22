<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Models\Employee;
use App\Models\PermessionModel;
use App\Models\Qyasat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderDetailRequest;
use App\Http\Requests\Employee\UpdateEmployeePermessionRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Requests\Qyasat\StoreQyasatRequest;
use App\Http\Requests\Qyasat\UpdateQyasatRequest;
use App\Models\EmployeeImage;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailImage;
use App\Models\QyasatImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QyasatController extends Controller
{
    public function index()
    {
        $qyasat = Qyasat::with(['qyasat_files'])->get();
        $wasta = Employee::where('type', 'wasta')->get();
        $user = User::with(['permission', 'employee'])->find(Auth::id());
        $permission = $user->permission;

        if ($permission->isAdmin === 1) {
            return Inertia::render('Admin/Qyasat/Index', ['employee' => $wasta, 'permission' => $permission, 'qyasat' => $qyasat]);
        } else if ($permission->canViewQyasat) {
            return Inertia::render('User/Qyasat/Index', ['employee' => $wasta, 'permission' => $permission, 'qyasat' => $qyasat]);
        }
    }


    public function store(StoreQyasatRequest $request)
    {

        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1 && $permission->canEditQyasat != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }





        // Create and save the employee using mass assignment
        $qyas = Qyasat::create($request->validated());


        // Ensure the directory exists
        if (!File::exists(public_path('qyasat_images'))) {
            File::makeDirectory(public_path('qyasat_images'), 0755, true);
        }


        // Handle the image uploads
        if ($request->hasFile('qyasat_images')) {
            foreach ($request->file('qyasat_images') as $image) {
                if ($image->isValid()) {
                    // Generate a unique name for the image
                    $uniqueName = $request->name . '-' . time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                    // Store the image in the 'public/qyasat_images' directory
                    $path = $image->storeAs('public/qyasat_images', $uniqueName);

                    // Create a new EmployeeImage record
                    QyasatImage::create([
                        'qyasat_id' => $qyas->id,
                        'image' => Storage::url($path), // Get the URL for the stored file
                    ]);
                } else {
                    // Handle the case where the file is not valid
                    return response()->json(['error' => 'Invalid file upload'], 400);
                }
            }
        }



        return redirect()->back()->with('success', 'Qyas Created Successfully');
    }





    public function storeOrder(StoreOrderDetailRequest $request)
    {

        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1 && $permission->canEditOrder != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }





        // Create and save the employee using mass assignment
        $orderDetail = OrderDetail::create($request->validated());


        // Ensure the directory exists
        if (!File::exists(public_path('order_detail_images'))) {
            File::makeDirectory(public_path('order_detail_images'), 0755, true);
        }


        // Handle the image uploads
        if ($request->hasFile('order_detail_images')) {
            foreach ($request->file('order_detail_images') as $image) {
                if ($image->isValid()) {
                    // Generate a unique name for the image
                    $uniqueName = $request->name . '-' . time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                    // Store the image in the 'public/order_detail_images' directory
                    $path = $image->storeAs('public/order_detail_images', $uniqueName);

                    // Create a new EmployeeImage record
                    OrderDetailImage::create([
                        'order_detail_id' => $orderDetail->id,
                        'image' => Storage::url($path), // Get the URL for the stored file
                    ]);
                } else {
                    // Handle the case where the file is not valid
                    return response()->json(['error' => 'Invalid file upload'], 400);
                }
            }
        }

        $qyas = Qyasat::findOrFail($request->qyas_id);
        $qyas->inOrder = 1;
        $qyas->save();

        $order = Order::create([
            'employee_id' => $orderDetail->employee_id,
            'qyas_id' => $orderDetail->qyas_id,

        ]);





        return redirect()->back()->with('success', 'Order Created Successfully');
    }
    public function edit()
    {
    }
    public function update(UpdateQyasatRequest $request, $id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1 && $permission->canEditEmployee != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }


        $qyas = Qyasat::findOrFail($id);

        // Update the employee with validated data
        $qyas->update($request->validated());

        // Ensure the directory exists
        if (!File::exists(public_path('qyasat_images'))) {
            File::makeDirectory(public_path('qyasat_images'), 0755, true);
        }


        // Handle the image uploads
        if ($request->hasFile('qyasat_images')) {
            foreach ($request->file('qyasat_images') as $image) {
                if ($image->isValid()) {
                    // Generate a unique name for the image
                    $uniqueName = $request->name . '-' . time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                    // Store the image in the 'public/qyasat_images' directory
                    $path = $image->storeAs('public/qyasat_images', $uniqueName);

                    // Create a new EmployeeImage record
                    QyasatImage::create([
                        'employee_id' => $qyas->id,
                        'image' => Storage::url($path), // Get the URL for the stored file
                    ]);
                } else {
                    // Handle the case where the file is not valid
                    return response()->json(['error' => 'Invalid file upload'], 400);
                }
            }
        }


        return redirect()->back()->with('success', 'Qyas Updated Successfully');
    }





    public function deleteImage($id)
    {
        $image = QyasatImage::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Image Deleted Successfully');
    }

    public function destroy($id)
    {
        $qyas = Qyasat::findOrFail($id);
        $qyas->delete();
        return redirect()->back()->with('success', 'Qyas Deleted Successfully');
    }
}
