<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Departemen;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MappingShift;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ActivityLog;
use App\Models\KategoriCuti;
use App\Models\LevelJabatan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Carbon\CarbonPeriod;
use DateTime;

class PenugasanController extends Controller
{
    public function index()
    {
        $user_id        = Auth()->user()->id;
        $user           = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        $userLevel      = LevelJabatan::where('id', $user->level_id)->first();
        // dd($userLevel->level_jabatan);
        if ($userLevel->level_jabatan >= 3) {
            $levelatasan    = $userLevel->level_jabatan - 1;
            $levelatasan2    = $userLevel->level_jabatan - 2;
            $levelatasan3    = $userLevel->level_jabatan - 3;
            $IdLevelAsasan   = DB::table('level_jabatans')->where('level_jabatan', $levelatasan)->first();
            $IdLevelAsasan2  = DB::table('level_jabatans')->where('level_jabatan', $levelatasan2)->first();
            $IdLevelAsasan3  = DB::table('level_jabatans')->where('level_jabatan', $levelatasan3)->first();
            $getAsatan       = DB::table('jabatans')->where('level_id', $IdLevelAsasan->id)->where('divisi_id', $user->divisi_id)->first();
            $getAsatan2      = DB::table('jabatans')->where('level_id', $IdLevelAsasan2->id)->where('divisi_id', $user->divisi_id)->first();
            $getAsatan3      = DB::table('jabatans')->where('level_id', $IdLevelAsasan3->id)->where('divisi_id', $user->divisi_id)->first();
            $atasan          = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan->id)->orWhere('jabatan1_id', $getAsatan->id)->orWhere('jabatan2_id', $getAsatan->id)->orWhere('jabatan3_id', $getAsatan->id)->orWhere('jabatan4_id', $getAsatan->id)->first();
            $atasan2         = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan2->id)->orWhere('jabatan1_id', $getAsatan->id)->orWhere('jabatan2_id', $getAsatan->id)->orWhere('jabatan3_id', $getAsatan->id)->orWhere('jabatan4_id', $getAsatan->id)->first();
            $atasan3         = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan3->id)->orWhere('jabatan1_id', $getAsatan->id)->orWhere('jabatan2_id', $getAsatan->id)->orWhere('jabatan3_id', $getAsatan->id)->orWhere('jabatan4_id', $getAsatan->id)->first();
            // dd($atasan);
            if ($atasan == '' || $atasan == NULL) {
                $getUserAtasan = $atasan2;
                $getUseratasan2 = $atasan3;
                // dd('atasan null');
                if ($getUserAtasan == NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasan3;
                    $getUseratasan2 = $atasan3;
                    // atasan bertingkat 4
                } else if ($getUserAtasan == NULL && $getUseratasan2 != NULL) {
                    $getUserAtasan = $atasan3;
                    $getUseratasan2 = $atasan3;
                } else if ($getUserAtasan != NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasan2;
                    $getUseratasan2 = $atasan2;
                } else if ($getUserAtasan != NULL && $getUseratasan2 != NULL) {
                    $getUserAtasan = $atasan2;
                    $getUseratasan2 = $atasan3;
                }
            } else if ($atasan2 == '' && $atasan2 == NULL) {
                $getUserAtasan = $atasan;
                $getUseratasan2 = $atasan3;
                // dd('atasan null');
                if ($getUserAtasan == NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasan3;
                    $getUseratasan2 = $atasan3;
                    // atasan bertingkat 4
                } else if ($getUserAtasan == NULL && $getUseratasan2 != NULL) {
                    $getUserAtasan = $atasan3;
                    $getUseratasan2 = $atasan3;
                } else if ($getUserAtasan != NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasan;
                    $getUseratasan2 = $atasan;
                } else if ($getUserAtasan != NULL && $getUseratasan2 != NULL) {
                    // dd('atasan null');
                    $getUserAtasan = $atasan;
                    $getUseratasan2 = $atasan3;
                }
            } else {
                $getUserAtasan = $atasan;
                $getUseratasan2 = $atasan2;
            }
        } else {
            dd('gak oke');
        }
        $record_data        = DB::table('penugasans')->join('users', 'users.id', 'penugasans.id_user')->where('id_user', Auth::user()->id)
            ->select('penugasans.*', 'users.fullname')->orderBy('tanggal_pengajuan', 'DESC')->get();
        $get_kategori_cuti  = KategoriCuti::where('status', 1)->get();
        $get_user_backup    = User::where('dept_id', Auth::user()->dept_id)->where('divisi_id', Auth::user()->divisi_id)->where('id', '!=', Auth::user()->id)->get();
        return view('users.penugasan.index', [
            'title'                 => 'Tambah Permintaan Cuti Karyawan',
            'data_user'             => $user,
            'data_cuti_user'        => Penugasan::where('id_user', $user_id)->orderBy('id', 'desc')->get(),
            'getUserAtasan'         => $getUserAtasan,
            'getUseratasan2'        => $getUseratasan2,
            'get_user_backup'       => $get_user_backup,
            'get_kategori_cuti'     => $get_kategori_cuti,
            'user'                  => $user,
            'record_data'           => $record_data
        ]);
    }

    public function tambahPenugasan(Request $request)
    {
        $date_now = date("Y-m-d");
        if ($request->tanggal_kunjungan > $date_now  || $request->tanggal_kunjungan = $date_now) {
            Penugasan::create([
                'id_user'                       => User::where('id', Auth::user()->id)->value('id'),
                'id_user_atasan'                => User::where('id', $request->id_user_atasan)->value('id'),
                'id_user_atasan2'               => User::where('id', $request->id_user_atasan2)->value('id'),
                'id_jabatan'                    => Jabatan::where('id', $request->id_jabatan)->value('id'),
                'id_departemen'                 => Departemen::where('id', $request->id_departemen)->value('id'),
                'id_divisi'                     => Divisi::where('id', $request->id_divisi)->value('id'),
                'asal_kerja'                    => $request->asal_kerja,
                'id_diajukan_oleh'              => User::where('id', $request->id_diajukan_oleh)->value('id'),
                'ttd_id_diajukan_oleh'          => $request->ttd_id_diajukan_oleh,
                'waktu_ttd_id_diajukan_oleh'    => $request->waktu_ttd_id_diajukan_oleh,
                'id_diminta_oleh'               => $request->id_diminta_oleh,
                'ttd_id_diminta_oleh'           => $request->ttd_id_diminta_oleh,
                'waktu_ttd_id_diminta_oleh'     => $request->waktu_ttd_id_diminta_oleh,
                'id_disahkan_oleh'              => $request->id_disahkan_oleh,
                'ttd_id_disahkan_oleh'          => $request->ttd_id_disahkan_oleh,
                'waktu_ttd_id_disahkan_oleh'    => $request->waktu_ttd_id_disahkan_oleh,
                'proses_hrd'                    => $request->proses_hrd,
                'ttd_proses_hrd'                => $request->ttd_proses_hrd,
                'waktu_ttd_proses_hrd'          => $request->waktu_ttd_proses_hrd,
                'proses_finance'                => $request->proses_finance,
                'ttd_proses_finance'            => $request->ttd_proses_finance,
                'waktu_ttd_proses_finance'      => $request->waktu_ttd_proses_finance,
                'penugasan'                     => $request->penugasan,
                'tanggal_kunjungan'             => $request->tanggal_kunjungan,
                'selesai_kunjungan'             => $request->selesai_kunjungan,
                'kegiatan_penugasan'            => $request->kegiatan_penugasan,
                'pic_dikunjungi'                => $request->pic_dikunjungi,
                'alamat_dikunjungi'             => $request->alamat_dikunjungi,
                'transportasi'                  => $request->transportasi,
                'kelas'                         => $request->kelas,
                'budget_hotel'                  => $request->budget_hotel,
                'makan'                         => $request->makan,
                'status_penugasan'              => 0,
                'tanggal_pengajuan'             => $request->tanggal_pengajuan,

            ]);
            $request->session()->flash('penugasansukses', 'Berhasil Membuat Perdin');
            return redirect('/penugasan/dashboard');
        } else {
            $request->session()->flash('penugasangagal', 'Gagal Membuat Perdin');
            return redirect('/penugasan/dashboard');
        }
    }

    public function penugasanEdit($id)
    {
        $user           = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
                        ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                        ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                        ->where('users.id', Auth()->user()->id)->first();
        $penugasan      = DB::table('penugasans')
                        ->join('jabatans', 'jabatans.id', 'penugasans.id_jabatan')
                        ->join('departemens', 'departemens.id', 'penugasans.id_departemen')
                        ->join('divisis', 'divisis.id', 'penugasans.id_divisi')
                        ->join('users', 'users.id', 'penugasans.id_diminta_oleh')
                        ->where('penugasans.id', $id)->first();
        // $id_penugasan   = $id;
        return view('users.penugasan.edit', [
            'penugasan'     => $penugasan,
            'user'          => $user,
            'id_penugasan'  => $id,
        ]);
    }

    public function penugasanUpdate(Request $request, $id)
    {
        dd($request->ttd_userpenugasan);
        $data   = Penugasan::find($id)->first();
        $data->asal_kerja           = $request->asal_kerja;
        $data->penugasan            = $request->penugasan;
        $data->tanggal_kunjungan    = $request->tanggal_kunjungan;
        $data->selesai_kunjungan    = $request->selesai_kunjungan;
        $data->kegiatan_penugasan   = $request->kegiatan_penugasan;
        $data->pic_dikunjungi       = $request->pic_dikunjungi;
        $data->alamat_dikunjungi    = $request->alamat_dikunjungi;
        $data->transportasi         = $request->transportasi;
        $data->kelas                = $request->kelas;
        $data->budget_hotel         = $request->budget_hotel;
        $data->makan                = $request->makan;
        $data->update();
        $request->session()->flash('updatesukses', 'Berhasil Membuat Perdin');
        return redirect('/penugasan/dashboard');

    }

    public function penugasanApprove($id)
    {
        $user       = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        $penugasan  = DB::table('penugasans')->join('jabatans', 'jabatans.id', 'penugasans.id_jabatan')
            ->join('departemens', 'departemens.id', 'penugasans.id_departemen')
            ->join('users', 'users.id', 'penugasans.id_user')
            ->join('divisis', 'divisis.id', 'penugasans.id_divisi')
            ->where('penugasans.id', $id)->first();
        // dd($penugasan);
        return view('users.penugasan.approve', [
            'penugasan' => $penugasan,
            'user'      => $user,
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
