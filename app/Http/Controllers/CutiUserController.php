<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MappingShift;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Carbon\CarbonPeriod;

class CutiUserController extends Controller
{
    public function index()
    {
        $user_id        = Auth()->user()->id;
        $user           = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
                        ->join('departemens','departemens.id','=','users.dept_id')
                        ->join('divisis','divisis.id','=','users.divisi_id')
                        ->where('users.id', Auth()->user()->id)->first();
        $userLevel      = DB::table('level_jabatans')->where('id',$user->level_id)->first();
        $levelatasan    = $userLevel->level_jabatan - 1;
        $IdLevelAsasan  = DB::table('level_jabatans')->where('level_jabatan', $levelatasan)->first();
        $getAsatan      = DB::table('jabatans')->where('level_id',$IdLevelAsasan->id)->where('divisi_id', $user->divisi_id)->first();
        $getUserAtasan  = DB::table('users')->where('jabatan_id', $getAsatan->id)->first();
        $record_data    = DB::table('cutis')->where('user_id', Auth::user()->id)->join('kategori_cuti','kategori_cuti.id','cutis.nama_cuti')->orderBy('tanggal', 'DESC')->get();
        // dd($record_data);
        return view('users.cuti.index', [
            'title'             => 'Tambah Permintaan Cuti Karyawan',
            'data_user'         => $user,
            'data_cuti_user'    => Cuti::where('user_id', $user_id)->orderBy('id', 'desc')->get(),
            'getUserAtasan'     => $getUserAtasan,
            'user'              => $user,
            'record_data'       => $record_data
        ]);
    }

    public function cutiApprove($id)
    {
        $user   = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
                        ->join('departemens','departemens.id','=','users.dept_id')
                        ->join('divisis','divisis.id','=','users.divisi_id')
                        ->where('users.id', Auth()->user()->id)->first();
        $data   = DB::table('cutis')->join('users','users.id','=','cutis.user_id')
                        ->join('kategori_cuti','kategori_cuti.id','=','cutis.nama_cuti')
                        ->where('cutis.id',$id)->first();
        return view('users.cuti.approvecuti', [
            'user'  => $user,
            'data'  => $data
        ]);
    }

    public function cutiApproveProses(Request $request, $id)
    {
        dd($request->all());
        $folderPath     = public_path('upload/');
        $image_parts    = explode(";base64,", $request->ttd);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type     = $image_type_aux[1];
        $image_base64   = base64_decode($image_parts[1]);
        $file           = $folderPath . uniqid() . '.'.$image_type;
        file_put_contents($file, $image_base64);
        if($request->ttd != null){
            $data = Izin::find($id);
            $data->status_izin  = 1;
            $data->catatan      = $request->catatan;
            $data->waktu_approve= date('Y-m-d H:i:s');
            $data->save();
            return redirect('/home');
        }else{
            $data = Izin::find($id);
            $data->status_izin  = 3;
            $data->catatan      = $request->catatan;
            $data->waktu_approve= date('Y-m-d H:i:s');
            $data->save();
            return redirect('/home');
        }

        return back()->with('success', 'success Full upload signature');
    }

}
