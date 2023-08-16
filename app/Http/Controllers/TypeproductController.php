<?php

namespace App\Http\Controllers;

use App\Models\Typeproduct;
use Illuminate\Http\Request;

class TypeproductController extends Controller
{
    public function get_type_products(){
        $type_products=Typeproduct::all();
        return response()->json([
            'type_products'=>$type_products
        ],200);
    }

    public function createType(Request $request)
    {
        $request->validate([
            'name'=>'required',
        ]);


        $type_product = new Typeproduct();
            $type_product->name = $request->name;
            $type_product->save();

        return response()->json([
            'message'=>'type_product created successfully'
        ]);
    }


    public function updateType(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
        ]);

        $type_product=Typeproduct::find($id);
        $type_product->name = $request->name;
        $type_product->update();
        return response()->json([
            'message'=>'type_product updated successfully'
        ]);
    }

    public function deleteType($id){
        $type_product=Typeproduct::find($id);
        $type_product->delete();
        return response()->json('type_product deleted');
    }



    public function searchType(Request $request) {
        $search = $request->get('s');

        if ($search != null) {
            $type_products = Typeproduct::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })->get();

            return response()->json([
                'type_products' => $type_products
            ], 200);
        } else {
            return $this->get_type_products();
        }
    }

}
