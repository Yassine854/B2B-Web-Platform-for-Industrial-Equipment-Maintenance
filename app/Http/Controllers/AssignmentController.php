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
        $clients = User::where('role', 1)->where('disabled', false)->get();
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
        'ch_palette' => 'nullable|integer',
        'insp_palette' => 'nullable|integer',
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
    $assignment->date = $request->date;
    $assignment->c_huile = $request->c_huile;
    $assignment->c_filtre = $request->c_filtre;
    $assignment->c_dehuil = $request->c_dehuil;
    $assignment->entretien = $request->entretien;
    $assignment->ch_palette = $request->ch_palette;
    $assignment->insp_palette = $request->insp_palette;

    $product = Product::where('id', $assignment->product_id)->first();
    $today=Carbon::now();
    //updatables
    if($assignment->c_huile){
        $huileDaysLeft=(int) $assignment->c_huile / (int) $product->time_day; //result in days

        if(isset($assignment->date))
            $assignment->updated_c_huile = Carbon::parse($assignment->date)->addDays($huileDaysLeft);
        else
            $assignment->updated_c_huile = $today->copy()->addDays($huileDaysLeft);
    }
    if($assignment->c_filtre)
        {
        $filtreDaysLeft=(int) $assignment->c_filtre / (int) $product->time_day; //result in days

        if(isset($assignment->date))
            $assignment->updated_c_filtre = Carbon::parse($assignment->date)->addDays($filtreDaysLeft);
        else
            $assignment->updated_c_filtre = $today->copy()->addDays($filtreDaysLeft);
        }
    if($assignment->c_dehuil)
        {
            $DeshuilDaysLeft=(int) $assignment->c_dehuil / (int) $product->time_day; //result in days

        if(isset($assignment->date))
            $assignment->updated_c_dehuil = Carbon::parse($assignment->date)->addDays($DeshuilDaysLeft);
        else
            $assignment->updated_c_dehuil = $today->copy()->addDays($DeshuilDaysLeft);
        }
    if($assignment->entretien)
        {
            $EntretienDaysLeft=(int) $assignment->entretien / (int) $product->time_day; //result in days

        if(isset($assignment->date))
            $assignment->updated_entretien = Carbon::parse($assignment->date)->addDays($EntretienDaysLeft);
        else
        $assignment->updated_entretien = $today->copy()->addDays($EntretienDaysLeft);
        }

        if($assignment->ch_palette){
            $ch_paletteDaysLeft=(int) $assignment->ch_palette / (int) $product->time_day; //result in days

            if(isset($assignment->date))
                $assignment->updated_ch_palette = Carbon::parse($assignment->date)->addDays($ch_paletteDaysLeft);
            else
                $assignment->updated_ch_palette = $today->copy()->addDays($ch_paletteDaysLeft);
        }

        if($assignment->insp_palette){
            $insp_paletteDaysLeft=(int) $assignment->insp_palette / (int) $product->time_day; //result in days

            if(isset($assignment->date))
                $assignment->updated_insp_palette = Carbon::parse($assignment->date)->addDays($insp_paletteDaysLeft);
            else
                $assignment->updated_insp_palette = $today->copy()->addDays($insp_paletteDaysLeft);
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
        'ch_palette' => 'nullable|integer',
        'insp_palette' => 'nullable|integer',
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
        $originalChPalette = $assignment->ch_palette;
        $originalInspPalette = $assignment->insp_palette;

        $assignment->client_id = $request->client_id;
        $assignment->product_id = $request->product_id;
        $assignment->date = $request->date;
        $assignment->c_huile = $request->c_huile;
        $assignment->c_filtre = $request->c_filtre;
        $assignment->c_dehuil = $request->c_dehuil;
        $assignment->entretien = $request->entretien;
        $assignment->ch_palette = $request->ch_palette;
        $assignment->insp_palette = $request->insp_palette;

        //updatables

        // Check if c_huile was modified
        if ($originalCHuile !== $assignment->c_huile) {
            $huileDaysLeft=(int) $assignment->c_huile / (int) $product->time_day; //result in days
            if(isset($assignment->date))
                $assignment->updated_c_huile = Carbon::parse($assignment->date)->addDays($huileDaysLeft);
            else
                $assignment->updated_c_huile = $today->copy()->addDays($huileDaysLeft);
            }

        if ($originalCFiltre !== $assignment->c_filtre) {
            $filtreDaysLeft=(int) $assignment->c_filtre / (int) $product->time_day; //result in days

            if(isset($assignment->date))
                $assignment->updated_c_filtre = Carbon::parse($assignment->date)->addDays($filtreDaysLeft);
            else
                $assignment->updated_c_filtre = $today->copy()->addDays($filtreDaysLeft);
        }

        if ($originalChPalette !== $assignment->ch_palette) {
            $ch_paletteDaysLeft=(int) $assignment->ch_palette / (int) $product->time_day; //result in days

            if($assignment->ch_palette){

                if(isset($assignment->date))
                    $assignment->updated_ch_palette = Carbon::parse($assignment->date)->addDays($ch_paletteDaysLeft);
                else
                    $assignment->updated_ch_palette = $today->copy()->addDays($ch_paletteDaysLeft);
            }
        }

        if ($originalInspPalette !== $assignment->insp_palette) {
            $insp_paletteDaysLeft=(int) $assignment->insp_palette / (int) $product->time_day; //result in days

        if($assignment->insp_palette){

            if(isset($assignment->date))
                $assignment->updated_insp_palette = Carbon::parse($assignment->date)->addDays($insp_paletteDaysLeft);
            else
                $assignment->updated_insp_palette = $today->copy()->addDays($insp_paletteDaysLeft);
        }
    }


        if ($originalCDeHuile !== $assignment->c_dehuil) {
            $DeshuilDaysLeft=(int) $assignment->c_dehuil / (int) $product->time_day; //result in days

            if(isset($assignment->date))
                $assignment->updated_c_dehuil = Carbon::parse($assignment->date)->addDays($DeshuilDaysLeft);
            else
                $assignment->updated_c_dehuil = $today->copy()->addDays($DeshuilDaysLeft);
        }
        if ($originalCEntretien !== $assignment->entretien) {
            $EntretienDaysLeft=(int) $assignment->entretien / (int) $product->time_day; //result in days

            if(isset($assignment->date))
                $assignment->updated_entretien = Carbon::parse($assignment->date)->addDays($EntretienDaysLeft);
            else
                $assignment->updated_entretien = $today->copy()->addDays($EntretienDaysLeft);
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


public function updateHuile(Request $request,$id) {
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
        $assignment->date = $request->date;

        $huileDaysLeft = (int) $assignment->c_huile / (int) $product->time_day; //result in days

        if(isset($assignment->date))
            $assignment->updated_c_huile = Carbon::parse($assignment->date)->copy()->addDays($huileDaysLeft);

        else
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



public function updateFiltre( Request $request, $id ) {
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
        $assignment->date = $request->date;

        $FiltreDaysLeft = (int) $assignment->c_filtre / (int) $product->time_day; //result in days

        if(isset($assignment->date))
            $assignment->updated_c_filtre = Carbon::parse($assignment->date)->addDays($FiltreDaysLeft);
        else
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

public function updateDeshuil(Request $request,$id) {
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
        $assignment->date = $request->date;

        $DehuilDaysLeft = (int) $assignment->c_dehuil / (int) $product->time_day; //result in days

        if(isset($assignment->date))
            $assignment->updated_c_dehuil = Carbon::parse($assignment->date)->addDays($DehuilDaysLeft);
        else
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

public function updateEntretien(Request $request,$id) {
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
        $assignment->date = $request->date;

        $EntretienDaysLeft=(int) $assignment->entretien / (int) $product->time_day; //result in days

        if(isset($assignment->date))
            $assignment->updated_entretien = Carbon::parse($assignment->date)->addDays($EntretienDaysLeft);
        else
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


public function updateChangerPalette(Request $request,$id) {
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
        $assignment->date = $request->date;

        $ch_paletteDaysLeft=(int) $assignment->ch_palette / (int) $product->time_day; //result in days

        if(isset($assignment->date))
            $assignment->updated_ch_palette = Carbon::parse($assignment->date)->addDays($ch_paletteDaysLeft);
        else
            $assignment->updated_ch_palette = $today->copy()->addDays($ch_paletteDaysLeft);
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


public function updateInspecterPalette(Request $request,$id) {
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
        $assignment->date = $request->date;

        $insp_paletteDaysLeft=(int) $assignment->insp_palette / (int) $product->time_day; //result in days

        if(isset($assignment->date))
            $assignment->updated_insp_palette = Carbon::parse($assignment->date)->addDays($insp_paletteDaysLeft);
        else
            $assignment->updated_insp_palette = $today->copy()->addDays($insp_paletteDaysLeft);
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
