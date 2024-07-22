<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $user = User::with(['permission', 'employee'])->find(Auth::id());
        $permission = $user->permission;

        $orders = [];

        if ($permission->isAdmin === 1) {
            $orders =  Order::with(['employee.employee_images', 'qyas.qyasat_files', 'qyas.order_detail.order_detail_files'])->get();
            return Inertia::render('Admin/Order/Index', ['orders' => $orders,]);
        } else if ($permission->canViewOrder) {
            $orders =  Order::where('employee_id', $user->employee->id)->with(['employee.employee_images', 'qyas.qyasat_files', 'qyas.order_detail.order_detail_files'])->get();
            return Inertia::render('User/Order/Index', ['permission' => $permission, 'orders' => $orders,]);
        }
    }
}
