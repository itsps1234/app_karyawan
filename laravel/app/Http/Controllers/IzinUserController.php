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
use App\Models\Jabatan;
use App\Models\Izin;
use App\Models\Departemen;
use App\Models\Divisi;
use DB;

class IzinUserController extends Controller
{
    public function index(Request $request)
    {
        $user_id        = Auth()->user()->id;
        $user           = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        $userLevel      = DB::table('level_jabatans')->where('id', $user->level_id)->first();
        $levelatasan    = $userLevel->level_jabatan - 1;
        $IdLevelAsasan  = DB::table('level_jabatans')->where('level_jabatan', $levelatasan)->first();
        $getAsatan      = DB::table('jabatans')->where('level_id', $IdLevelAsasan->id)->where('divisi_id', $user->divisi_id)->first();
        // $getAsatan      = User::with('Jabatan')->where('id', Auth::user()->id)->first();
        $atasan  = User::with('jabatan')->where('jabatan_id', $getAsatan->id)->first();
        // dd($atasan);
        if ($atasan == '' || $atasan == NULL) {
            // dd('atasan null');
            $atasan1  = User::with('jabatan')->where('jabatan1_id', $getAsatan->id)->first();
            if ($atasan1 == NULL || $atasan1 == '') {
                // dd('jabatan 1 null');
                $getUserAtasan  = User::with('jabatan')->where('jabatan2_id', $getAsatan->id)->first();
            } else {
                // dd('jabatan 1 not null');
                $getUserAtasan  = User::with('jabatan')->where('jabatan1_id', $getAsatan->id)->first();
            }
        } else {
            $getUserAtasan  = User::with('jabatan')->where('jabatan_id', $getAsatan->id)->first();
            // dd('atasan not null');
        }
        // dd($getUserAtasan);
        $record_data    = DB::table('izins')->where('user_id', Auth::user()->id)->orderBy('tanggal', 'DESC')->get();
        return view('users.izin.index', [
            'title'             => 'Tambah Permintaan Cuti Karyawan',
            'data_user'         => $user,
            'data_cuti_user'    => Cuti::where('user_id', $user_id)->orderBy('id', 'desc')->get(),
            'getUserAtasan'     => $getUserAtasan,
            'user'              => $user,
            'record_data'       => $record_data
        ]);
    }

    public function izinAbsen(Request $request)
    {
        // dd($request->all());
        $data                   = new Izin();
        $data->user_id          = $request->id_user;
        $data->departements_id  = Departemen::where('id', $request["departements"])->value('id');
        $data->jabatan_id       = Jabatan::where('id', $request["jabatan"])->value('id');
        $data->divisi_id        = Divisi::where('id', $request["divisi"])->value('id');
        $data->telp             = $request->telp;
        $data->email            = $request->email;
        $data->fullname         = $request->fullname;
        $data->izin             = $request->izin;
        $data->tanggal          = $request->tanggal;
        $data->jam              = $request->jam;
        $data->keterangan_izin  = $request->keterangan_izin;
        $data->approve_atasan   = $request->approve_atasan;
        $data->id_approve_atasan = $request->id_user_atasan;
        $data->status_izin      = 0;
        $data->ttd_atasan      = NULL;
        $data->waktu_approve      = NULL;
        $data->save();
        return redirect('/izin/dashboard')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function izinApprove($id)
    {
        $user   = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        $data   = DB::table('izins')->where('id', $id)->first();
        return view('users.izin.approveizin', [
            'user'  => $user,
            'data'  => $data
        ]);
    }

    public function izinApproveProses(Request $request, $id)
    {
        // dd($request->all());
        $folderPath     = public_path('upload/');
        $image_parts    = explode(";base64,", $request->ttd);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type     = $image_type_aux[1];
        $image_base64   = base64_decode($image_parts[1]);
        $file           = $folderPath . uniqid() . '.' . $image_type;
        file_put_contents($file, $image_base64);
        if ($request->ttd != null) {
            $data = Izin::find($id);
            $data->status_izin  = 1;
            $data->catatan      = $request->catatan;
            $data->waktu_approve = date('Y-m-d H:i:s');
            $data->save();
            return redirect('/home');
        } else {
            $data = Izin::find($id);
            $data->status_izin  = 3;
            $data->catatan      = $request->catatan;
            $data->waktu_approve = date('Y-m-d H:i:s');
            $data->save();
            return redirect('/home');
        }

        return back()->with('success', 'success Full upload signature');
    }
}
