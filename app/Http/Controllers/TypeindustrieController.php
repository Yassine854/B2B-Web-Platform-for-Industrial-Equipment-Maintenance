<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Typeindustrie;
use Illuminate\Support\Facades\Validator;

class TypeindustrieController extends Controller
{
    public function get_type_industries(){
        $type_industries=Typeindustrie::all();
        return response()->json([
            'type_industries'=>$type_industries
        ],200);
    }



    public function createType(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];

        $messages = [
            'required' => 'Ce champ est requis.',
            'string' => 'Ce champ doit être une chaîne de caractères.',
            'max' => 'Ce champ ne doit pas dépasser :max caractères.',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $request->validate([
            'name'=>'required',
        ]);


        $type_industrie = new Typeindustrie();
            $type_industrie->name = $request->name;
            $type_industrie->save();

        return response()->json([
            'message'=>'type_industrie created successfully'
        ]);
    }


    public function updateType(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];

        $messages = [
            'required' => 'Ce champ est requis.',
            'string' => 'Ce champ doit être une chaîne de caractères.',
            'max' => 'Ce champ ne doit pas dépasser :max caractères.',

        ];


        $type_industrie=Typeindustrie::find($id);

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $type_industrie->name = $request->name;
        $type_industrie->update();
        return response()->json([
            'message'=>'type_industrie updated successfully'
        ]);
    }

    public function deleteType($id){
        $type_industrie=Typeindustrie::find($id);
        $type_industrie->delete();
        return response()->json('type_industrie deleted');
    }



    public function searchType(Request $request) {
        $search = $request->get('s');

        if ($search != null) {
            $type_industries = Typeindustrie::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })->get();

            return response()->json([
                'type_industries' => $type_industries
            ], 200);
        } else {
            return $this->get_type_industries();
        }
    }

}
