<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class UserController extends Controller
{
    public function get_ini(){
        $data = DB::table('masyarakat')
                ->where('masyarakat.nik','=',Auth()->guard('web')->user()->nik)
                ->get();
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
