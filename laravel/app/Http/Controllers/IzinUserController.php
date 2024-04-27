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
use App\Models\LevelJabatan;
use DB;

class IzinUserController extends Controller
{
    public function index(Request $request)
    {
        $user_id        = Auth()->user()->id;
        $user = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('level_jabatans', 'jabatans.level_id', '=', 'level_jabatans.id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        if ($user->level_jabatan == 4) {
            $IdLevelAsasan  = LevelJabatan::where('level_jabatan', '3')->first();
            $IdLevelAsasan1  = LevelJabatan::where('level_jabatan', '2')->first();
            $IdLevelAsasan2  = LevelJabatan::where('level_jabatan', '1')->first();
            $atasan  = DB::table('users')
                ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
                ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                ->where('jabatans.level_id', $IdLevelAsasan->id)
                ->where('users.divisi_id', $user->divisi_id)
                ->where('is_admin', 'user')
                ->first();
            if ($atasan == '' || $atasan == NULL) {
                $atasan1  = DB::table('users')
                    ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
                    ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                    ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                    ->where('jabatans.level_id', $IdLevelAsasan1->id)
                    ->where('users.divisi_id', $user->divisi_id)
                    ->where('is_admin', 'user')
                    ->first();
                $getUserAtasan  = $atasan1;
                if ($atasan == '' || $atasan == NULL) {
                    $atasan2  = DB::table('users')
                        ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
                        ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                        ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                        ->where('jabatans.level_id', $IdLevelAsasan2->id)
                        ->where('users.divisi_id', $user->divisi_id)
                        ->where('is_admin', 'user')
                        ->first();
                    $getUserAtasan  = $atasan2;
                } else {
                    $getUserAtasan  = $atasan;
                }
            } else {
                $getUserAtasan  = $atasan;
            }
        } else if ($user->level_jabatan == 3) {
            $IdLevelAsasan  = LevelJabatan::where('level_jabatan', '2')->first();
            $IdLevelAsasan1  = LevelJabatan::where('level_jabatan', '1')->first();
            $atasan  = DB::table('users')
                ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
                ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                ->where('jabatans.level_id', $IdLevelAsasan->id)
                ->where('users.divisi_id', $user->divisi_id)
                ->where('is_admin', 'user')
                ->first();
            if ($atasan == '' || $atasan == NULL) {
                $atasan1  = DB::table('users')
                    ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
                    ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                    ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                    ->where('jabatans.level_id', $IdLevelAsasan1->id)
                    ->where('users.divisi_id', $user->divisi_id)
                    ->where('is_admin', 'user')
                    ->first();
                $getUserAtasan  = $atasan1;
            } else {
                $getUserAtasan  = $atasan;
            }
        } else if ($user->level_jabatan == 2) {
            $IdLevelAsasan  = LevelJabatan::where('level_jabatan', '1')->first();
            $atasan  = DB::table('users')
                ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
                ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                ->where('jabatans.level_id', $IdLevelAsasan->id)
                ->where('users.divisi_id', $user->divisi_id)
                ->where('is_admin', 'user')
                ->first();
            if ($atasan == '' || $atasan == NULL) {
                $getUserAtasan  = $atasan;
            } else {
                $getUserAtasan  = $atasan;
            }
        }

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
    public function izinEdit($id)
    {
        $user           = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        $get_izin_id = Izin::where('id', $id)->first();
        // dd($get_izin_id);
        return view(
            'users.izin.edit',
            [
                'user' => $user,
                'get_izin' => $get_izin_id,
            ]
        );
    }
    public function izinEditProses(Request $request)
    {
        if ($request->signature !== null) {
            $folderPath     = public_path('signature/');
            $image_parts    = explode(";base64,", $request->signature);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type     = $image_type_aux[1];
            $image_base64   = base64_decode($image_parts[1]);
            $uniqid         = date('y-m-d') . '-' . uniqid();
            $file           = $folderPath . $uniqid . '.' . $image_type;
            file_put_contents($file, $image_base64);
            $data                   = Izin::where('id', $request['id'])->first();
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
            $data->ttd_pengajuan    = $uniqid;
            $data->waktu_ttd_pengajuan    = date('Y-m-d');
            $data->status_izin      = 1;
            $data->update();
            Alert::success('Sukses', 'Data Berhasil di Dipdate');
            return redirect('/izin/dashboard')->with('success', 'Data Berhasil di Dipdate');
        } else {
            Alert::info('info', 'Tanda Tangan Harus Terisi');
            return redirect()->back()->with('info', 'Tanda Tangan Harus Terisi');
        }
    }

    public function izinAbsen(Request $request)
    {
        // dd($request->all());
        if ($request->id_user_atasan == NULL || $request->id_user_atasan == '') {
            $request->session()->flash('atasankosong');
            return redirect('/izin/dashboard');
        } else {

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
        $folderPath     = public_path('signature/');
        $image_parts    = explode(";base64,", $request->signature);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type     = $image_type_aux[1];
        $image_base64   = base64_decode($image_parts[1]);
        $uniqid         = date('y-m-d') . '-' . uniqid();
        $file           = $folderPath . $uniqid . '.' . $image_type;
        if ($request->signature != null) {
            $data = Izin::find($id);
            $data->status_izin  = 1;
            $data->catatan      = $request->catatan;
            $data->waktu_approve = date('Y-m-d H:i:s');
            $data->save();
            Alert::success('Sukses', 'Data Berhasil di Simpan');
            return redirect('/home')->with('success', 'Data Berhasil di Simpan');
        } else {
            Alert::info('info', 'Tanda Tangan Harus Terisi');
            return redirect()->back()->with('info', 'Tanda Tangan Harus Terisi');
        }
    }
}
