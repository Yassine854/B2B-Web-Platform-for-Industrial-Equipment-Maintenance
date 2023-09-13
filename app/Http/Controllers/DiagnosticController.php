<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Diagnostic;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiagnosticController extends Controller
{

    public function get_all_diagnostics()
{
    $diagnostics = Diagnostic::with(['pdrs', 'informations'])->get();

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
            'date' => [
                'required',
                'date',
            ],
            'informations' => 'required|array',
            'informations.*.def' => 'required|string',

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
        $DiagnosticData = [
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
            'date' => $request->date,
        ];

        // Insert the intervention and get the ID
        $diagnosticId = DB::table('diagnostics')->insertGetId($DiagnosticData);

        foreach ($request->informations as $information) {
            $infoData = [
                'def' => $information['def'],
                'description' => $information['description'],
                'image' => null, // Initialize with null
                'diagnostic_id' => $diagnosticId,
            ];

            if (isset($information['image']) && $information['image']->isValid()) {
                $image = $information['image'];

                // Generate a unique image name (e.g., timestamp + original name)
                $imageName = time() . '_' . $image->getClientOriginalName();

                // Store the image with the unique name
                $image->storeAs('public/img/diagnostics', $imageName);
                $infoData['image'] = $imageName;
            }

            // Insert diagnostic information
            DB::table('informations')->insert($infoData);
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
            'informations.*.def' => 'required|string',

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
        $DiagnosticData = [
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
            'date' => $request->date,
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

        return response()->json(['message' => 'Diagnostic updated successfully'], 200);
    }


    public function showDiagnostic($id)
    {
        $diagnostic = Diagnostic::with(['pdrs', 'informations'])->find($id);

        if (!$diagnostic) {
            return response()->json([
                'message' => 'diagnostic not found'
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

}
