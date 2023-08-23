<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Notifications\SimpleNotification;
class ProductController extends Controller
{

    public function get_products()
{
    $products = Product::with('type')->get();
    return response()->json([
        'products' => $products
    ], 200);
}



    public function createProduct(Request $request)
{
    $product = new Product();
    $product->name = $request->name;
    $product->type_prod = $request->type_prod;
    $product->debit = $request->debit;
    $product->unity_debit = $request->unity_debit;
    $product->pression = $request->pression;
    $product->year = $request->year;
    $product->time_day = $request->time_day;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $image->storeAs('public/img/pompes', $imageName);
        $product->image = $imageName;
    }

    $product->save();

    return response()->json(['message' => 'Product created successfully'], 201);
}


public function updateProduct(Request $request, $id)
{
    try {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }

    $product->name = $request->name;
    $product->type_prod = $request->type_prod;
    $product->debit = $request->debit;
    $product->unity_debit = $request->unity_debit;
    $product->pression = $request->pression;
    $product->year = $request->year;
    $product->time_day = $request->time_day;


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->storeAs('public/img/pompes', $imageName);
            $product->image = $imageName;
        }

        $product->update(); // Save the updated product

        return response()->json([
            'message' => 'Product updated successfully'
        ]);

    } catch (\Exception $error) {
        // Handle exceptions and return an error response
        return response()->json([
            'error' => 'An error occurred while updating the product'
        ], 500);
    }
}


public function showProduct($id){
    $product = Product::with('type')->find($id);
    return response()->json([
        'product' => $product
    ], 200);
}


public function deleteProduct($id){
    $product=Product::find($id);
    $product->delete();
    return response()->json('product deleted');
}


public function searchProduct(Request $request) {
    $search = $request->get('s');

    if ($search != null) {
        $products = Product::where(function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%")
            ->orWhere('id', 'LIKE', "%$search%");
        })->get();

        return response()->json([
            'products' => $products
        ], 200);
    } else {
        return $this->get_products();
    }
}

}
