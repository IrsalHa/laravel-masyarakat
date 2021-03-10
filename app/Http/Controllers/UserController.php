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

    public function get_UserNon(){
        $data = DB::table('masyarakat')
                ->where('status_user','=','nonAktif')
                ->get();
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function verif(Request $request){
        $request->validate([
            'nik' => 'required'
        ]);

        $data = DB::table('masyarakat')
                    ->where('nik','=',$request->nik)
                    ->update([
                        'status_user' => 'Aktif'
                    ]);
        return response()->json([
            'success' => true
        ]);
    }
}
