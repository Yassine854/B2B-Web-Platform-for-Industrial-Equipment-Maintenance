<?php

namespace App\Http\Controllers;

use App\Models\Pdr;
use App\Models\User;
use App\Models\Product;
use App\Models\Assignment;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ClientNotification;
use Illuminate\Support\Facades\Notification;

class InterventionController extends Controller
{
    public function get_all_interventions()
{
    $interventions = Intervention::with(['pdrs','diagnostic'])->get();

    return response()->json([
        'interventions' => $interventions
    ], 200);
}

public function getClientInterventions($id)
{
    $interventions = Intervention::with(['pdrs', 'diagnostic'])
    ->where('client_id', $id)
    ->get();
    return response()->json([
        'interventions' => $interventions
    ], 200);
}


public function getSocietyName($id)
{
    $client = User::find($id);

    if (!$client) {
        return response()->json(['message' => 'Client not found'], 404);
    }

    // Assuming your User model has a 'society' attribute
    $societyName = $client->society;

    return response()->json([
        'SocietyName' => $societyName,
    ], 200);
}


public function getProductName($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'product not found'], 404);
    }

    // Assuming your User model has a 'society' attribute
    $ProductName = $product->society;

    return response()->json([
        'ProductName' => $ProductName,
    ], 200);
}

    public function get_all_assignments()
    {
        $assignments = Assignment::with('client', 'product')->get();

        return response()->json([
            'assignments' => $assignments
        ], 200);
    }


    public function createIntervention(Request $request)
    {
        // Define the validation rules
        $rules = [
            'name' => 'required|string',
            'client_id' => 'required|integer',
            'product_id' => 'required|integer',
            'description' => 'nullable|string',
            'date' => [
                'required',
                'date',
            ],
            'pieces' => 'required|array',
            'pieces.*.designation' => 'required|string',
            'pieces.*.reference' => 'required|string',
            'pieces.*.quantite' => 'required|integer',
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Sample data for the intervention
        $interventionData = [
            'name' => $request->name,
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
            'diagnostic_id' => $request->diagnostic_id,
            'description' => $request->description,
            'date' => $request->date,
        ];

        $interventionId = DB::table('interventions')->insertGetId($interventionData);

        foreach ($request->pieces as $piece) {
            $pieceData = [
                'designation' => $piece['designation'],
                'reference' => $piece['reference'],
                'quantite' => $piece['quantite'],
                'intervention_id' => $interventionId,
            ];

            DB::table('pdrs')->insert($pieceData);
        }
        $client = User::where('id', $interventionData['client_id'])->where('role', 1)->first();
        $product = Product::where('id', $interventionData['product_id'])->first();
        $message="Une intervention pour la pompe ".$product->id."-".$product->name." a été effectué.";
        Notification::send($client,new ClientNotification($message,"info"));


        return "Intervention created successfully!";
    }

    public function updateIntervention(Request $request, $id)
    {
        // Define the validation rules
        $rules = [
            'name' => 'required|string',
            'client_id' => 'required|integer',
            'product_id' => 'required|integer',
            'description' => 'nullable|string',
            'date' => [
                'required',
                'date',
            ],
            'pieces' => 'required|array',
            'pieces.*.designation' => 'required|string',
            'pieces.*.reference' => 'required|string',
            'pieces.*.quantite' => 'required|integer',
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $interventionData = [
            'name' => $request->name,
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
            'diagnostic_id' => $request->diagnostic_id,
            'description' => $request->description,
            'date' => $request->date,
        ];

        DB::table('interventions')->where('id', $id)->update($interventionData);

        DB::table('pdrs')->where('intervention_id', $id)->delete();

        // Insert the updated pieces
        foreach ($request->pieces as $piece) {
            $pieceData = [
                'designation' => $piece['designation'],
                'reference' => $piece['reference'],
                'quantite' => $piece['quantite'],
                'intervention_id' => $id,
            ];

            DB::table('pdrs')->insert($pieceData);
        }

        return "Intervention updated successfully!";
    }


    public function deleteIntervention($id){
        $intervention=Intervention::find($id);
        $intervention->delete();
        return response()->json('intervention deleted');
    }


    public function showIntervention($id)
    {
        $intervention = Intervention::with(['pdrs','diagnostic'])->find($id);

        if (!$intervention) {
            return response()->json([
                'message' => 'Intervention not found'
            ], 404);
        }

        return response()->json([
            'intervention' => $intervention
        ], 200);
    }

    public function getInterventionCount()
{
    $interventionCount = Intervention::count();

    return response()->json(['interventionCount' => $interventionCount]);
}

}
