<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Requests\Qyasat\UpdateQyasatRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderImage;
use App\Models\PermessionModel;
use App\Models\Product;
use App\Models\Qyasat;
use App\Models\QyasatImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $user = User::with(['permission', 'employee'])->find(Auth::id());
        $permission = $user->permission;

        $orders = [];

        if ($permission->isAdmin === 1) {
            $orders =  Order::with(['order_files', 'employee.employee_images', 'qyas.qyasat_files', 'qyas.order_detail.order_detail_files'])->get();
            return Inertia::render('Admin/Order/Index', ['orders' => $orders,]);
        } else if ($permission->canViewOrder) {
            $orders =  Order::where('employee_id', $user->employee->id)->with(['order_files', 'employee.employee_images', 'qyas.qyasat_files', 'qyas.order_detail.order_detail_files'])->get();
            return Inertia::render('User/Order/Index', ['permission' => $permission, 'orders' => $orders,]);
        }
    }




    public function update(UpdateOrderRequest $request, $id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1 && $permission->canEditOrder != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }


        $order = Order::findOrFail($id);

        // Update the employee with validated data
        $order->update($request->validated());

        // Ensure the directory exists
        if (!File::exists(public_path('order_images'))) {
            File::makeDirectory(public_path('order_images'), 0755, true);
        }


        // Handle the image uploads
        if ($request->hasFile('order_images')) {
            foreach ($request->file('order_images') as $image) {
                if ($image->isValid()) {
                    // Generate a unique name for the image
                    $uniqueName = $request->name . '-' . time() . '-' . str::random(10) . '.' . $image->getClientOriginalExtension();

                    // Store the image in the 'public/order_images' directory
                    $path = $image->storeAs('public/order_images', $uniqueName);

                    // Create a new EmployeeImage record
                    OrderImage::create([
                        'order_id' => $order->id,
                        'image' => Storage::url($path), // Get the URL for the stored file
                    ]);
                } else {
                    // Handle the case where the file is not valid
                    return response()->json(['error' => 'Invalid file upload'], 400);
                }
            }
        }


        return redirect()->back()->with('success', 'Order Updated Successfully');
    }


    public function destroy($id)
    {

        $order = Order::findOrFail($id);
        $qyas = Qyasat::findOrFail($order->qyas_id);
        $order_detail = OrderDetail::where('qyasat_id', $qyas->id);
        $qyas->inOrder = 0;
        $qyas->save();
        $order_detail->delete();

        $order->delete();
        return redirect()->back()->with('success', 'Order Deleted Successfully');
    }
}
