<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MappingShift;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ActivityLog;
use App\Models\KategoriCuti;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Carbon\CarbonPeriod;
use DateTime;

class CutiUserController extends Controller
{
    public function index()
    {
        $user_id        = Auth()->user()->id;
        $user           = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        $userLevel      = DB::table('level_jabatans')->where('id', $user->level_id)->first();
        $levelatasan    = $userLevel->level_jabatan - 1;
        $levelatasan2    = $userLevel->level_jabatan - 2;
        $levelatasan3    = $userLevel->level_jabatan - 3;
        $IdLevelAsasan  = DB::table('level_jabatans')->where('level_jabatan', $levelatasan)->first();
        $IdLevelAsasan2  = DB::table('level_jabatans')->where('level_jabatan', $levelatasan2)->first();
        $IdLevelAsasan3  = DB::table('level_jabatans')->where('level_jabatan', $levelatasan3)->first();
        $getAsatan      = DB::table('jabatans')->where('level_id', $IdLevelAsasan->id)->where('divisi_id', $user->divisi_id)->first();
        $getAsatan2      = DB::table('jabatans')->where('level_id', $IdLevelAsasan2->id)->where('divisi_id', $user->divisi_id)->first();
        $getAsatan3      = DB::table('jabatans')->where('level_id', $IdLevelAsasan3->id)->where('divisi_id', $user->divisi_id)->first();
        $atasan  = User::with('jabatan')->where('jabatan_id', $getAsatan->id)->first();
        $atasan2  = User::with('jabatan')->where('jabatan_id', $getAsatan2->id)->first();
        $atasan3  = User::with('jabatan')->where('jabatan_id', $getAsatan3->id)->first();
        // dd($atasan2);
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
        if ($atasan2 == '' || $atasan2 == NULL) {
            // dd('atasan2 null');
            $atasan2_1  = User::with('jabatan')->where('jabatan1_id', $getAsatan2->id)->first();
            if ($atasan2_1 == NULL || $atasan2_1 == '') {
                // dd('jabatan 1 null');
                $getUseratasan2  = User::with('jabatan')->where('jabatan2_id', $getAsatan2->id)->first();
            } else {
                // dd('jabatan 1 not null');
                $getUseratasan2  = User::with('jabatan')->where('jabatan1_id', $getAsatan2->id)->first();
            }
        } else {
            $getUseratasan2  = User::with('jabatan')->where('jabatan_id', $getAsatan2->id)->first();
            // dd('atasan2 not null');
        }

        if ($atasan3 == '' || $atasan3 == NULL) {
            // dd('atasan3 null');
            $atasan3_1  = User::with('jabatan')->where('jabatan1_id', $getAsatan3->id)->first();
            if ($atasan3_1 == NULL || $atasan3_1 == '') {
                // dd('jabatan 1 null');
                $getUseratasan3  = User::with('jabatan')->where('jabatan2_id', $getAsatan3->id)->first();
            } else {
                // dd('jabatan 1 not null');
                $getUseratasan3  = User::with('jabatan')->where('jabatan1_id', $getAsatan3->id)->first();
            }
        } else {
            $getUseratasan3  = User::with('jabatan')->where('jabatan_id', $getAsatan3->id)->first();
            dd('atasan2 not null');
        }
        if ($getUseratasan2 == '' || $getUseratasan2 == NULL) {
            $getUseratasan2 = $getUseratasan3;
            // dd($getUseratasan2); 
        } else {
            $getUseratasan2 = $getUseratasan2;
        }
        // dd($getUseratasan2);
        // $getUserAtasan  = DB::table('users')->where('jabatan_id', $getAsatan->id)->first();
        $record_data    = DB::table('cutis')->where('user_id', Auth::user()->id)->join('kategori_cuti', 'kategori_cuti.id', 'cutis.nama_cuti')->orderBy('tanggal', 'DESC')->get();
        // dd($record_data);
        $get_kategori_cuti = KategoriCuti::where('status', 1)->get();
        $get_user_backup = User::where('dept_id', Auth::user()->dept_id)->where('divisi_id', Auth::user()->divisi_id)->where('id', '!=', Auth::user()->id)->get();
        // dd($get_user_backup);
        return view('users.cuti.index', [
            'title'             => 'Tambah Permintaan Cuti Karyawan',
            'data_user'         => $user,
            'data_cuti_user'    => Cuti::where('user_id', $user_id)->orderBy('id', 'desc')->get(),
            'getUserAtasan'     => $getUserAtasan,
            'getUseratasan2'     => $getUseratasan2,
            'get_user_backup'     => $get_user_backup,
            'get_kategori_cuti'     => $get_kategori_cuti,
            'user'              => $user,
            'record_data'       => $record_data
        ]);
    }

