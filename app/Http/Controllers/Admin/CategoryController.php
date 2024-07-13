<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\PermessionModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class CategoryController extends Controller
{


    public function index()
    {
        $categories = Category::all();
        $user = User::with(['permission', 'employee'])->find(Auth::id());
        $permission = $user->permission;

        if ($permission->isAdmin === 1) {
            return Inertia::render('Admin/Category/Index', ['categories' => $categories]);
        } else if ($permission->canViewCompany) {

            return Inertia::render('User/Category/Index', ['permission' => $permission, 'categories' => $categories]);
        }
    }

    public function store(StoreCategoryRequest $request)
    {


        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1 && $permission->canEditCategory != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }


        // Create and save the product using mass assignment
        $category = Category::create($request->validated());



        return redirect()->back()->with('success', 'Category Created Successfully');
    }

    public function edit()
    {
    }
    public function update(UpdateCategoryRequest $request, $id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1 && $permission->canEditCategory != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }
        $category = Category::findOrFail($id);

        // Update the product with validated data
        $category->update($request->validated());

        return redirect()->back()->with('success', 'Category Updated Successfully');
    }




    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category Deleted Successfully');
    }
}
