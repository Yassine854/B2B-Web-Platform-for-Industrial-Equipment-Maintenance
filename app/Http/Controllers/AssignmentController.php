<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Notifications\Notify;
use Illuminate\Validation\Rule;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Validator;
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

    $rules = [
        'client_id' => 'required|integer',
        'product_id' => 'required|integer',
        'c_huile' => 'nullable|integer',
        'c_filtre' => 'nullable|integer',
        'c_dehuil' => 'nullable|integer',
        'entretien' => 'nullable|integer',
    ];

    $messages = [
        'required' => 'Ce champ est requis.',
        'integer' => 'Ce champ doit être un entier.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }


    $assignment = new Assignment();
    $assignment->client_id = $request->client_id;
    $assignment->product_id = $request->product_id;
    $assignment->c_huile = $request->c_huile;
    $assignment->c_filtre = $request->c_filtre;
    $assignment->c_dehuil = $request->c_dehuil;
    $assignment->entretien = $request->entretien;

    $product = Product::where('id', $assignment->product_id)->first();
    $today=Carbon::now();
    //updatables
    if($assignment->c_huile){
        $huileDaysLeft=(int) $assignment->c_huile / (int) $product->time_day; //result in days
        $assignment->updated_c_huile = $today->copy()->addDays($huileDaysLeft);
    }
    if($assignment->c_filtre)
        {
        $filtreDaysLeft=(int) $assignment->c_filtre / (int) $product->time_day; //result in days
        $assignment->updated_c_filtre = $today->copy()->addDays($filtreDaysLeft);
        }
    if($assignment->c_dehuil)
        {
            $DeshuilDaysLeft=(int) $assignment->c_dehuil / (int) $product->time_day; //result in days
            $assignment->updated_c_dehuil = $today->copy()->addDays($DeshuilDaysLeft);
        }
    if($assignment->entretien)
        {
            $EntretienDaysLeft=(int) $assignment->entretien / (int) $product->time_day; //result in days
            $assignment->updated_entretien = $today->copy()->addDays($EntretienDaysLeft);
        }
    $assignment->save();

    $assignment->client()->attach($assignment->client_id); // Array of client IDs
    $assignment->product()->attach($assignment->product_id); // Array of product IDs
    return response()->json(['message' => 'Assignment created successfully'], 201);
}



