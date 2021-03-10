<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function get_Petugas(){
        $data = DB::table('petugas')
                ->get();
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
