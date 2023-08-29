<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\User;
use App\Models\Product;
use App\Notifications\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;



class AssignmentController extends Controller
{

    public function get_all_assignments()
    {
        $assignments = Assignment::with('client', 'product')->get();

        $groupedAssignments = $assignments->groupBy('client_id')->map(function ($group) {
            $firstAssignment = $group->first();
            return [
                'client' => $firstAssignment->client,
                'assignments' => $group,
            ];
        })->values();

        return response()->json([
            'assignments' => $groupedAssignments
        ], 200);
    }

    public function get_assignments($id)
    {
        $assignments = Assignment::with('client', 'product')->get();

        $groupedAssignments = $assignments->groupBy('client_id')->map(function ($group) {
            $firstAssignment = $group->first();
            return [
                'client' => $firstAssignment->client,
                'assignments' => $group,
            ];
        })->values();

        return response()->json([
            'assignments' => $groupedAssignments[$id]
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

    $assignment->client()->attach($assignment->client_id); // Array of client IDs
    $assignment->product()->attach($assignment->product_id); // Array of product IDs

    //Client notification
    $product = Product::where('id', $assignment->product_id)->first();
    $client = User::where('id', $assignment->client_id)->get();

    $date_huile = intval($assignment->c_huile) / (intval($product->time_day) * 365);
    $totalDays_huile = (365/$date_huile);

    if($date_huile>=1){
        $message="changement de huile dans ".floor($date_huile)." an(s) et " .round(($date_huile-floor($date_huile))*10). " moi(s).";
    }
    if($date_huile<1)
        $message="changement de huile dans ".round($date_huile*10)." moi(s).";
    if($date_huile<0.1)
        $message="changement de huile dans ".round($date_huile/0.0033333)." jour(s).";

    Notification::send($client,new Notify($message));

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

        $originalCHuile = $assignment->c_huile;

        $assignment->client_id = $request->client_id;
        $assignment->product_id = $request->product_id;
        $assignment->c_huile = $request->c_huile;
        $assignment->c_filtre = $request->c_filtre;
        $assignment->c_dehuil = $request->c_dehuil;
        $assignment->entretien = $request->entretien;


        // Check if c_huile was modified
        if ($originalCHuile !== $assignment->c_huile) {
            $assignment->updated_c_huile = now(); // Set the updated_c_huile timestamp
        }

        $assignment->update();


        $assignment->client()->sync($assignment->client_id);
        $assignment->product()->sync($assignment->product_id);

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

public function search_society(Request $request)
{
    $search = $request->get('s');

    if ($search !== null) {
        $assignments = Assignment::with('client')->where(function ($query) use ($search) {
            $query->whereHas('client', function ($clientQuery) use ($search) {
                $clientQuery->where('society', 'LIKE', "%$search%");
            });
        })->get();

        return response()->json([
            'assignments' => $assignments
        ], 200);
    } else {
        return $this->get_all_assignments();
    }
}




//Client side

public function get_client_assignments($id)
{
    $ClientAssignments = Assignment::with('client', 'product')->where('client_id', $id)->get();

    return response()->json([
        'ClientAssignments' => $ClientAssignments
    ], 200);
}



}
