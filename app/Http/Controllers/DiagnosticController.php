<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Diagnostic;
use App\Models\Information;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiagnosticController extends Controller
{

    public function get_all_diagnostics()
{
    $diagnostics = Diagnostic::with(['pdrs' => function ($query) {
        $query->whereNull('intervention_id');
    }, 'informations'])
    ->orderByDesc('id')
    ->get();

    return response()->json([
        'diagnostics' => $diagnostics
    ], 200);
}






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

    public function createDiagnostic(Request $request)
    {
        // Define the validation rules
        $rules = [
            'client_id' => 'required|integer',
            'product_id' => 'required|integer',
            'assignment_id' => 'required|integer',
            'date' => [
                'required',
                'date',
            ],
            'informations' => 'required|array',
            'informations.*.def' => 'required',
            'informations.*.description' => 'nullable|string|max:255',
            'informations.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif',

            'pieces' => 'required|array',
            'pieces.*.designation' => 'required|string|max:255',
            'pieces.*.reference' => 'required|string|max:255',
            'pieces.*.quantite' => 'required|numeric',

            'description' => 'nullable|string|max:255',
        ];


        $messages = [
            'required' => 'Ce champ est requis.',
            'integer' => 'Ce champ doit être un entier.',
            'date' => 'La date doit être au format valide.',
            'array' => 'Ce champ doit être un tableau.',
            'string' => 'Ce champ doit être une chaîne de caractères.',
            'max' => 'Ce champ ne doit pas dépasser :max caractères.',
            'informations.*.image' => 'Ce champ doit être une image au format jpeg, png, jpg ou gif.',
            'informations.required' => 'La définition des informations est requise.',
            'informations.array' => 'Le champ des informations doit être un tableau et doit contenir au moins un élément.',
            'informations.*.def.required' => 'Le champ défaut est requis.',
            'pieces.required' => 'La définition des piéces est requise.',
            'pieces.array' => 'Le champ des pièces doit être un tableau et doit contenir au moins un élément.',
            'pieces.*.designation.required' => 'La désignation des pièces est requise.',
            'pieces.*.reference.required' => 'La référence des pièces est requise.',
            'pieces.*.quantite.required' => 'La quantité des pièces est requise.',
            'pieces.*.quantite.numeric' => 'Ce champ doit être un nombre.',
        ];


    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }


        // Sample data for the intervention
        $DiagnosticData = [
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
            'assignment_id' => $request->assignment_id,
            'date' => $request->date,
            'description' => $request->description,

        ];

        // Insert the intervention and get the ID
        $diagnosticId = DB::table('diagnostics')->insertGetId($DiagnosticData);

        foreach ($request->informations as $information) {

            $info = new Information();
            $info->def = $information['def'];
            $info->description = $information['description'];
            $info->diagnostic_id = $diagnosticId;
            if (isset($information['image'])) {
                $image = $information['image'];
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/img/diagnostics', $imageName);
                $info->image = $imageName;
            }


            $info->save();



            // $infoData = [
            //     'def' => $information['def'],
            //     'description' => $information['description'],
            //     'image' => null, // Initialize with null
            //     'diagnostic_id' => $diagnosticId,
            // ];

            // if (isset($information['image']) ) {
            //     $image = $information['image'];

            //     // Generate a unique image name (e.g., timestamp + original name)
            //     $imageName = time() . '_' . $image->getClientOriginalName();

            //     // Store the image with the unique name
            //     $image->storeAs('public/img/diagnostics', $imageName);
            //     $infoData['image'] = $imageName;
            // }

            // // Insert diagnostic information
            // DB::table('informations')->insert($infoData);
        }

        foreach ($request->pieces as $piece) {
            $pieceData = [
                'designation' => $piece['designation'],
                'reference' => $piece['reference'],
                'quantite' => $piece['quantite'],
                'diagnostic_id' => $diagnosticId,
            ];

            // Insert pieces of spare parts
            DB::table('pdrs')->insert($pieceData);
        }

        return "Diagnostic created successfully!";
    }

    public function updateDiagnostic(Request $request,$id)
    {
        // Define the validation rules
        $rules = [
            'client_id' => 'required|integer',
            'product_id' => 'required|integer',
            'date' => [
                'required',
                'date',
            ],
            'informations' => 'required|array',
            'informations.*.def' => 'required',
            'informations.*.description' => 'nullable|string|max:255',
            'informations.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif',

            'pieces' => 'required|array',
            'pieces.*.designation' => 'required|string|max:255',
            'pieces.*.reference' => 'required|string|max:255',
            'pieces.*.quantite' => 'required|numeric',

            'description' => 'nullable|string|max:255',

        ];


        $messages = [
            'required' => 'Ce champ est requis.',
            'integer' => 'Ce champ doit être un entier.',
            'date' => 'La date doit être au format valide.',
            'array' => 'Ce champ doit être un tableau.',
            'string' => 'Ce champ doit être une chaîne de caractères.',
            'max' => 'Ce champ ne doit pas dépasser :max caractères.',
            'informations.*.image' => 'Ce champ doit être une image au format jpeg, png, jpg ou gif.',
            'informations.required' => 'La définition des informations est requise.',
            'informations.array' => 'Le champ des informations doit être un tableau et doit contenir au moins un élément.',
            'informations.*.def.required' => 'Le champ défaut est requis.',
            'pieces.required' => 'La définition des piéces est requise.',
            'pieces.array' => 'Le champ des pièces doit être un tableau et doit contenir au moins un élément.',
            'pieces.*.designation.required' => 'La désignation des pièces est requise.',
            'pieces.*.reference.required' => 'La référence des pièces est requise.',
            'pieces.*.quantite.required' => 'La quantité des pièces est requise.',
            'pieces.*.quantite.numeric' => 'Ce champ doit être un nombre.',

        ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }


        // Sample data for the intervention
        $DiagnosticData = [
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
            'assignment_id' => $request->assignment_id,
            'date' => $request->date,
            'description' => $request->description,

        ];

        DB::table('diagnostics')->where('id', $id)->update($DiagnosticData);



        DB::table('informations')->where('diagnostic_id', $id)->delete();

        DB::table('pdrs')->where('diagnostic_id', $id)->delete();

        foreach ($request->informations as $information) {
            $infoData = [
                'def' => $information['def'],
                'description' => $information['description'],
                'diagnostic_id' => $id,
            ];

            // Check if there's an image and it's valid
            if (isset($information['image']) && $information['image']->isValid()) {
                $image = $information['image'];

                // Generate a unique image name (e.g., timestamp + original name)
                $imageName = time() . '_' . $image->getClientOriginalName();

                // Store the image with the unique name
                $image->storeAs('public/img/diagnostics', $imageName);

                // Add the image path to the infoData array
                $infoData['image'] = $imageName;
            } elseif (isset($information['Currentimage']) && !empty($information['Currentimage'])) {
                // Use the existing image path if it exists
                $infoData['image'] = $information['Currentimage'];
            }

            // Insert diagnostic information
            DB::table('informations')->insert($infoData);
        }

        //Pieces de rechanges

        foreach ($request->pieces as $piece) {
            $pieceData = [
                'designation' => $piece['designation'],
                'reference' => $piece['reference'],
                'quantite' => $piece['quantite'],
                'diagnostic_id' => $id,
            ];

            // Insert pieces of spare parts
            DB::table('pdrs')->insert($pieceData);
        }

        $interventions=Intervention::where('diagnostic_id', $id)
        ->with(['pdrs','diagnostic'])
        ->get();

        if($interventions){
            foreach($interventions as $intervention){
                DB::table('pdrs')
            ->where('intervention_id', $intervention->id)
            ->where('diagnostic_id', $id)
            ->delete();


        // Insert the updated pieces
        foreach ($request->pieces as $piece) {
            $pieceData = [
                'designation' => $piece['designation'],
                'reference' => $piece['reference'],
                'quantite' => $piece['quantite'],
                'intervention_id' => $intervention->id,
                'diagnostic_id' => $id,
            ];

            DB::table('pdrs')->insert($pieceData);
        }


        }
        }

        return response()->json(['message' => 'Diagnostic updated successfully'], 200);
    }


    public function showDiagnostic($id)
{
    $diagnostic = Diagnostic::with(['pdrs' => function ($query) {
        $query->whereNull('intervention_id');
    }, 'informations'])
    ->find($id);

    if (!$diagnostic) {
        return response()->json([
            'message' => 'Diagnostic not found'
        ], 404);
    }

    return response()->json([
        'diagnostic' => $diagnostic
    ], 200);
}

    public function deleteDiagnostic($id){
        $diagnostic=Diagnostic::find($id);
        $diagnostic->delete();
        return response()->json('diagnostic deleted');
    }

    public function getDiagnosticCount()
{
    $diagnosticCount = Diagnostic::count();

    return response()->json(['diagnosticCount' => $diagnosticCount]);
}

}
