<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(){
        $data = DB::table('pengaduan')
                // ->leftjoin('masyarakat','pengaduan.nik','=','masyarakat.nik')
                ->where('pengaduan.nik','=',Auth::guard('web')->user()->nik)
                ->orderByDesc('tgl_pengaduan')
                ->get();
        
        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }
}
