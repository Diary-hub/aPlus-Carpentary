<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PermessionModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with(['permission', 'employee'])->find(Auth::id());

        return Inertia::render('Dashboard', [
            'user' => $user,
            'permission' => $user->permission,
            'employee' => $user->employee,
        ]);
    }



    public function permessions(Request $request)
    {
        // Check if the request body is empty
        if ($request->query('type') !== 'get') {
            return redirect()->back(); // 400 Bad Request
        }

        // Find the authenticated user with their permissions and employee information
        $user = User::with(['permission', 'employee'])->find(Auth::id());

        if (!$user) {
            return response()->json([
                'error' => 'User not found',
            ], 404); // 404 Not Found
        }

        return response()->json([
            'permission' => $user->permission,
            'employee' => $user->employee,
            'user' => $user,
        ], 200); // 200 OK
    }
}
