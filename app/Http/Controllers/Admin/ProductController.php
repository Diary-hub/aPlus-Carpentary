<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\SupplyProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\PermessionModel;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class ProductController extends Controller
{


    public function index(Request $request)
    {
        $products = Product::with(['company', 'category'])->get();
        $categories = Category::all();
        $companies = Company::all();
        $user = User::with(['permission', 'employee'])->find(Auth::id());
        $permission = $user->permission;
        if ($permission->isAdmin === 1) {
            return Inertia::render('Admin/Product/Index', ['products' => $products, 'categories' => $categories, 'companies' => $companies]);
        } else if ($permission->canViewProduct) {

            return Inertia::render('User/Product/Index', ['permission' => $permission, 'products' => $products, 'categories' => $categories, 'companies' => $companies]);
        }
    }


    public function supply()
    {
        $products = Product::with(['company', 'category'])->get();

        $user = User::with(['permission', 'employee'])->find(Auth::id());
        $permission = $user->permission;
        if ($permission->isAdmin === 1) {
            return Inertia::render('Admin/Product/Supply/Index', ['permission' => $permission, 'products' => $products,]);
        } else if ($permission->canAddProduct) {

            return Inertia::render('User/Product/Supply/Index', ['permission' => $permission, 'products' => $products,]);
        }
    }

    public function refill(SupplyProductRequest $request, $id)
    {

        if (Auth::check()) {
            $user = Auth::user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin != 1 && $permission->canAddProduct != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }



        $product = Product::findOrFail($id);

        $product->quantity = $product->quantity +  $request->quantity;
        $product->dinar_price = $request->dinar_price;
        $product->dolar_price = $request->dolar_price;
        $product->dolar_data = $request->dolar_data;
        // Conditionally update 'updated_by' only if it's provided
        if (!empty($request->updated_by)) {
            $product->updated_by = $request->updated_by;
        }
        $product->update();


        $invoice = Invoice::create($request->validated());


        return redirect()->back()->with('success', 'Supply Added Successfully');
    }



    public function store(StoreProductRequest $request)
    {
        $user = Auth::user();
        $permission = PermessionModel::where('user_id', $user->id)->first();

        if (Auth::check()) {
            if ($permission && $permission->isAdmin != 1 && $permission->canEditProduct != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }




        // Create and save the product using mass assignment
        $product = Product::create($request->validated());


        // // Handle the image uploads
        // if ($request->hasFile('product_images')) {
        //     foreach ($request->file('product_images') as $image) {
        //         // Generate a unique name for the image
        //         $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

        //         // Move the image to the 'product_images' directory
        //         $image->move(public_path('product_images'), $uniqueName);

        //         // Create a new ProductImage record
        //         ProductImage::create([
        //             'product_id' => $product->id,
        //             'image' => 'product_images/' . $uniqueName,
        //         ]);
        //     }
        // }

        // return a response or Redirect
        // return response()->json([
        //     'message' => 'Product created successfully!',
        //     'product' => $product
        // ], 201);

        return redirect()->back()->with('success', 'Product Created Successfully');
    }

    public function edit()
    {
    }
    public function update(UpdateProductRequest $request, $id)
    {
        $user = Auth::user();
        $permission = PermessionModel::where('user_id', $user->id)->first();

        if (Auth::check()) {
            if ($permission && $permission->isAdmin != 1 && $permission->canEditProduct != 1) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $product = Product::findOrFail($id);



        // Update the product with validated data
        $product->update($request->validated());

        return redirect()->back()->with('success', 'Product Updated Successfully');
    }




    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product Deleted Successfully');
    }
}
