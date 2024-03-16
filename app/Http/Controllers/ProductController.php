<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Notifications\SimpleNotification;
use Illuminate\Support\Facades\Validator;

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

    $rules = [
        'name' => 'required|string|max:255',
        'type_prod' => 'required|string|max:255',
        'debit' => 'required|string',
        'unity_debit' => 'required|string|max:255',
        'pression' => 'required|string',
        'year' => 'required|integer',
        'time_day' => 'required|integer|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
    ];

    $messages = [
        'required' => 'Ce champ est requis.',
        'string' => 'Ce champ doit être une chaîne de caractères.',
        'max' => 'Ce champ ne doit pas dépasser :max caractères.',
        'integer' => 'Ce champ doit être un entier.',
        'image' => 'Ce champ doit être une image au format jpeg, png, jpg ou gif.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }


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
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/img/pompes', $imageName);
        $product->image = $imageName;
    }

    $product->save();

    return response()->json(['message' => 'Product created successfully'], 201);
}


public function updateProduct(Request $request, $id)
{

    $rules = [
        'name' => 'required|string|max:255',
        'type_prod' => 'required|string|max:255',
        'debit' => 'required|string',
        'unity_debit' => 'required|string|max:255',
        'pression' => 'required|string',
        'year' => 'required|integer',
        'time_day' => 'required|integer|max:255',
    ];
    if ($request->hasFile('image')) {
        $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif';
    }

    $messages = [
        'required' => 'Ce champ est requis.',
        'string' => 'Ce champ doit être une chaîne de caractères.',
        'max' => 'Ce champ ne doit pas dépasser :max caractères.',
        'integer' => 'Ce champ doit être un entier.',
        'image' => 'Ce champ doit être une image au format jpeg, png, jpg ou gif.',

    ];


    try {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
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
            $imageName = time() . '_' . $image->getClientOriginalName();
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
        $products = Product::with('type')->where(function ($query) use ($search) {
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


public function searchSocieties($search) {

    if ($search != null) {
        $assignments = Assignment::with('client', 'product')
            ->where(function ($query) use ($search) {
                $query->where('client.society', 'LIKE', "%$search%");
            })
            ->get();

        return response()->json([
            'assignments' => $assignments
        ], 200);
    }
}


}
