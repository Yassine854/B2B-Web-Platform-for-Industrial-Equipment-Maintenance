<?php

namespace App\Http\Controllers;

use App\Models\Pdr;
use App\Models\Assignment;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InterventionController extends Controller
{
    public function get_all_interventions()
    {
        $interventions = Intervention::with('assignment')->get();

        return response()->json([
            'interventions' => $interventions
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
        // Sample data for the intervention
        $interventionData = [
            'name' => $request->name,
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
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

        return "Intervention created successfully!";
    }


    // public function createIntervention(Request $request)
    // {
    //     // Sample data for the intervention
    //     $intervention=new Intervention();
    //     $intervention->name= $request->name;
    //     $intervention->client_id= $request->client_id;
    //     $intervention->product_id= $request->product_id;
    //     $intervention->date=$request->date;
    //     $intervention->description= $request->description;

    //     $intervention->save();

    //     $interventionId=$intervention->id;

    //     foreach($request->pieces as $piece){
    //         $pieceData = [
    //             'designation' => $piece->name,
    //             'reference' => $piece->client_id,
    //             'quantite' => $piece->product_id,
    //             'intervention_id' => $interventionId,
    //         ];

    //         DB::table('pdrs')->insert($pieceData);
    //     }


    //     return "Intervention created successfully!";
    // }

}
