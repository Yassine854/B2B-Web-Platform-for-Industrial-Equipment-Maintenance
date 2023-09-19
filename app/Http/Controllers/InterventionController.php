<?php

namespace App\Http\Controllers;

use App\Models\Pdr;
use App\Models\User;
use App\Models\Product;
use App\Mail\MailNotify;
use App\Models\Assignment;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ClientNotification;
use Illuminate\Support\Facades\Validator;
use App\Notifications\SendEmailNotification;
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

//Charts
public function DonutChart()
{
    $interventions = DB::table('interventions')
    ->select('name', DB::raw('COUNT(*) as count'))
    ->groupBy('name')
    ->get();

    return response()->json([
        'interventions' => $interventions,
    ], 200);

}

public function ClientsBarChart()
{
    $interventions = DB::table('interventions')
        ->select('users.society as society', DB::raw('COUNT(*) as count'))
        ->join('users', 'interventions.client_id', '=', 'users.id')
        ->where('users.role', 1)
        ->groupBy('interventions.client_id', 'users.society')
        ->get();

    return response()->json([
        'interventions' => $interventions,
    ], 200);
}

public function MonthlyBarChart()
{
    $interventions = DB::table('interventions')
        ->select(DB::raw('YEAR(date) as year'), DB::raw('MONTH(date) as month'), DB::raw('COUNT(*) as count'))
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

    $data = [];

    foreach ($interventions as $intervention) {
        $year = $intervention->year;
        $month = $intervention->month;
        $count = $intervention->count;

        // Create an entry for the year if it doesn't exist
        if (!isset($data[$year])) {
            $data[$year] = [];
        }

        // Store the count for the month with the month index as the key
        $data[$year][$month] = $count;
    }

    return response()->json([
        'interventions' => $data,
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
            'description' => 'nullable|string|max:255',
            'diagnostic_id'=> 'nullable',
            'date' => [
                'required',
                'date',
            ],
            'pieces' => 'required|array',
            'pieces.*.designation' => 'required|string|max:255',
            'pieces.*.reference' => 'required|string|max:255',
            'pieces.*.quantite' => 'required|integer',
        ];

        $messages = [
            'required' => 'Ce champ est requis.',
            'integer' => 'Ce champ doit être un entier.',
            'date' => 'La date doit être au format valide.',
            'array' => 'Ce champ doit être un tableau.',
            'string' => 'Ce champ doit être une chaîne de caractères.',
            'max' => 'Ce champ ne doit pas dépasser :max caractères.',
            'pieces.required' => 'La définition des piéces est requise.',
            'pieces.array' => 'Le champ des pièces doit être un tableau et doit contenir au moins un élément.',
            'pieces.*.designation.required' => 'La désignation des pièces est requise.',
            'pieces.*.reference.required' => 'La référence des pièces est requise.',
            'pieces.*.quantite.required' => 'La quantité des pièces est requise.',
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules, $messages);

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

        //App notification
        $client = User::where('id', $interventionData['client_id'])->where('role', 1)->first();
        $product = Product::where('id', $interventionData['product_id'])->first();
        $message="Une intervention pour la pompe ".$product->id."-".$product->name." a été effectué.";
        Notification::send($client,new ClientNotification($message,"info"));

        //Email notification
        $details = new SendEmailNotification([
            'greeting' => 'Chère '.$client->society,
            'body' => 'Une intervention pour la pompe '.$product->id.'-'.$product->name. ' a été effectuée!',
            'actiontext' => 'Cliquez ici',
            'actionurl' => url(route('client_interventions')),
        ]);

        Notification::send($client,$details);


        return "Intervention created successfully!";
    }

    public function updateIntervention(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string',
            'client_id' => 'required|integer',
            'product_id' => 'required|integer',
            'description' => 'nullable|string|max:255',
            'diagnostic_id'=> 'nullable',
            'date' => [
                'required',
                'date',
            ],
            'pieces' => 'required|array',
            'pieces.*.designation' => 'required|string|max:255',
            'pieces.*.reference' => 'required|string|max:255',
            'pieces.*.quantite' => 'required|integer',
        ];

        $messages = [
            'required' => 'Ce champ est requis.',
            'integer' => 'Ce champ doit être un entier.',
            'date' => 'La date doit être au format valide.',
            'array' => 'Ce champ doit être un tableau.',
            'string' => 'Ce champ doit être une chaîne de caractères.',
            'max' => 'Ce champ ne doit pas dépasser :max caractères.',
            'pieces.required' => 'La définition des piéces est requise.',
            'pieces.array' => 'Le champ des pièces doit être un tableau et doit contenir au moins un élément.',
            'pieces.*.designation.required' => 'La désignation des pièces est requise.',
            'pieces.*.reference.required' => 'La référence des pièces est requise.',
            'pieces.*.quantite.required' => 'La quantité des pièces est requise.',
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules, $messages);

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

public function getNameCount()
{
    $interventions = DB::table('interventions')
        ->select('name', DB::raw('COUNT(name) as count'))
        ->groupBy('name')
        ->get();

    return response()->json([
        'interventions' => $interventions
    ], 200);
}


}
