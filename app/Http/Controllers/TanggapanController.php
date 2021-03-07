<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use Carbon\Carbon;
use App\Tanggapan;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{

    public function tanggapi(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'id_pengaduan' => 'required',
            'tanggapan' => 'required|not_in:null'
        ]);
        
        $data = Tanggapan::updateOrCreate(
            ['id_tanggapan' => $request->id_tanggapan == "null" ? 0 : $request->id_tanggapan],
                ['id_pengaduan' => $request->id_pengaduan,
                'tgl_tanggapan' => carbon::now()->toDateString(),
                'tanggapan' => $request->tanggapan,
                'id_petugas' => Auth()->guard('petugas')->user()->id_petugas
                ]
                );
        $data2 = DB::table('pengaduan')
                ->where('id_pengaduan','=',$request->id_pengaduan)
                ->update([
                    'status' => $request->status
                ]);
            
        return response()->json([
            'success' => true
        ],200);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id_tanggapan' => 'required',
            'id_pengaduan' => 'required'
        ]);

        $data = DB::table('tanggapan')
                    ->where('id_tanggapan','=',$request->id_tanggapan)
                    ->delete();
        $data2 = DB::table('pengaduan')
                    ->where('id_pengaduan','=',$request->id_pengaduan)
                    ->update([
                        'status' => '0'
                    ]);
        return response()->json([
            'success' => true
        ],200);
    }
}