public function updateAssignment(Request $request, $id)
{
    $rules = [
        'client_id' => 'required|integer',
        'product_id' => 'required|integer',
        'c_huile' => 'nullable|integer',
        'c_filtre' => 'nullable|integer',
        'c_dehuil' => 'nullable|integer',
        'entretien' => 'nullable|integer',
    ];

    $messages = [
        'required' => 'Ce champ est requis.',
        'integer' => 'Ce champ doit être un entier.',
    ];



    try {
        $assignment = Assignment::find($id);
        $today=Carbon::now();
        $product = Product::where('id', $assignment->product_id)->first();

        if (!$assignment) {
            return response()->json([
                'error' => 'Assignment not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $originalCHuile = $assignment->c_huile;
        $originalCFiltre = $assignment->c_filtre;
        $originalCDeHuile = $assignment->c_dehuil;
        $originalCEntretien = $assignment->entretien;

        $assignment->client_id = $request->client_id;
        $assignment->product_id = $request->product_id;
        $assignment->c_huile = $request->c_huile;
        $assignment->c_filtre = $request->c_filtre;
        $assignment->c_dehuil = $request->c_dehuil;
        $assignment->entretien = $request->entretien;

        //updatables

        // Check if c_huile was modified
        if ($originalCHuile !== $assignment->c_huile) {
            $huileDaysLeft=(int) $assignment->c_huile / (int) $product->time_day; //result in days
            $assignment->updated_c_huile = $today->copy()->addDays($huileDaysLeft);        }

        if ($originalCFiltre !== $assignment->c_filtre) {
            $filtreDaysLeft=(int) $assignment->c_filtre / (int) $product->time_day; //result in days
            $assignment->updated_c_filtre = $today->copy()->addDays($filtreDaysLeft);
        }
        if ($originalCDeHuile !== $assignment->c_dehuil) {
            $DeshuilDaysLeft=(int) $assignment->c_dehuil / (int) $product->time_day; //result in days
            $assignment->updated_c_dehuil = $today->copy()->addDays($DeshuilDaysLeft);
        }
        if ($originalCEntretien !== $assignment->entretien) {
            $EntretienDaysLeft=(int) $assignment->entretien / (int) $product->time_day; //result in days
            $assignment->updated_entretien = $today->copy()->addDays($EntretienDaysLeft);         }

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


public function updateHuile($id) {
    try {
        $today = Carbon::now();
        $assignment = Assignment::find($id);

        if (!$assignment) {
            return response()->json([
                'error' => 'Assignment not found',
            ], 404);
        }

        $product = Product::find($assignment->product_id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found',
            ], 404);
        }

        $huileDaysLeft = (int) $assignment->c_huile / (int) $product->time_day; //result in days
        $assignment->updated_c_huile = $today->copy()->addDays($huileDaysLeft);
        $assignment->save();

        return response()->json([
            'message' => 'Assignment updated successfully',
        ]);
    } catch (\Exception $e) {
        // Handle the error and provide an appropriate error message
        return response()->json([
            'error' => 'An error occurred while updating the assignment',
        ], 500);
    }
}



public function updateFiltre($id) {
    try {
        $today = Carbon::now();
        $assignment = Assignment::find($id);

        if (!$assignment) {
            return response()->json([
                'error' => 'Assignment not found',
            ], 404);
        }

        $product = Product::find($assignment->product_id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found',
            ], 404);
        }

        $FiltreDaysLeft = (int) $assignment->c_filtre / (int) $product->time_day; //result in days
        $assignment->updated_c_filtre = $today->copy()->addDays($FiltreDaysLeft);
        $assignment->save();

        return response()->json([
            'message' => 'Assignment updated successfully',
        ]);
    } catch (\Exception $e) {
        // Handle the error and provide an appropriate error message
        return response()->json([
            'error' => 'An error occurred while updating the assignment',
        ], 500);
    }
}

public function updateDeshuil($id) {
    try {
        $today = Carbon::now();
        $assignment = Assignment::find($id);

        if (!$assignment) {
            return response()->json([
                'error' => 'Assignment not found',
            ], 404);
        }

        $product = Product::find($assignment->product_id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found',
            ], 404);
        }

        $DehuilDaysLeft = (int) $assignment->c_dehuil / (int) $product->time_day; //result in days
        $assignment->updated_c_dehuil = $today->copy()->addDays($DehuilDaysLeft);
        $assignment->save();

        return response()->json([
            'message' => 'Assignment updated successfully',
        ]);
    } catch (\Exception $e) {
        // Handle the error and provide an appropriate error message
        return response()->json([
            'error' => 'An error occurred while updating the assignment',
        ], 500);
    }
}

public function updateEntretien($id) {
    try {
        $today = Carbon::now();
        $assignment = Assignment::find($id);

        if (!$assignment) {
            return response()->json([
                'error' => 'Assignment not found',
            ], 404);
        }
        $product = Product::find($assignment->product_id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found',
            ], 404);
        }

        $EntretienDaysLeft=(int) $assignment->entretien / (int) $product->time_day; //result in days
        $assignment->updated_entretien = $today->copy()->addDays($EntretienDaysLeft);
        $assignment->save();

        return response()->json([
            'message' => 'Assignment updated successfully',
        ]);
    } catch (\Exception $e) {
        // Handle the error and provide an appropriate error message
        return response()->json([
            'error' => 'An error occurred while updating the assignment',
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





public function search_product(Request $request)
{
    $search = $request->query('s');
    $assignmentId = $request->query('id');

    if ($search !== null) {
        $assignments = Assignment::where('product_id', 'LIKE', "%$search%")->get();

        return response()->json([
            'assignments' => $assignments
        ], 200);
    } else {
        return $this->get_assignments($assignmentId);
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
