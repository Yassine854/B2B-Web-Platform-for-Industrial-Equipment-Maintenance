<?php

namespace App\Http\Controllers;

use App\Models\Typeindustrie;
use Illuminate\Http\Request;
class TypeindustrieController extends Controller
{
    public function get_type_industries(){
        $type_industries=Typeindustrie::all();
        return response()->json([
            'type_industries'=>$type_industries
        ],200);
    }
}