    public function cutiApprove($id)
    {
        $user   = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        $data   = DB::table('cutis')->join('users', 'users.id', '=', 'cutis.user_id')
            ->join('kategori_cuti', 'kategori_cuti.id', '=', 'cutis.nama_cuti')
            ->where('cutis.id', $id)->first();
        return view('users.cuti.approvecuti', [
            'user'  => $user,
            'data'  => $data
        ]);
    }
    public function cutiAbsen(Request $request)
    {
        // dd($request->all());
        $date1          = new DateTime($request->tanggal_mulai);
        $date2          = new DateTime($request->tanggal_selesai);
        $interval       = $date1->diff($date2);
        $data_interval  = $interval->days + 1;

        $folderPath     = public_path('storage/ttd_user/');
        $image_parts    = explode(";base64,", $request->ttd_user);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type     = $image_type_aux[1];
        $image_base64   = base64_decode($image_parts[1]);
        $file_save           = uniqid() . '.' . $image_type;
        $file           = $folderPath . $file_save;
        file_put_contents($file, $image_base64);
        // dd($data_interval);
        $hMin14         = date('Y-m-d', strtotime("+14 day", strtotime($request->tgl_pengajuan))); //2024-04-18
        $kuota_cuti     = DB::table('users')->where('id', $request->id_user)->first();
        // dd($file_save);
        if ($request->tanggal_mulai >= $hMin14) {
            if ($kuota_cuti->kuota_cuti >= $data_interval) {
                // dd('input cuti');
                if ($request->ttd_user != null) {
                    $ttd_user= $file_save;
                } else{
                    $ttd_user= NULL;

                }
                Cuti::create([
                    'user_id' => User::where('id', Auth::user()->id)->value('id'),
                    'nama_cuti' => KategoriCuti::where('id', $request->cuti)->value('nama_cuti'),
                    'tanggal' => date('Y-m-d H:i:s'),
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_selesai' => $request->tanggal_selesai,
                    'total_cuti' => $data_interval,
                    'keterangan_cuti' => $request->keterangan_cuti,
                    'foto_cuti' => NULL,
                    'status_cuti' => 0,
                    'user_id_backup' => $request->user_backup,
                    'ttd_user' => $ttd_user,
                    'approve_atasan' => 0,
                    'approve_atasan2' => 0,
                    'id_user_atasan' => User::where('id', $request->id_user_atasan)->value('id'),
                    'id_user_atasan2' => User::where('id', $request->id_user_atasan2)->value('id'),
                    'ttd_atasan' => NULL,
                    'ttd_atasan2' => NULL,
                    'waktu_approve' => NULL,
                    'waktu_approve2' => NULL,
                    'catatan' => NULL,
                    'catatan2' => NULL,
                ]);

                $request->session()->flash('Peringatan01', 'Berhasil');
                return redirect('cuti/dashboard');
            } else {
                $request->session()->flash('Peringatan01', 'Anda Tidak Memiliki Kuota Cuti');
                return redirect('cuti/dashboard');
            }
        } else {
            $request->session()->flash('Peringatan01', 'Pengajuan Harus H-14 untuk cuti');
            return redirect('cuti/dashboard');
        }
    }
    public function cutiApproveProses(Request $request, $id)
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
