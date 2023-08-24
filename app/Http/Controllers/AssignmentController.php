<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{

    public function get_all_assignments()
{
    $assignments = Assignment::with('client', 'product')->get();

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



public function updateAssignment(Request $request, $id)
{
    try {
        $assignment = Assignment::find($id);

        if (!$assignment) {
            return response()->json([
                'error' => 'Assignment not found'
            ], 404);
        }

        $assignment->client_id = $request->client_id;
        $assignment->product_id = $request->product_id;
        $assignment->c_huile = $request->c_huile;
        $assignment->c_filtre = $request->c_filtre;
        $assignment->c_dehuil = $request->c_dehuil;
        $assignment->entretien = $request->entretien;
        $assignment->update();

        return response()->json([
            'message' => 'assignment updated successfully'
        ]);

    } catch (\Exception $error) {
        // Handle exceptions and return an error response
        return response()->json([
            'error' => 'An error occurred while updating the assignment'
        ], 500);
    }
}


public function showAssignment($id){
    $assignment = Assignment::with('client', 'product')->find($id);
    return response()->json([
        'assignment' => $assignment
    ], 200);
}

public function deleteAssignment($id){
    $assignment=Assignment::find($id);
    $assignment->delete();
    return response()->json('assignment deleted');
}

}
