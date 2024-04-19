<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     //Product View Page
    public function index()
    {
        $products = Product::latest()->where('status', 0)->paginate(5);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

     //Execute Create Product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');

            if ($image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('product_images'), $imageName);
                $imagePost = $imageName;
            }

            $imagePost = 'product_images/' . $imagePost;

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePost
        ]);

        return redirect()->back()->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

     //Execute Update Product
    public function update(Request $request, Product $product)
    {
        try {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');

            if ($image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('product_images'), $imageName);
                $imagePost = $imageName;
            }

            $imagePost = 'product_images/' . $imagePost;

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePost
        ]);

        return redirect()->back()->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

     //Execute Soft Delete Product
    public function destroy(Product $product)
    {
        $product->update([
            'status' => 1,
        ]);
        return redirect()->back()->with('success', 'Product deleted successfully');
    }

    //Execute Add Stock Product
    public function addStock(Request $request, Product $product) 
    {
        try {
            $request->validate([
                'stock' => 'required',
            ]);
    
            $product->update([
                'stock' => $product->stock + $request->stock,
            ]);
    
            return redirect()->back()->with('success', 'Stock added successfully.');
        }
        catch (\Exception $e) {
            dd($e);
        }
    }

    //Execute Product Generate Report
    public function export() 
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}
