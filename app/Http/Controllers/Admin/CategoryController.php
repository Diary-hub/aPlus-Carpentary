<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;

use Inertia\Inertia;


class CategoryController extends Controller
{


    public function index()
    {
        $categories = Category::all();
        return Inertia::render('Admin/Category/Index', ['categories' => $categories]);
    }

    public function store(StoreCategoryRequest $request)
    {
        // Ensure the user is an admin
        if (auth()->user()->isAdmin != 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }




        // Create and save the product using mass assignment
        $category = Category::create($request->validated());



        return redirect()->route('admin.categories.index')->with('success', 'Category Created Successfully');
    }

    public function edit()
    {
    }
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        // Update the product with validated data
        $category->update($request->validated());

        return redirect()->back()->with('success', 'Category Updated Successfully');
    }




    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category Deleted Successfully');
    }
}
