<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{

    public function get_assignments()
    {
        $assignments = Assignment::with('client_id','product_id')->get();
        return response()->json([
            'assignments' => $assignments
        ], 200);
    }


    public function get_all_clients()
    {
        $clients = User::where('role', 1)->get();
        return response()->json([
            'clients' => $clients
        ], 200);
    }

    public function get_all_products()
    {
        $products = Product::all();
        return response()->json([
            'products' => $products
        ], 200);
    }


    public function createAssignment(Request $request)
{
    $assignment = new Assignment();
    $assignment->client_id = $request->client_id;
    $assignment->product_id = $request->product_id;
    $assignment->c_huile = $request->c_huile;
    $assignment->c_filtre = $request->c_filtre;
    $assignment->c_dehuil = $request->c_dehuil;
    $assignment->entretien = $request->entretien;
    $assignment->save();

    return response()->json(['message' => 'Assignment created successfully'], 201);
}


}
