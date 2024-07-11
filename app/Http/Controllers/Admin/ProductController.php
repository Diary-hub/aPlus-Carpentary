<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\SupplyProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Product;
use Inertia\Inertia;


class ProductController extends Controller
{


    public function index()
    {
        $products = Product::with(['company', 'category'])->get();
        $categories = Category::all();
        $companies = Company::all();
        return Inertia::render('Admin/Product/Index', ['products' => $products, 'categories' => $categories, 'companies' => $companies]);
    }


    public function supply()
    {
        $products = Product::with(['company', 'category'])->get();
        return Inertia::render('Admin/Product/Supply/Index', ['products' => $products,]);
    }

    public function refill(SupplyProductRequest $request, $id)
    {
        // Ensure the user is an admin
        if (auth()->user()->isAdmin != 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
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
        // Ensure the user is an admin
        if (auth()->user()->isAdmin != 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
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

        return redirect()->route('admin.products.index')->with('success', 'Product Created Successfully');
    }

    public function edit()
    {
    }
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        // $product->name = $request->name;
        // $product->quantity = $request->quantity;
        // $product->color = $request->color;
        // $product->description = $request->description;
        // $product->dinar_price = $request->dinar_price;
        // $product->dolar_price = $request->dolar_price;
        // $product->dolar_data = $request->dolar_data;
        // $product->category_id = $request->category_id;
        // $product->company_id = $request->company_id;

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
