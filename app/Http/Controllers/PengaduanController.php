<?php

namespace App\Http\Controllers;
use DB;
use Carbon\Carbon;
use Auth;
use App\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(){
        $data = DB::table('pengaduan')
                ->where('pengaduan.nik','=',Auth::guard('web')->user()->nik)
                ->leftjoin('tanggapan','tanggapan.id_pengaduan','=','pengaduan.id_pengaduan')
                ->leftjoin('petugas','petugas.id_petugas','=','tanggapan.id_petugas')
                ->select('pengaduan.*',
                'tanggapan.id_tanggapan',
                'tanggapan.tgl_tanggapan',
                'tanggapan.tanggapan',
                'petugas.nama_petugas',
                'petugas.id_petugas')
                ->get();

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    public function update(Request $request){
        if($request->foto == "null"){
            $request->validate([
                'id_pengaduan' => 'required',
                'isi_laporan' => 'required'
            ]);
       
            $data = DB::table('pengaduan')
            ->where('pengaduan.id_pengaduan','=',$request->id_pengaduan)
            ->update(['isi_laporan' => $request->isi_laporan]);
    
        return response()->json([
            'success' => true
        ]);
        }
        if($request->file('foto') != null){
            $file = $request->file('foto');
            $tujuan_upload = 'data_file';
            $fileName = Carbon::now()->timestamp.'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($tujuan_upload,$fileName);
            unlink(public_path().Pengaduan::find($request->id_pengaduan)->value('foto'));
            $data = DB::table('pengaduan')
                    ->where('pengaduan.id_pengaduan','=',$request->id_pengaduan)
                    ->update(['isi_laporan' => $request->isi_laporan,
                                'foto' => '/data_file/'.$fileName]);
            
                return response()->json([
                    'success' => true
                ]);
        }
    
    }

    public function delete(Request $request){
        $request->validate([
            'id_pengaduan' => 'required',
            'foto' => 'required'
        ]);
        

        $data = DB::table('pengaduan')
                ->where('id_pengaduan','=',$request->id_pengaduan)
                ->delete();

        unlink(public_path().$request->foto);

        return response()->json([
            'success' => true
        ],200);
    }

    public function buat(Request $request){
        $request->validate([
            'isi_laporan' => 'required',
            'foto' => 'image'
        ]);

        $file = $request->file('foto');
        $tujuan_upload = 'data_file';
        $fileName = Carbon::now()->timestamp.'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($tujuan_upload,$fileName);

        $data = DB::table('pengaduan')
                ->insert([
                    'isi_laporan' => $request->isi_laporan,
                    'foto' => '/data_file/'.$fileName,
                    'nik' => Auth()->guard('web')->user()->nik,
                    'tgl_pengaduan' => Carbon::now()->toDateString(),
                    'status' => '0'
                ]);

        return response()->json([
            'success' => true
        ],200);
    }
}
