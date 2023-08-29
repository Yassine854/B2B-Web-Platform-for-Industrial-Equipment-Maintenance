<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use Illuminate\Http\Request;
use App\Models\Assignment;
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

}
