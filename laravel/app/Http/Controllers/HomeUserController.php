<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\MappingShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ActivityLog;
use App\Models\Cuti;
use App\Models\Departemen;
use App\Models\Divisi;
use App\Models\Izin;
use App\Models\Jabatan;
use App\Models\LevelJabatan;
use App\Models\Penugasan;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class HomeUserController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user_login = auth()->user()->id;
        $lokasi_kantor = Auth::guard('web')->user()->penempatan_kerja;
        // dd($lokasi_kantor);
        $tanggal = "";
        // $dateweek = \Carbon\Carbon::today();
        // dd($dateweek);
        $tglskrg = date('Y-m-d');
        $blnskrg = date('m');
        $thnskrg = date('Y');
        // dd($blnskrg);
        $tglkmrn            = date('Y-m-d', strtotime('-1 days'));
        $mapping_shift      = MappingShift::where('user_id', $user_login)->where('tanggal', $tglkmrn)->first();
        $count_absen_hadir  = MappingShift::where('user_id', $user_login)->where('status_absen', 'Masuk')->where('tanggal', '<=', $tglskrg)
            ->whereMonth('tanggal', $blnskrg)
            ->count();
        $count_absen_sakit  = MappingShift::where('user_id', $user_login)->where('status_absen', 'Sakit')->where('tanggal', '<=', $tglskrg)
            ->whereMonth('tanggal', $blnskrg)
            ->count();
        $count_absen_izin  = MappingShift::where('user_id', $user_login)->where('status_absen', 'Izin')->where('tanggal', '<=', $tglskrg)
            ->whereMonth('tanggal', $blnskrg)
            ->count();
        $count_absen_telat  = MappingShift::where('user_id', $user_login)->where('status_absen', 'telat')->where('tanggal', '<=', $tglskrg)
            ->whereMonth('tanggal', $blnskrg)
            ->count();
        $user           = Auth::user()->id;
        $dataizin       = Izin::with('User')->where('id_approve_atasan', $user)
            ->whereNotNull('ttd_pengajuan')
            ->where('status_izin', 1)
            ->get();
        // get atasan tingkat 
        $datacuti_tingkat1       = Cuti::with('KategoriCuti')
            ->where('status_cuti', 1)
            ->join('users', 'users.id', '=', 'cutis.user_id')
            ->where('id_user_atasan', $user)
            ->whereNotNull('ttd_user')
            ->select('cutis.*', 'users.name', 'users.foto_karyawan')
            ->get();
        $datacuti_tingkat2       = Cuti::with('KategoriCuti')
            ->where('status_cuti', 2)
            ->join('users', 'users.id', '=', 'cutis.user_id')
            ->where('id_user_atasan2', $user)
            ->whereNotNull('ttd_user')
            ->select('cutis.*', 'users.name', 'users.foto_karyawan')
            ->get();
        // dd($datacuti_tingkat2);
        $datapenugasan  = DB::table('penugasans')->join('users', 'users.id', 'penugasans.id_user')
            ->where('id_diminta_oleh', $user)
            ->orWhere('id_disahkan_oleh', $user)
            ->orWhere('id_user_hrd', $user)
            ->orWhere('id_user_finance', $user)
            ->where('penugasans.status_penugasan', '!=', 5)
            ->select('penugasans.*', 'users.fullname')
            ->get();
        // dd($datapenugasan);
        $data_user_penugasaan  = DB::table('penugasans')->join('users', 'users.id', 'penugasans.id_user')
            ->where('id_user', $user)
            ->where('penugasans.status_penugasan', '5')
            ->select('penugasans.*', 'users.name')->get();
        // dd(count($data_user_penugasaan));
        if (count($data_user_penugasaan) != 0) {
            foreach ($data_user_penugasaan as $user_penugasan) {
                if ($user_penugasan->wilayah_penugasan == 'Diluar Kantor') {
                    $kantor_penugasan = NULL;
                    $cek_absensi      = MappingShift::where('user_id', $user_login)
                        ->where('status_absen', 'Tidak Masuk')
                        ->whereBetween('tanggal', [$user_penugasan->tanggal_kunjungan, $user_penugasan->selesai_kunjungan])
                        ->update([
                            'jam_absen' => '07:45:00',
                            'telat' => '0',
                            'jam_pulang' => '17:00:00',
                            'lembur' => '0',
                            'pulang_cepat' => '0',
                            'keterangan_absensi' => 'ABSENSI PENUGASAN DILUAR WILAYAH KANTOR',
                            'status_absen' => 'Masuk',
                        ]);
                } else if ($user_penugasan->wilayah_penugasan == 'Wilayah Kantor') {
                    $kantor_penugasan = $user_penugasan->alamat_dikunjungi;
                    $cek_absensi      = MappingShift::where('user_id', $user_login)
                        ->where('status_absen', 'Tidak Masuk')
                        ->whereBetween('tanggal', [$user_penugasan->tanggal_kunjungan, $user_penugasan->selesai_kunjungan])
                        ->update([
                            'keterangan_absensi' => 'ABSENSI PENUGASAN WILAYAH KANTOR',
                        ]);
                }
            }
        } else {
            $kantor_penugasan = NULL;
        }
        if ($mapping_shift == '' || $mapping_shift == NULL) {
            $jam_absen = null;
            $jam_pulang = null;
            $status_absen_skrg = MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->get();
            $jam_kerja = MappingShift::with('Shift')->where('user_id', $user_login)->where('tanggal', $tglskrg)->first();
            // dd($status_absen_skrg);
            return view('users.home.index', [
                'title'             => 'Absen',
                'jam_kerja'         => $jam_kerja,
                'shift_karyawan'    => MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->first(),
                'count_absen_hadir' => $count_absen_hadir,
                'thnskrg'           => $thnskrg,
                'lokasi_kantor'     => $lokasi_kantor,
                'status_absen_skrg' => $status_absen_skrg,
                'dataizin'          => $dataizin,
                'datacuti_tingkat1' => $datacuti_tingkat1,
                'datacuti_tingkat2' => $datacuti_tingkat2,
                'datapenugasan'     => $datapenugasan,
                'count_absen_izin'     => $count_absen_izin,
                'count_absen_sakit'     => $count_absen_sakit,
                'count_absen_telat'     => $count_absen_telat,
                'kantor_penugasan'     => $kantor_penugasan,
            ]);
        } else {
            $jam_absen = $mapping_shift->jam_absen;
            $jam_pulang = $mapping_shift->jam_pulang;
            $getshift = $mapping_shift->shift->nama_shift;

            $hours_1_masuk = Carbon::parse($mapping_shift->shift->jam_masuk)->subHour(1)->format('H:i:s');
            $hours_1_pulang = Carbon::parse($mapping_shift->shift->jam_keluar)->subHour(-1)->format('H:i:s');
            $timenow = Carbon::now()->format('H:i:s');
            // dd($getshift);
            if ($getshift == 'Malam') {
                if ($jam_absen != null && $jam_pulang == null) {
                    if ($hours_1_pulang > $timenow) {
                        $status_absen_skrg = MappingShift::where('user_id', $user_login)->where('tanggal', $tglkmrn)->get();
                    } else {
                        $status_absen_skrg = MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->get();
                    }
                } else {
                    $status_absen_skrg = MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->get();
                }
            } else {
                $status_absen_skrg = MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->get();
            }
            $jam_kerja = MappingShift::with('Shift')->where('user_id', $user_login)->where('tanggal', $tglskrg)->first();
            // $hours_1 = Carbon::parse($getshift->shift->jam_masuk)->subHour(-1)->format('H:i:s');
            // dd($hours_1);
            // dd($datacuti);
            return view('users.home.index', [
                'title'             => 'Absen',
                'shift_karyawan'    => MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->first(),
                'count_absen_hadir' => $count_absen_hadir,
                'thnskrg'           => $thnskrg,
                'get_shift'         => $getshift,
                'lokasi_kantor'     => $lokasi_kantor,
                'jam_kerja'         => $jam_kerja,
                'status_absen_skrg' => $status_absen_skrg,
                'dataizin'          => $dataizin,
                'datacuti_tingkat1' => $datacuti_tingkat1,
                'datacuti_tingkat2' => $datacuti_tingkat2,
                'datapenugasan'     => $datapenugasan,
                'count_absen_izin'     => $count_absen_izin,
                'count_absen_sakit'     => $count_absen_sakit,
                'count_absen_telat'     => $count_absen_telat,
                'kantor_penugasan'     => $kantor_penugasan,
            ]);
        }
    }
    public function form_datang_terlambat(Request $request)
    {

        $user = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('level_jabatans', 'jabatans.level_id', '=', 'level_jabatans.id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        $jam_kerja = MappingShift::with('Shift')->where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
        // dd($jam_kerja);
        $kontrak = Auth::guard('web')->user()->kontrak_kerja;
        if ($user->level_jabatan == 4) {
            // dd($kontrak);
            $IdLevelAsasan  = LevelJabatan::where('level_jabatan', '3')->first();
            $IdLevelAsasan1  = LevelJabatan::where('level_jabatan', '2')->first();
            $IdLevelAsasan2  = LevelJabatan::where('level_jabatan', '1')->first();
            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                ->where('is_admin', 'user')
                ->where('users.id', '!=', Auth::user()->id)
                ->where('users.divisi_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi_id)
                ->get();
            $atasan = DB::table('users')
                ->join('jabatans', function ($join) use ($IdLevelAsasan) {
                    $join->on('jabatans.id', '=', 'users.jabatan_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                    $join->join('level_jabatans', function ($query) use ($IdLevelAsasan) {
                        $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                        $query->where('level_jabatans.id', '=', $IdLevelAsasan->id);
                    });
                })
                ->where('users.is_admin', 'user')
                ->where('users.divisi_id', $user->divisi_id)
                ->orWhere('users.divisi1_id', $user->divisi_id)
                ->orWhere('users.divisi2_id', $user->divisi_id)
                ->orWhere('users.divisi3_id', $user->divisi_id)
                ->orWhere('users.divisi4_id', $user->divisi_id)
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                ->first();
            // dd($atasan1);
            // dd($atasan);
            if ($atasan == '' || $atasan == NULL) {
                $atasan1 = DB::table('users')
                    ->join('jabatans', function ($join) use ($IdLevelAsasan1) {
                        $join->on('jabatans.id', '=', 'users.jabatan_id');
                        $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                        $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                        $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                        $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                        $join->join('level_jabatans', function ($query) use ($IdLevelAsasan1) {
                            $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                            $query->where('level_jabatans.id', '=', $IdLevelAsasan1->id);
                        });
                    })
                    ->where('users.is_admin', 'user')
                    ->where('users.divisi_id', $user->divisi_id)
                    ->orWhere('users.divisi1_id', $user->divisi_id)
                    ->orWhere('users.divisi2_id', $user->divisi_id)
                    ->orWhere('users.divisi3_id', $user->divisi_id)
                    ->orWhere('users.divisi4_id', $user->divisi_id)
                    ->where('users.divisi_id', $user->divisi1_id)
                    ->orWhere('users.divisi1_id', $user->divisi1_id)
                    ->orWhere('users.divisi2_id', $user->divisi1_id)
                    ->orWhere('users.divisi3_id', $user->divisi1_id)
                    ->orWhere('users.divisi4_id', $user->divisi1_id)
                    ->where('users.divisi_id', $user->divisi2_id)
                    ->orWhere('users.divisi1_id', $user->divisi2_id)
                    ->orWhere('users.divisi2_id', $user->divisi2_id)
                    ->orWhere('users.divisi3_id', $user->divisi2_id)
                    ->orWhere('users.divisi4_id', $user->divisi2_id)
                    ->where('users.divisi_id', $user->divisi3_id)
                    ->orWhere('users.divisi1_id', $user->divisi3_id)
                    ->orWhere('users.divisi2_id', $user->divisi3_id)
                    ->orWhere('users.divisi3_id', $user->divisi3_id)
                    ->orWhere('users.divisi4_id', $user->divisi3_id)
                    ->where('users.divisi_id', $user->divisi4_id)
                    ->orWhere('users.divisi1_id', $user->divisi4_id)
                    ->orWhere('users.divisi2_id', $user->divisi4_id)
                    ->orWhere('users.divisi3_id', $user->divisi4_id)
                    ->orWhere('users.divisi4_id', $user->divisi4_id)
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
                // dd($atasan1);
                if ($atasan1->kontrak_kerja == $kontrak) {
                    $getUserAtasan  = $atasan1;
                } else {
                    $getUserAtasan  = NULL;
                }
                if ($atasan1 == '' || $atasan1 == NULL) {
                    $atasan2 = DB::table('users')
                        ->join('jabatans', function ($join) use ($IdLevelAsasan2) {
                            $join->on('jabatans.id', '=', 'users.jabatan_id');
                            $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                            $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                            $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                            $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                            $join->join('level_jabatans', function ($query) use ($IdLevelAsasan2) {
                                $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                                $query->where('level_jabatans.id', '=', $IdLevelAsasan2->id);
                            });
                        })
                        ->where('users.is_admin', 'user')
                        ->where('users.divisi_id', $user->divisi_id)
                        ->orWhere('users.divisi1_id', $user->divisi1_id)
                        ->orWhere('users.divisi2_id', $user->divisi2_id)
                        ->orWhere('users.divisi3_id', $user->divisi3_id)
                        ->orWhere('users.divisi4_id', $user->divisi4_id)
                        ->where('users.divisi_id', $user->divisi1_id)
                        ->orWhere('users.divisi1_id', $user->divisi1_id)
                        ->orWhere('users.divisi2_id', $user->divisi1_id)
                        ->orWhere('users.divisi3_id', $user->divisi1_id)
                        ->orWhere('users.divisi4_id', $user->divisi1_id)
                        ->where('users.divisi_id', $user->divisi2_id)
                        ->orWhere('users.divisi1_id', $user->divisi2_id)
                        ->orWhere('users.divisi2_id', $user->divisi2_id)
                        ->orWhere('users.divisi3_id', $user->divisi2_id)
                        ->orWhere('users.divisi4_id', $user->divisi2_id)
                        ->where('users.divisi_id', $user->divisi3_id)
                        ->orWhere('users.divisi1_id', $user->divisi3_id)
                        ->orWhere('users.divisi2_id', $user->divisi3_id)
                        ->orWhere('users.divisi3_id', $user->divisi3_id)
                        ->orWhere('users.divisi4_id', $user->divisi3_id)
                        ->where('users.divisi_id', $user->divisi4_id)
                        ->orWhere('users.divisi1_id', $user->divisi4_id)
                        ->orWhere('users.divisi2_id', $user->divisi4_id)
                        ->orWhere('users.divisi3_id', $user->divisi4_id)
                        ->orWhere('users.divisi4_id', $user->divisi4_id)
                        ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                        ->first();
                    if ($atasan2->_kerja == $kontrak) {
                        $getUserAtasan  = $atasan2;
                    } else {
                        $getUserAtasan  = NULL;
                    }
                } else {
                    if ($atasan1 == $kontrak) {
                        $getUserAtasan  = $atasan;
                    } else {
                        $getUserAtasan  = NULL;
                    }
                }
            } else {
                if ($atasan->kontrak_kerja == $kontrak) {
                    $getUserAtasan  = $atasan;
                } else {
                    $getUserAtasan  = NULL;
                }
            }
            // dd($getUserAtasan);
        } else if ($user->level_jabatan == 3) {
            $IdLevelAsasan  = LevelJabatan::where('level_jabatan', '2')->first();
            $IdLevelAsasan1  = LevelJabatan::where('level_jabatan', '1')->first();
            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                ->where('is_admin', 'user')
                ->where('users.id', '!=', Auth::user()->id)
                ->where('users.divisi_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi_id)
                ->get();
            $atasan = DB::table('users')
                ->where('users.is_admin', 'user')
                ->where('users.divisi_id', $user->divisi_id)
                ->orWhere('users.divisi1_id', $user->divisi_id)
                ->orWhere('users.divisi2_id', $user->divisi_id)
                ->orWhere('users.divisi3_id', $user->divisi_id)
                ->orWhere('users.divisi4_id', $user->divisi_id)
                // ->where('users.divisi_id', $user->divisi1_id)
                // ->orWhere('users.divisi1_id', $user->divisi1_id)
                // ->orWhere('users.divisi2_id', $user->divisi1_id)
                // ->orWhere('users.divisi3_id', $user->divisi1_id)
                // ->orWhere('users.divisi4_id', $user->divisi1_id)
                // ->where('users.divisi_id', $user->divisi2_id)
                // ->orWhere('users.divisi1_id', $user->divisi2_id)
                // ->orWhere('users.divisi2_id', $user->divisi2_id)
                // ->orWhere('users.divisi3_id', $user->divisi2_id)
                // ->orWhere('users.divisi4_id', $user->divisi2_id)
                // ->where('users.divisi_id', $user->divisi3_id)
                // ->orWhere('users.divisi1_id', $user->divisi3_id)
                // ->orWhere('users.divisi2_id', $user->divisi3_id)
                // ->orWhere('users.divisi3_id', $user->divisi3_id)
                // ->orWhere('users.divisi4_id', $user->divisi3_id)
                // ->where('users.divisi_id', $user->divisi4_id)
                // ->orWhere('users.divisi1_id', $user->divisi4_id)
                // ->orWhere('users.divisi2_id', $user->divisi4_id)
                // ->orWhere('users.divisi3_id', $user->divisi4_id)
                // ->orWhere('users.divisi4_id', $user->divisi4_id)
                ->join('jabatans', function ($join) use ($IdLevelAsasan) {
                    $join->on('jabatans.id', '=', 'users.jabatan_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                    $join->join('level_jabatans', function ($query) use ($IdLevelAsasan) {
                        $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                        $query->where('level_jabatans.id', '=', $IdLevelAsasan->id);
                    });
                })
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                ->orderBy('users.id', 'DESC')
                ->first();
            // dd($atasan);
            if ($atasan == '' || $atasan == NULL) {
                $atasan1 = DB::table('users')
                    ->join('jabatans', function ($join) use ($IdLevelAsasan1) {
                        $join->on('jabatans.id', '=', 'users.jabatan_id');
                        $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                        $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                        $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                        $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                        $join->join('level_jabatans', function ($query) use ($IdLevelAsasan1) {
                            $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                            $query->where('level_jabatans.id', '=', $IdLevelAsasan1->id);
                        });
                    })->where('users.divisi_id', $user->divisi_id)
                    ->orWhere('users.divisi1_id', $user->divisi_id)
                    ->orWhere('users.divisi2_id', $user->divisi_id)
                    ->orWhere('users.divisi3_id', $user->divisi_id)
                    ->orWhere('users.divisi4_id', $user->divisi_id)
                    // ->where('users.divisi_id', $user->divisi1_id)
                    // ->orWhere('users.divisi1_id', $user->divisi1_id)
                    // ->orWhere('users.divisi2_id', $user->divisi1_id)
                    // ->orWhere('users.divisi3_id', $user->divisi1_id)
                    // ->orWhere('users.divisi4_id', $user->divisi1_id)
                    // ->where('users.divisi_id', $user->divisi2_id)
                    // ->orWhere('users.divisi1_id', $user->divisi2_id)
                    // ->orWhere('users.divisi2_id', $user->divisi2_id)
                    // ->orWhere('users.divisi3_id', $user->divisi2_id)
                    // ->orWhere('users.divisi4_id', $user->divisi2_id)
                    // ->where('users.divisi_id', $user->divisi3_id)
                    // ->orWhere('users.divisi1_id', $user->divisi3_id)
                    // ->orWhere('users.divisi2_id', $user->divisi3_id)
                    // ->orWhere('users.divisi3_id', $user->divisi3_id)
                    // ->orWhere('users.divisi4_id', $user->divisi3_id)
                    // ->where('users.divisi_id', $user->divisi4_id)
                    // ->orWhere('users.divisi1_id', $user->divisi4_id)
                    // ->orWhere('users.divisi2_id', $user->divisi4_id)
                    // ->orWhere('users.divisi3_id', $user->divisi4_id)
                    // ->orWhere('users.divisi4_id', $user->divisi4_id)
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
                if ($atasan1 == '' || $atasan1 == NULL) {
                    $getUserAtasan  = NULL;
                } else {
                    if ($atasan1->kontrak_kerja == $kontrak) {
                        $getUserAtasan  = $atasan1;
                    } else {
                        $getUserAtasan  = NULL;
                    }
                }
            } else {
                if ($atasan->kontrak_kerja == $kontrak) {
                    $getUserAtasan  = $atasan;
                } else {
                    $getUserAtasan  = NULL;
                }
            }
        } else if ($user->level_jabatan == 2) {
            $IdLevelAsasan  = LevelJabatan::where('level_jabatan', '1')->first();
            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                ->where('is_admin', 'user')
                ->where('users.id', '!=', Auth::user()->id)
                ->where('users.divisi_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi_id)
                ->get();
            $atasan = DB::table('users')
                ->join('jabatans', function ($join) use ($IdLevelAsasan) {
                    $join->on('jabatans.id', '=', 'users.jabatan_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                    $join->join('level_jabatans', function ($query) use ($IdLevelAsasan) {
                        $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                        $query->where('level_jabatans.id', '=', $IdLevelAsasan->id);
                    });
                })
                ->where('users.is_admin', 'user')
                ->where('users.dept_id', $user->dept_id)
                ->where('users.divisi_id', $user->divisi_id)
                ->orWhere('users.divisi1_id', $user->divisi_id)
                ->orWhere('users.divisi2_id', $user->divisi_id)
                ->orWhere('users.divisi3_id', $user->divisi_id)
                ->orWhere('users.divisi4_id', $user->divisi_id)
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                ->first();
            // dd($atasan);
            if ($atasan == '' || $atasan == NULL) {
                $getUserAtasan  = NULL;
            } else {
                if ($atasan->kontrak_kerja == $kontrak) {
                    $getUserAtasan  = $atasan;
                } else {
                    $getUserAtasan  = NULL;
                }
            }
        } else {
            $atasan = DB::table('users')
                ->join('jabatans', function ($join) {
                    $join->on('jabatans.id', '=', 'users.jabatan_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                    $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                    $join->join('level_jabatans', function ($query) {
                        $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                        $query->where('level_jabatans.level_jabatan', '=', '0');
                    });
                })
                ->where('users.divisi_id', $user->divisi_id)
                ->orWhere('users.divisi1_id', $user->divisi_id)
                ->orWhere('users.divisi2_id', $user->divisi_id)
                ->orWhere('users.divisi3_id', $user->divisi_id)
                ->orWhere('users.divisi4_id', $user->divisi_id)
                ->where('users.divisi_id', $user->divisi1_id)
                ->orWhere('users.divisi1_id', $user->divisi1_id)
                ->orWhere('users.divisi2_id', $user->divisi1_id)
                ->orWhere('users.divisi3_id', $user->divisi1_id)
                ->orWhere('users.divisi4_id', $user->divisi1_id)
                ->where('users.divisi_id', $user->divisi2_id)
                ->orWhere('users.divisi1_id', $user->divisi2_id)
                ->orWhere('users.divisi2_id', $user->divisi2_id)
                ->orWhere('users.divisi3_id', $user->divisi2_id)
                ->orWhere('users.divisi4_id', $user->divisi2_id)
                ->where('users.divisi_id', $user->divisi3_id)
                ->orWhere('users.divisi1_id', $user->divisi3_id)
                ->orWhere('users.divisi2_id', $user->divisi3_id)
                ->orWhere('users.divisi3_id', $user->divisi3_id)
                ->orWhere('users.divisi4_id', $user->divisi3_id)
                ->where('users.divisi_id', $user->divisi4_id)
                ->orWhere('users.divisi1_id', $user->divisi4_id)
                ->orWhere('users.divisi2_id', $user->divisi4_id)
                ->orWhere('users.divisi3_id', $user->divisi4_id)
                ->orWhere('users.divisi4_id', $user->divisi4_id)
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                ->first();
            // dd($atasan);
            $get_user_backup = NULL;
            $getUserAtasan = NULL;
        }
        return view('users.absen.form_datang_terlambat', [
            'user' => $user,
            'jam_kerja' => $jam_kerja,
            'getUserAtasan' => $getUserAtasan,
        ]);
    }
    public function get_count_absensi_home(Request $request)
    {
        $blnskrg = date('m');
        $user_login = auth()->user()->id;
        if ($request->ajax()) {
            if (!empty($request->filter_month)) {
                $count_absen_hadir = MappingShift::where('user_id', $user_login)->whereMonth('tanggal', $request->filter_month)->where('status_absen', 'Masuk')->count();
            } else {
                $count_absen_hadir = MappingShift::where('user_id', $user_login)->whereMonth('tanggal', $blnskrg)->where('status_absen', 'Masuk')->count();
            }
        }
        return $count_absen_hadir;
    }
    public function datatableHome(Request $request)
    {

        // dd($request->all());
        $user_login = auth()->user()->id;
        $dateweek = \Carbon\Carbon::today()->subDays(7);
        $datenow = \Carbon\Carbon::today();
        $blnskrg = date('m');
        // dd($firstDayofPreviousMonth);
        if ($request->ajax()) {
            if (!empty($request->filter_month)) {
                if ($request->filter_month == $blnskrg) {
                    $data = MappingShift::where('user_id', $user_login)->whereMonth('tanggal', $blnskrg)->whereBetween('tanggal', array($dateweek, $datenow))->get();
                } else {
                    $data = MappingShift::where('user_id', $user_login)->whereMonth('tanggal', $request->filter_month)->limit(7)->orderBy('tanggal', 'DESC')->get();
                }
                return DataTables::of($data)->addIndexColumn()
                    ->addColumn('tanggal', function ($row) {
                        $result = Carbon::parse($row->tanggal)->isoFormat('D-MM-Y');;
                        return $result;
                    })
                    ->addColumn('jam_absen', function ($row) {
                        if ($row->jam_absen == NULL) {
                            return $row->jam_absen;
                        } else {
                            $result = Carbon::parse($row->jam_absen)->isoFormat('H:m');;
                            return $result;
                        }
                    })
                    ->addColumn('jam_pulang', function ($row) {
                        if ($row->jam_pulang == NULL) {
                            return $row->jam_pulang;
                        } else {
                            $result = Carbon::parse($row->jam_pulang)->isoFormat('H:m');;
                            return $result;
                        }
                    })
                    ->rawColumns(['tanggal', 'jam_absen', 'jam_pulang'])
                    ->make(true);
            } else {
                $data = MappingShift::where('user_id', $user_login)->whereMonth('tanggal', $blnskrg)->whereBetween('tanggal', array($dateweek, $datenow))->orderBy('tanggal', 'DESC')->get();
                return DataTables::of($data)->addIndexColumn()
                    ->addColumn('tanggal', function ($row) {
                        $result = Carbon::parse($row->tanggal)->isoFormat('D-MM-Y');;
                        return $result;
                    })
                    ->addColumn('jam_absen', function ($row) {
                        if ($row->jam_absen == NULL) {
                            return $row->jam_absen;
                        } else {
                            $result = Carbon::parse($row->jam_absen)->isoFormat('H:m');;
                            return $result;
                        }
                    })
                    ->addColumn('jam_pulang', function ($row) {
                        if ($row->jam_pulang == NULL) {
                            return $row->jam_pulang;
                        } else {
                            $result = Carbon::parse($row->jam_pulang)->isoFormat('H:m');;
                            return $result;
                        }
                    })
                    ->rawColumns(['tanggal', 'jam_absen', 'jam_pulang'])
                    ->make(true);
            }
        }
    }
    public function HomeAbsen(Request $request)
    {
        // dd('ok');
        $user_login = auth()->user()->id;
        $date_now = date('Y');
        $month_now = date('m');
        $month_yesterday = \Carbon\Carbon::now()->subMonthsNoOverflow()->isoFormat('MM');
        $month_yesterday1 = \Carbon\Carbon::now()->subMonthsNoOverflow()->isoFormat('MMMM');
        $month_now1 = \Carbon\Carbon::now()->isoFormat('MMMM');
        date_default_timezone_set('Asia/Jakarta');
        $user_login = auth()->user()->id;
        $tanggal = "";
        $tglskrg = date('Y-m-d');
        $tglkmrn = date('Y-m-d', strtotime('-1 days'));
        $tidak_masuk = MappingShift::where('status_absen', 'Tidak Masuk')
            ->where('user_id', $user_login)
            ->select(DB::raw("COUNT(*) as count"))
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw("Month(tanggal)"))
            ->pluck('count');
        $masuk = MappingShift::where('mapping_shifts.status_absen', 'Masuk')
            ->where('user_id', $user_login)
            ->select(DB::raw("COUNT(mapping_shifts.tanggal) as count"))
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw("Month(tanggal)"))
            ->pluck('count');
        $telat = MappingShift::where('status_absen', 'Telat')
            ->where('user_id', $user_login)
            ->select(DB::raw("COUNT(*) as count"))
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw("Month(tanggal)"))
            ->pluck('count');
        // dd();
        $telat_now = MappingShift::whereMonth('tanggal', $month_now)
            ->where('user_id', $user_login)
            ->select(DB::raw("telat as count"))
            ->pluck('count');
        $telat_yesterday = MappingShift::whereMonth('tanggal', $month_yesterday)
            ->where('user_id', $user_login)
            ->select(DB::raw("telat as count"))
            ->pluck('count');
        $lembur_now = MappingShift::whereMonth('tanggal', $month_now)
            ->where('user_id', $user_login)
            ->select(DB::raw("lembur as count"))
            ->pluck('count');
        $lembur_yesterday = MappingShift::whereMonth('tanggal', $month_yesterday)
            ->where('user_id', $user_login)
            ->select(DB::raw("lembur as count"))
            ->pluck('count');
        $data_telat_now = MappingShift::whereMonth('tanggal', $month_yesterday)
            ->where('user_id', $user_login)
            ->select(DB::raw("tanggal as count"))
            ->pluck('count');
        $data_telat_yesterday = MappingShift::whereMonth('tanggal', $month_yesterday)
            ->where('user_id', $user_login)
            ->select(DB::raw("tanggal as count "))
            ->pluck('count');
        $get_mapping = MappingShift::where('user_id', $user_login)->where('tanggal', $tglkmrn)->first();
        if ($get_mapping == '' || $get_mapping == NULL) {
            $tanggal = $tglskrg;
            $mapping_shift = MappingShift::where('user_id', $user_login)->where('tanggal', $tanggal)->first();
        } else {
            $tanggal = $tglkmrn;
            $mapping_shift = MappingShift::where('user_id', $user_login)->where('tanggal', $tanggal)->first();
        }
        date_default_timezone_set('Asia/Jakarta');
        $tglskrg = date('Y-m-d');
        $data_absen = MappingShift::where('tanggal', $tglskrg)->where('user_id', auth()->user()->id);

        if ($request["mulai"] == null) {
            $request["mulai"] = $request["akhir"];
        }

        if ($request["akhir"] == null) {
            $request["akhir"] = $request["mulai"];
        }

        if ($request["mulai"] && $request["akhir"]) {
            $data_absen = MappingShift::where('user_id', auth()->user()->id)->whereBetween('tanggal', [$request["mulai"], $request["akhir"]]);
        }
        $timenow = Carbon::now()->format('H:i:s');
        $hours_1_masuk = Carbon::parse($mapping_shift->shift->jam_masuk)->subHour(1)->format('H:i:s');
        $hours_1_pulang = Carbon::parse($mapping_shift->shift->jam_keluar)->subHour(-1)->format('H:i:s');
        $get_nama_shift = $mapping_shift->shift->nama_shift;
        // dd($hours_1_pulang);
        if ($get_nama_shift == 'Malam') {
            if ($hours_1_pulang > $timenow) {
                // dd('1');
                $getshift = MappingShift::where('user_id', $user_login)->where('tanggal', $tglkmrn)->first();
                $status_absen_skrg = MappingShift::where('user_id', $user_login)->where('tanggal', $tglkmrn)->get();
            } else {
                // dd('2');
                $getshift = MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->first();
                $status_absen_skrg = MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->get();
            }
        } else {
            $getshift = MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->first();
            $status_absen_skrg = MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->get();
        }
        $cek_jam_maks_kerja = MappingShift::where('user_id', Auth::user()->id)->where('tanggal', $tglskrg)->first();
        $time_now = date('H:i');
        $date1          = new DateTime($cek_jam_maks_kerja->tanggal . $cek_jam_maks_kerja->jam_absen);
        $date2          = new DateTime($cek_jam_maks_kerja->tanggal . $time_now);
        $interval       = $date1->diff($date2);
        if ($getshift->jam_absen == '' || $getshift->jam_absen == NULL) {
            if ($timenow >= $hours_1_masuk) {
                // dd($get_nama_shift);
                if ($interval->h <= 6) {
                    $request->session()->flash('jam_kerja_kurang');
                }
                return view('users.absen.index', [
                    'title' => 'My Absen',
                    'shift_karyawan' => $status_absen_skrg,
                    'status_absen_skrg' => $status_absen_skrg,
                    'data_absen' => $data_absen->get(),
                    'masuk' => array_map('intval', json_decode($masuk)),
                    'tidak_masuk' => array_map('intval', json_decode($tidak_masuk)),
                    'telat' => array_map('intval', json_decode($telat)),
                    'date_now' => $date_now,
                    'month_now1' => $month_now1,
                    'month_yesterday1' => $month_yesterday1,
                    'telat_now' => array_map('intval', json_decode($telat_now)),
                    'telat_yesterday' => array_map('intval', json_decode($telat_yesterday)),
                    'lembur_now' => array_map('intval', json_decode($lembur_now)),
                    'data_telat_now' => $data_telat_now,
                    'data_telat_yesterday' => $data_telat_yesterday,
                    'lembur_yesterday' => array_map('intval', json_decode($lembur_yesterday))
                ]);
            } else {
                Alert::error('Gagal', 'Anda Belum Masuk Jam Absensi');
                return redirect()->back()->with('Gagal', 'Anda Belum Masuk Jam Absensi');
            }
        } else if ($getshift->jam_absen != '' || $getshift->jam_absen != NULL) {
            // dd('OK1');
            if ($interval->h <= 6) {
                $request->session()->flash('jam_kerja_kurang');
            }
            return view('users.absen.index', [
                'title' => 'My Absen',
                'shift_karyawan' => $status_absen_skrg,
                'status_absen_skrg' => $status_absen_skrg,
                'data_absen' => $data_absen->get(),
                'masuk' => array_map('intval', json_decode($masuk)),
                'tidak_masuk' => array_map('intval', json_decode($tidak_masuk)),
                'telat' => array_map('intval', json_decode($telat)),
                'date_now' => $date_now,
                'month_now1' => $month_now1,
                'month_yesterday1' => $month_yesterday1,
                'telat_now' => array_map('intval', json_decode($telat_now)),
                'telat_yesterday' => array_map('intval', json_decode($telat_yesterday)),
                'lembur_now' => array_map('intval', json_decode($lembur_now)),
                'data_telat_now' => $data_telat_now,
                'data_telat_yesterday' => $data_telat_yesterday,
                'lembur_yesterday' => array_map('intval', json_decode($lembur_yesterday))
            ]);
        }
    }

    public function proses_izin_datang_terlambat(Request $request)
    {
        // dd($request->all());
        $lokasi_kerja = Auth::guard('web')->user()->penempatan_kerja;
        if ($lokasi_kerja == '' || $lokasi_kerja == NULL) {
            $request->session()->flash('lokasikerjanull', 'Gagal Absen Masuk');
            return redirect('/home');
        } else {
            $cek_penugasan = MappingShift::where('id', Auth::user()->id)
                ->where('keterangan_absensi', 'ABSENSI PENUGASAN WILAYAH KANTOR')
                ->first();
            if ($cek_penugasan != '' || $cek_penugasan != NULL) {
                $request->session()->flash('penugasan_wilayah_kantor');
                return redirect('/home');
            } else {
                $jam_kerja = MappingShift::with('Shift')->where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
                if ($jam_kerja == '' || $jam_kerja == NULL) {
                    $request->session()->flash('mapping_kosong');
                    return redirect('/izin/dashboard');
                } else {
                    if ($request->id_user_atasan == NULL || $request->id_user_atasan == '') {
                        if ($request->level_jabatan != '1') {
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
                            $data->status_izin      = 0;
                            $data->ttd_atasan      = NULL;
                            $data->waktu_approve      = NULL;
                            $data->save();
                            $request->session()->flash('izinsuccess');
                            return redirect('/izin/dashboard');
                        }
                    } else {
                        // No form
                        $count_tbl_izin = Izin::where('izin', $request->izin)->count();
                        // dd($count_tbl_izin);
                        $countstr = strlen($count_tbl_izin + 1);
                        if ($countstr == '1') {
                            $no = '000' . $count_tbl_izin + 1;
                        } else if ($countstr == '2') {
                            $no = '00' . $count_tbl_izin + 1;
                        } else if ($countstr == '3') {
                            $no = '0' . $count_tbl_izin + 1;
                        } else {
                            $no = $count_tbl_izin + 1;
                        }
                        $jam_terlambat = $request->terlambat;
                        $jam_masuk_kerja = $request->jam_masuk;
                        $jam_pulang_cepat = NULL;
                        $img_name = NULL;
                        $jam_keluar = NULL;
                        $jam_kembali = NULL;
                        $id_backup = NULL;
                        $name_backup = NULL;
                        $catatan_backup = NULL;
                        $tanggal = $request->tanggal;
                        $tanggal_selesai = NULL;
                        $no_form = Auth::user()->kontrak_kerja . '/SK/FKDT/' . date('Y/m/d') . '/' . $no;
                        $folderPath     = public_path('signature/');
                        $image_parts    = explode(";base64,", $request->signature);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type     = $image_type_aux[1];
                        $image_base64   = base64_decode($image_parts[1]);
                        $uniqid         = date('y-m-d') . '-' . uniqid();
                        $file           = $folderPath . $uniqid . '.' . $image_type;
                        file_put_contents($file, $image_base64);
                        $data                   = new Izin();
                        $data->user_id          = $request->id_user;
                        $data->departements_id  = Departemen::where('id', $request["departements"])->value('id');
                        $data->jabatan_id       = Jabatan::where('id', $request["jabatan"])->value('id');
                        $data->divisi_id        = Divisi::where('id', $request["divisi"])->value('id');
                        $data->telp             = $request->telp;
                        $data->terlambat        = $jam_terlambat;
                        $data->jam_masuk_kerja  = $jam_masuk_kerja;
                        $data->pulang_cepat     = $jam_pulang_cepat;
                        $data->email            = $request->email;
                        $data->fullname         = $request->fullname;
                        $data->izin             = $request->izin;
                        $data->user_id_backup   = $id_backup;
                        $data->user_name_backup = $name_backup;
                        $data->catatan_backup = $catatan_backup;
                        $data->foto_izin        = $img_name;
                        $data->jam_keluar        = $jam_keluar;
                        $data->jam_kembali        = $jam_kembali;
                        $data->tanggal          = $tanggal;
                        $data->tanggal_selesai   = $tanggal_selesai;
                        $data->jam              = $request->jam;
                        $data->keterangan_izin  = $request->keterangan_izin;
                        $data->approve_atasan   = $request->approve_atasan;
                        $data->id_approve_atasan = $request->id_user_atasan;
                        $data->status_izin      = 1;
                        $data->no_form_izin      = $no_form;
                        $data->ttd_pengajuan    = $uniqid;
                        $data->waktu_ttd_pengajuan    = date('Y-m-d');
                        $data->ttd_atasan      = NULL;
                        $data->waktu_approve      = NULL;
                        $data->save();
                        // jam telat
                        $date1          = new DateTime($tanggal . $request->jam_masuk);
                        $date2          = new DateTime($tanggal . $request->jam);
                        $interval       = $date1->diff($date2);
                        $jum_mnt  = ($interval->i);
                        $jum_hours  = ($interval->h);
                        $jum_second  = (($interval->s) / 60);
                        $jum_hour_mnt  = ($jum_hours * 60);
                        $toleransi_mnt = 5;
                        $jml_all = ($jum_hour_mnt + $jum_mnt + $jum_second - $toleransi_mnt);
                        // dd($date1);
                        // 
                        $lokasi_kantor = Lokasi::where('lokasi_kantor', $lokasi_kerja)->first();
                        $lat_kantor = $lokasi_kantor->lat_kantor;
                        $long_kantor = $lokasi_kantor->long_kantor;
                        // absen
                        $update = MappingShift::where('id', $request->id_mapping)->first();
                        $update->jam_absen = date('H:i:s');
                        $update->telat = $jml_all;
                        $update->foto_jam_absen = $request['foto_jam_absen'];
                        $update->lat_absen = $request['lat_absen'];
                        $update->long_absen = $request['long_absen'];
                        $update->jarak_masuk = $request['jarak_masuk'];
                        $update->status_absen = 'Masuk';
                        $update->keterangan_absensi = 'Datang Terlambat, Sesuai Lokasi Absen';
                        $update->update();

                        ActivityLog::create([
                            'user_id' => Auth::user()->id,
                            'activity' => 'tambah',
                            'description' => 'Absen Masuk Pada Tanggal ' . $tanggal,
                            'status_absen_skrg' => MappingShift::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->get(),
                        ]);

                        $request->session()->flash('absenmasuksuccess');
                        return redirect('home');
                    }
                }
            }
        }
    }
    public function myLocation(Request $request)
    {
        return redirect('/home/maps/' . $request["lat"] . '/' . $request['long']);
    }

    public function absenMasuk(Request $request, $id)
    {
        $lokasi_kerja = Auth::guard('web')->user()->penempatan_kerja;
        if ($lokasi_kerja == '' || $lokasi_kerja == NULL) {
            $request->session()->flash('lokasikerjanull', 'Gagal Absen Masuk');
            return redirect('/home');
        } else {
            $cek_penugasan = MappingShift::where('id', $id)
                ->where('keterangan_absensi', 'ABSENSI PENUGASAN WILAYAH KANTOR')
                ->first();
            if ($cek_penugasan != '' || $cek_penugasan != NULL) {
                $request->session()->flash('penugasan_wilayah_kantor');
                return redirect('/home');
            } else {
                // dd('ok1');
                date_default_timezone_set('Asia/Jakarta');
                $user_login = auth()->user()->id;
                $lokasi_kantor = Lokasi::where('lokasi_kantor', $lokasi_kerja)->first();
                $lat_kantor = $lokasi_kantor->lat_kantor;
                $long_kantor = $lokasi_kantor->long_kantor;
                // dd($lokasi_kantor);
                $tglskrg = date('Y-m-d');
                $request["jarak_masuk"] = $this->distance($request["lat_absen"], $request["long_absen"], $lat_kantor, $long_kantor, "K") * 1000;
                // dd($request["jarak_masuk"], $lokasi_kantor->radius);
                if ($request["jarak_masuk"] > $lokasi_kantor->radius) {
                    // dd('oke');
                    $request->session()->flash('absenmasukoutradius', 'Gagal Absen Masuk');
                    return redirect('/home');
                } else {
                    // dd('gak oke');
                    // dd($request["jam_absen"]);
                    $foto_jam_absen = $request["foto_jam_absen"];

                    $image_parts = explode(";base64,", $foto_jam_absen);

                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = 'foto_jam_absen/' . uniqid() . '.png';
                    // dd($image_parts);
                    Storage::put($fileName, $image_base64);


                    $request["foto_jam_absen"] = $fileName;

                    $mapping_shift = MappingShift::where('id', $id)->get();

                    foreach ($mapping_shift as $mp) {
                        $shift = $mp->Shift->jam_masuk;
                        $tanggal = $mp->tanggal;
                    }

                    $tgl_skrg = date("Y-m-d H:i:s");

                    $date1          = new DateTime($tanggal . $shift);
                    $date2          = new DateTime($tgl_skrg);
                    $interval       = $date1->diff($date2);
                    $jum_mnt  = ($interval->i);
                    $jum_hours  = ($interval->h);
                    $jum_second  = (($interval->s) / 60);
                    $jum_hour_mnt  = ($jum_hours * 60);
                    $toleransi_mnt = 5;
                    $jml_all = ($jum_hour_mnt + $jum_mnt + $jum_second - $toleransi_mnt);
                    // dd($jml_all);
                    // dd($diff); // 5273
                    if ($jml_all <= 0) {
                        $telat = 0;
                    } else if ($jml_all > 10 || $jml_all <= 120) {
                        $telat = $jml_all;
                        $user = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
                            ->join('level_jabatans', 'jabatans.level_id', '=', 'level_jabatans.id')
                            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                            ->where('users.id', Auth()->user()->id)->first();
                        $jam_kerja = MappingShift::with('Shift')->where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
                        // dd($jam_kerja);
                        $kontrak = Auth::guard('web')->user()->kontrak_kerja;
                        if ($user->level_jabatan == 4) {
                            // dd($kontrak);
                            $IdLevelAsasan  = LevelJabatan::where('level_jabatan', '3')->first();
                            $IdLevelAsasan1  = LevelJabatan::where('level_jabatan', '2')->first();
                            $IdLevelAsasan2  = LevelJabatan::where('level_jabatan', '1')->first();
                            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                                ->where('is_admin', 'user')
                                ->where('users.id', '!=', Auth::user()->id)
                                ->where('users.divisi_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi1_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi2_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi3_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi4_id', Auth::user()->divisi_id)
                                ->get();
                            $atasan = DB::table('users')
                                ->join('jabatans', function ($join) use ($IdLevelAsasan) {
                                    $join->on('jabatans.id', '=', 'users.jabatan_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                                    $join->join('level_jabatans', function ($query) use ($IdLevelAsasan) {
                                        $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                                        $query->where('level_jabatans.id', '=', $IdLevelAsasan->id);
                                    });
                                })
                                ->where('users.is_admin', 'user')
                                ->where('users.divisi_id', $user->divisi_id)
                                ->orWhere('users.divisi1_id', $user->divisi_id)
                                ->orWhere('users.divisi2_id', $user->divisi_id)
                                ->orWhere('users.divisi3_id', $user->divisi_id)
                                ->orWhere('users.divisi4_id', $user->divisi_id)
                                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                                ->first();
                            // dd($atasan1);
                            // dd($atasan);
                            if ($atasan == '' || $atasan == NULL) {
                                $atasan1 = DB::table('users')
                                    ->join('jabatans', function ($join) use ($IdLevelAsasan1) {
                                        $join->on('jabatans.id', '=', 'users.jabatan_id');
                                        $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                                        $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                                        $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                                        $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                                        $join->join('level_jabatans', function ($query) use ($IdLevelAsasan1) {
                                            $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                                            $query->where('level_jabatans.id', '=', $IdLevelAsasan1->id);
                                        });
                                    })
                                    ->where('users.is_admin', 'user')
                                    ->where('users.divisi_id', $user->divisi_id)
                                    ->orWhere('users.divisi1_id', $user->divisi_id)
                                    ->orWhere('users.divisi2_id', $user->divisi_id)
                                    ->orWhere('users.divisi3_id', $user->divisi_id)
                                    ->orWhere('users.divisi4_id', $user->divisi_id)
                                    ->where('users.divisi_id', $user->divisi1_id)
                                    ->orWhere('users.divisi1_id', $user->divisi1_id)
                                    ->orWhere('users.divisi2_id', $user->divisi1_id)
                                    ->orWhere('users.divisi3_id', $user->divisi1_id)
                                    ->orWhere('users.divisi4_id', $user->divisi1_id)
                                    ->where('users.divisi_id', $user->divisi2_id)
                                    ->orWhere('users.divisi1_id', $user->divisi2_id)
                                    ->orWhere('users.divisi2_id', $user->divisi2_id)
                                    ->orWhere('users.divisi3_id', $user->divisi2_id)
                                    ->orWhere('users.divisi4_id', $user->divisi2_id)
                                    ->where('users.divisi_id', $user->divisi3_id)
                                    ->orWhere('users.divisi1_id', $user->divisi3_id)
                                    ->orWhere('users.divisi2_id', $user->divisi3_id)
                                    ->orWhere('users.divisi3_id', $user->divisi3_id)
                                    ->orWhere('users.divisi4_id', $user->divisi3_id)
                                    ->where('users.divisi_id', $user->divisi4_id)
                                    ->orWhere('users.divisi1_id', $user->divisi4_id)
                                    ->orWhere('users.divisi2_id', $user->divisi4_id)
                                    ->orWhere('users.divisi3_id', $user->divisi4_id)
                                    ->orWhere('users.divisi4_id', $user->divisi4_id)
                                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                                    ->first();
                                // dd($atasan1);
                                if ($atasan1->kontrak_kerja == $kontrak) {
                                    $getUserAtasan  = $atasan1;
                                } else {
                                    $getUserAtasan  = NULL;
                                }
                                if ($atasan1 == '' || $atasan1 == NULL) {
                                    $atasan2 = DB::table('users')
                                        ->join('jabatans', function ($join) use ($IdLevelAsasan2) {
                                            $join->on('jabatans.id', '=', 'users.jabatan_id');
                                            $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                                            $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                                            $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                                            $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                                            $join->join('level_jabatans', function ($query) use ($IdLevelAsasan2) {
                                                $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                                                $query->where('level_jabatans.id', '=', $IdLevelAsasan2->id);
                                            });
                                        })
                                        ->where('users.is_admin', 'user')
                                        ->where('users.divisi_id', $user->divisi_id)
                                        ->orWhere('users.divisi1_id', $user->divisi1_id)
                                        ->orWhere('users.divisi2_id', $user->divisi2_id)
                                        ->orWhere('users.divisi3_id', $user->divisi3_id)
                                        ->orWhere('users.divisi4_id', $user->divisi4_id)
                                        ->where('users.divisi_id', $user->divisi1_id)
                                        ->orWhere('users.divisi1_id', $user->divisi1_id)
                                        ->orWhere('users.divisi2_id', $user->divisi1_id)
                                        ->orWhere('users.divisi3_id', $user->divisi1_id)
                                        ->orWhere('users.divisi4_id', $user->divisi1_id)
                                        ->where('users.divisi_id', $user->divisi2_id)
                                        ->orWhere('users.divisi1_id', $user->divisi2_id)
                                        ->orWhere('users.divisi2_id', $user->divisi2_id)
                                        ->orWhere('users.divisi3_id', $user->divisi2_id)
                                        ->orWhere('users.divisi4_id', $user->divisi2_id)
                                        ->where('users.divisi_id', $user->divisi3_id)
                                        ->orWhere('users.divisi1_id', $user->divisi3_id)
                                        ->orWhere('users.divisi2_id', $user->divisi3_id)
                                        ->orWhere('users.divisi3_id', $user->divisi3_id)
                                        ->orWhere('users.divisi4_id', $user->divisi3_id)
                                        ->where('users.divisi_id', $user->divisi4_id)
                                        ->orWhere('users.divisi1_id', $user->divisi4_id)
                                        ->orWhere('users.divisi2_id', $user->divisi4_id)
                                        ->orWhere('users.divisi3_id', $user->divisi4_id)
                                        ->orWhere('users.divisi4_id', $user->divisi4_id)
                                        ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                                        ->first();
                                    if ($atasan2->_kerja == $kontrak) {
                                        $getUserAtasan  = $atasan2;
                                    } else {
                                        $getUserAtasan  = NULL;
                                    }
                                } else {
                                    if ($atasan1 == $kontrak) {
                                        $getUserAtasan  = $atasan;
                                    } else {
                                        $getUserAtasan  = NULL;
                                    }
                                }
                            } else {
                                if ($atasan->kontrak_kerja == $kontrak) {
                                    $getUserAtasan  = $atasan;
                                } else {
                                    $getUserAtasan  = NULL;
                                }
                            }
                            // dd($getUserAtasan);
                        } else if ($user->level_jabatan == 3) {
                            $IdLevelAsasan  = LevelJabatan::where('level_jabatan', '2')->first();
                            $IdLevelAsasan1  = LevelJabatan::where('level_jabatan', '1')->first();
                            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                                ->where('is_admin', 'user')
                                ->where('users.id', '!=', Auth::user()->id)
                                ->where('users.divisi_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi1_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi2_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi3_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi4_id', Auth::user()->divisi_id)
                                ->get();
                            $atasan = DB::table('users')
                                ->where('users.is_admin', 'user')
                                ->where('users.divisi_id', $user->divisi_id)
                                ->orWhere('users.divisi1_id', $user->divisi_id)
                                ->orWhere('users.divisi2_id', $user->divisi_id)
                                ->orWhere('users.divisi3_id', $user->divisi_id)
                                ->orWhere('users.divisi4_id', $user->divisi_id)
                                // ->where('users.divisi_id', $user->divisi1_id)
                                // ->orWhere('users.divisi1_id', $user->divisi1_id)
                                // ->orWhere('users.divisi2_id', $user->divisi1_id)
                                // ->orWhere('users.divisi3_id', $user->divisi1_id)
                                // ->orWhere('users.divisi4_id', $user->divisi1_id)
                                // ->where('users.divisi_id', $user->divisi2_id)
                                // ->orWhere('users.divisi1_id', $user->divisi2_id)
                                // ->orWhere('users.divisi2_id', $user->divisi2_id)
                                // ->orWhere('users.divisi3_id', $user->divisi2_id)
                                // ->orWhere('users.divisi4_id', $user->divisi2_id)
                                // ->where('users.divisi_id', $user->divisi3_id)
                                // ->orWhere('users.divisi1_id', $user->divisi3_id)
                                // ->orWhere('users.divisi2_id', $user->divisi3_id)
                                // ->orWhere('users.divisi3_id', $user->divisi3_id)
                                // ->orWhere('users.divisi4_id', $user->divisi3_id)
                                // ->where('users.divisi_id', $user->divisi4_id)
                                // ->orWhere('users.divisi1_id', $user->divisi4_id)
                                // ->orWhere('users.divisi2_id', $user->divisi4_id)
                                // ->orWhere('users.divisi3_id', $user->divisi4_id)
                                // ->orWhere('users.divisi4_id', $user->divisi4_id)
                                ->join('jabatans', function ($join) use ($IdLevelAsasan) {
                                    $join->on('jabatans.id', '=', 'users.jabatan_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                                    $join->join('level_jabatans', function ($query) use ($IdLevelAsasan) {
                                        $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                                        $query->where('level_jabatans.id', '=', $IdLevelAsasan->id);
                                    });
                                })
                                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                                ->orderBy('users.id', 'DESC')
                                ->first();
                            // dd($atasan);
                            if ($atasan == '' || $atasan == NULL) {
                                $atasan1 = DB::table('users')
                                    ->join('jabatans', function ($join) use ($IdLevelAsasan1) {
                                        $join->on('jabatans.id', '=', 'users.jabatan_id');
                                        $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                                        $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                                        $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                                        $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                                        $join->join('level_jabatans', function ($query) use ($IdLevelAsasan1) {
                                            $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                                            $query->where('level_jabatans.id', '=', $IdLevelAsasan1->id);
                                        });
                                    })->where('users.divisi_id', $user->divisi_id)
                                    ->orWhere('users.divisi1_id', $user->divisi_id)
                                    ->orWhere('users.divisi2_id', $user->divisi_id)
                                    ->orWhere('users.divisi3_id', $user->divisi_id)
                                    ->orWhere('users.divisi4_id', $user->divisi_id)
                                    // ->where('users.divisi_id', $user->divisi1_id)
                                    // ->orWhere('users.divisi1_id', $user->divisi1_id)
                                    // ->orWhere('users.divisi2_id', $user->divisi1_id)
                                    // ->orWhere('users.divisi3_id', $user->divisi1_id)
                                    // ->orWhere('users.divisi4_id', $user->divisi1_id)
                                    // ->where('users.divisi_id', $user->divisi2_id)
                                    // ->orWhere('users.divisi1_id', $user->divisi2_id)
                                    // ->orWhere('users.divisi2_id', $user->divisi2_id)
                                    // ->orWhere('users.divisi3_id', $user->divisi2_id)
                                    // ->orWhere('users.divisi4_id', $user->divisi2_id)
                                    // ->where('users.divisi_id', $user->divisi3_id)
                                    // ->orWhere('users.divisi1_id', $user->divisi3_id)
                                    // ->orWhere('users.divisi2_id', $user->divisi3_id)
                                    // ->orWhere('users.divisi3_id', $user->divisi3_id)
                                    // ->orWhere('users.divisi4_id', $user->divisi3_id)
                                    // ->where('users.divisi_id', $user->divisi4_id)
                                    // ->orWhere('users.divisi1_id', $user->divisi4_id)
                                    // ->orWhere('users.divisi2_id', $user->divisi4_id)
                                    // ->orWhere('users.divisi3_id', $user->divisi4_id)
                                    // ->orWhere('users.divisi4_id', $user->divisi4_id)
                                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                                    ->first();
                                if ($atasan1 == '' || $atasan1 == NULL) {
                                    $getUserAtasan  = NULL;
                                } else {
                                    if ($atasan1->kontrak_kerja == $kontrak) {
                                        $getUserAtasan  = $atasan1;
                                    } else {
                                        $getUserAtasan  = NULL;
                                    }
                                }
                            } else {
                                if ($atasan->kontrak_kerja == $kontrak) {
                                    $getUserAtasan  = $atasan;
                                } else {
                                    $getUserAtasan  = NULL;
                                }
                            }
                        } else if ($user->level_jabatan == 2) {
                            $IdLevelAsasan  = LevelJabatan::where('level_jabatan', '1')->first();
                            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                                ->where('is_admin', 'user')
                                ->where('users.id', '!=', Auth::user()->id)
                                ->where('users.divisi_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi1_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi2_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi3_id', Auth::user()->divisi_id)
                                ->orWhere('users.divisi4_id', Auth::user()->divisi_id)
                                ->get();
                            $atasan = DB::table('users')
                                ->join('jabatans', function ($join) use ($IdLevelAsasan) {
                                    $join->on('jabatans.id', '=', 'users.jabatan_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                                    $join->join('level_jabatans', function ($query) use ($IdLevelAsasan) {
                                        $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                                        $query->where('level_jabatans.id', '=', $IdLevelAsasan->id);
                                    });
                                })
                                ->where('users.is_admin', 'user')
                                ->where('users.dept_id', $user->dept_id)
                                ->where('users.divisi_id', $user->divisi_id)
                                ->orWhere('users.divisi1_id', $user->divisi_id)
                                ->orWhere('users.divisi2_id', $user->divisi_id)
                                ->orWhere('users.divisi3_id', $user->divisi_id)
                                ->orWhere('users.divisi4_id', $user->divisi_id)
                                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                                ->first();
                            // dd($atasan);
                            if ($atasan == '' || $atasan == NULL) {
                                $getUserAtasan  = NULL;
                            } else {
                                if ($atasan->kontrak_kerja == $kontrak) {
                                    $getUserAtasan  = $atasan;
                                } else {
                                    $getUserAtasan  = NULL;
                                }
                            }
                        } else {
                            $atasan = DB::table('users')
                                ->join('jabatans', function ($join) {
                                    $join->on('jabatans.id', '=', 'users.jabatan_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
                                    $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
                                    $join->join('level_jabatans', function ($query) {
                                        $query->on('level_jabatans.id', '=', 'jabatans.level_id');
                                        $query->where('level_jabatans.level_jabatan', '=', '0');
                                    });
                                })
                                ->where('users.divisi_id', $user->divisi_id)
                                ->orWhere('users.divisi1_id', $user->divisi_id)
                                ->orWhere('users.divisi2_id', $user->divisi_id)
                                ->orWhere('users.divisi3_id', $user->divisi_id)
                                ->orWhere('users.divisi4_id', $user->divisi_id)
                                ->where('users.divisi_id', $user->divisi1_id)
                                ->orWhere('users.divisi1_id', $user->divisi1_id)
                                ->orWhere('users.divisi2_id', $user->divisi1_id)
                                ->orWhere('users.divisi3_id', $user->divisi1_id)
                                ->orWhere('users.divisi4_id', $user->divisi1_id)
                                ->where('users.divisi_id', $user->divisi2_id)
                                ->orWhere('users.divisi1_id', $user->divisi2_id)
                                ->orWhere('users.divisi2_id', $user->divisi2_id)
                                ->orWhere('users.divisi3_id', $user->divisi2_id)
                                ->orWhere('users.divisi4_id', $user->divisi2_id)
                                ->where('users.divisi_id', $user->divisi3_id)
                                ->orWhere('users.divisi1_id', $user->divisi3_id)
                                ->orWhere('users.divisi2_id', $user->divisi3_id)
                                ->orWhere('users.divisi3_id', $user->divisi3_id)
                                ->orWhere('users.divisi4_id', $user->divisi3_id)
                                ->where('users.divisi_id', $user->divisi4_id)
                                ->orWhere('users.divisi1_id', $user->divisi4_id)
                                ->orWhere('users.divisi2_id', $user->divisi4_id)
                                ->orWhere('users.divisi3_id', $user->divisi4_id)
                                ->orWhere('users.divisi4_id', $user->divisi4_id)
                                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                                ->first();
                            // dd($atasan);
                            $get_user_backup = NULL;
                            $getUserAtasan = NULL;
                        }
                        return view('users.absen.form_datang_terlambat', [
                            'jam_datang' => date('H:i:s'),
                            'jumlah_terlambat' => $jml_all,
                            'getUserAtasan' => $getUserAtasan,
                            'jam_kerja' => $jam_kerja,
                            'user' => $user,
                            'telat' => $telat,
                            'foto_jam_absen' => $request["foto_jam_absen"],
                            'jarak_masuk' => $request["jarak_masuk"],
                            'lat_absen' => $request["lat_absen"],
                            'long_absen' => $request["long_absen"],
                        ]);
                    } else if ($jml_all < 120) {
                        $request->session()->flash('absen_tidak_masuk');
                        return redirect('home');
                    } else if ($jml_all < 10) {
                        $telat = $jml_all;
                    }


                    // dd(date('H:i:s'));
                    $update = MappingShift::where('id', $id)->first();
                    $update->jam_absen = date('H:i:s');
                    $update->telat = $telat;
                    $update->foto_jam_absen = $request['foto_jam_absen'];
                    $update->lat_absen = $request['lat_absen'];
                    $update->long_absen = $request['long_absen'];
                    $update->jarak_masuk = $request['jarak_masuk'];
                    $update->status_absen = 'Masuk';
                    $update->keterangan_absensi = 'Sesuai Lokasi';
                    $update->update();

                    ActivityLog::create([
                        'user_id' => Auth::user()->id,
                        'activity' => 'tambah',
                        'description' => 'Absen Masuk Pada Tanggal ' . $tanggal,
                        'status_absen_skrg' => MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->get(),
                    ]);

                    // dd($tglskrg);
                    $request->session()->flash('absenmasuksuccess', 'Berhasil Absen Masuk');
                    return redirect('home');
                }
            }
        }
    }

    public function absenPulang(Request $request, $id)
    {
        // dd($request->all());
        $time_now = date('H:i');
        $date_now = date('Y-m-d');
        $date1          = new DateTime($date_now . $request->jam_masuk);
        $date2          = new DateTime($date_now . $time_now);
        $interval       = $date1->diff($date2);
        // dd($interval->h);
        $lokasi_kerja = Auth::guard('web')->user()->penempatan_kerja;
        if ($lokasi_kerja == '' || $lokasi_kerja == NULL) {
            $request->session()->flash('lokasikerjanull', 'Gagal Absen Masuk');
            return redirect('/home');
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $user_login = auth()->user()->id;
            $lokasi_kantor = Lokasi::where('lokasi_kantor', Auth::guard('web')->user()->penempatan_kerja)->first();
            // dd($lokasi_kantor);
            $lat_kantor = $lokasi_kantor->lat_kantor;
            $long_kantor = $lokasi_kantor->long_kantor;
            $tglskrg = date('Y-m-d');
            $request["jarak_pulang"] = $this->distance($request["lat_pulang"], $request["long_pulang"], $lat_kantor, $long_kantor, "K") * 1000;
            // dd($request["jarak_pulang"], $lokasi_kantor->radius);
            if ($request["jarak_pulang"] > $lokasi_kantor->radius) {
                $request->session()->flash('absenpulangoutradius', 'Gagal Absen Pulang');
                return redirect('/home');
            } else {
                $foto_jam_pulang = $request["foto_jam_pulang"];

                $image_parts = explode(";base64,", $foto_jam_pulang);

                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'foto_jam_pulang/' . uniqid() . '.png';

                Storage::put($fileName, $image_base64);

                $request["foto_jam_pulang"] = $fileName;

                $mapping_shift = MappingShift::where('id', $id)->get();
                foreach ($mapping_shift as $mp) {
                    $shiftmasuk = $mp->Shift->jam_masuk;
                    $shiftpulang = $mp->Shift->jam_keluar;
                    $tanggal = $mp->tanggal;
                }
                $new_tanggal = "";
                $timeMasuk = strtotime($shiftmasuk);
                $timePulang = strtotime($shiftpulang);


                if ($timePulang < $timeMasuk) {
                    $new_tanggal = date('Y-m-d', strtotime('+1 days', strtotime($tanggal)));
                } else {
                    $new_tanggal = $tanggal;
                }

                $tgl_skrg = date("Y-m-d");

                $akhir = new DateTime($new_tanggal . $shiftpulang);
                $awal  = new DateTime($tgl_skrg . $request["jam_pulang"]);
                $diff  = $awal->diff($akhir);
                $hours = $diff->h * 60;
                $hitung_pulang_cepat = ($diff->i + $hours);

                if ($interval->h <= 6) {
                    $request["pulang_cepat"] = 0;
                    $keterangan_absen = 'Tidak Masuk, Absen Pulang < 6 Jam Kerja';
                    $status_absen = 'Tidak Masuk';
                } else {
                    if ($diff <= 0) {
                        $request["pulang_cepat"] = 0;
                    } else {
                        $request["pulang_cepat"] = $hitung_pulang_cepat;
                        $status_absen = 'Masuk';
                        $keterangan_absen = 'Sesuai Lokasi';
                    }
                }

                $validatedData = $request->validate([
                    'jam_pulang' => 'required',
                    'foto_jam_pulang' => 'required',
                    'lat_pulang' => 'required',
                    'long_pulang' => 'required',
                    'pulang_cepat' => 'required',
                    'jarak_pulang' => 'required'
                ]);

                $update = MappingShift::where('id', $id)->first();
                $update->jam_pulang           = $validatedData['jam_pulang'];
                $update->foto_jam_pulang      = $validatedData['foto_jam_pulang'];
                $update->lat_pulang           = $validatedData['lat_pulang'];
                $update->long_pulang          = $validatedData['long_pulang'];
                $update->pulang_cepat         = $validatedData['pulang_cepat'];
                $update->jarak_pulang         = $validatedData['jarak_pulang'];
                $update->keterangan_absensi   = $keterangan_absen;
                $update->status_absen         = $status_absen;
                $update->update();

                ActivityLog::create([
                    'user_id' => Auth::user()->id,
                    'activity' => 'tambah',
                    'description' => 'Absen Pulang Pada Tanggal ' . $tanggal,
                    'status_absen_skrg' => MappingShift::where('user_id', $user_login)->where('tanggal', $tglskrg)->get(),

                ]);
                $request->session()->flash('absenpulangsuccess', 'Berhasil Absen Pulang');
                return redirect('/home');
            }
        }
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public function dataAbsen(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tglskrg = date('Y-m-d');
        $data_absen = MappingShift::where('tanggal', $tglskrg);

        if ($request["mulai"] == null) {
            $request["mulai"] = $request["akhir"];
        }

        if ($request["akhir"] == null) {
            $request["akhir"] = $request["mulai"];
        }

        if ($request["user_id"] && $request["mulai"] && $request["akhir"]) {
            $data_absen = MappingShift::where('user_id', $request["user_id"])->whereBetween('tanggal', [$request["mulai"], $request["akhir"]]);
        }

        return view('absen.dataabsen', [
            'title' => 'Data Absen',
            'user' => User::select('id', 'name')->get(),
            'data_absen' => $data_absen->get()
        ]);
    }

    public function maps($lat, $long)
    {
        date_default_timezone_set('Asia/Jakarta');
        return view('users.absen.locationmaps', [
            'title' => 'Maps',
            'lat' => $lat,
            'long' => $long,
            'lokasi_kantor' => Lokasi::first()
        ]);
    }

    public function editMasuk($id)
    {
        return view('absen.editmasuk', [
            'title' => 'Edit Absen Masuk',
            'data_absen' => MappingShift::findOrFail($id),
            'lokasi_kantor' => Lokasi::first()
        ]);
    }

    public function prosesEditMasuk(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $mapping_shift = MappingShift::where('id', $id)->get();

        foreach ($mapping_shift as $mp) {
            $shift = $mp->Shift->jam_masuk;
            $tanggal = $mp->tanggal;
        }

        $awal  = strtotime($tanggal . $shift);
        $akhir = strtotime($tanggal . $request["jam_absen"]);
        $diff  = $akhir - $awal;

        if ($diff <= 0) {
            $request["telat"] = 0;
        } else {
            $request["telat"] = $diff;
        }

        $lokasi_kantor = Lokasi::first();
        $lat_kantor = $lokasi_kantor->lat_kantor;
        $long_kantor = $lokasi_kantor->long_kantor;

        $request["jarak_masuk"] = $this->distance($request["lat_absen"], $request["long_absen"], $lat_kantor, $long_kantor, "K") * 1000;

        $validatedData = $request->validate([
            'jam_absen' => 'required',
            'telat' => 'nullable',
            'foto_jam_absen' => 'image|max:5000',
            'lat_absen' => 'required',
            'long_absen' => 'required',
            'jarak_masuk' => 'required',
            'status_absen' => 'required'
        ]);

        if ($request->file('foto_jam_absen')) {
            if ($request->foto_jam_absen_lama) {
                Storage::delete($request->foto_jam_absen_lama);
            }
            $validatedData['foto_jam_absen'] = $request->file('foto_jam_absen')->store('foto_jam_absen');
        }

        MappingShift::where('id', $id)->update($validatedData);
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'tambah',
            'description' => 'Edit Absen Masuk Pada Tanggal ' . $tanggal
        ]);
        return redirect('/data-absen')->with('success', 'Berhasil Edit Absen Masuk (Manual)');
    }

    public function editPulang($id)
    {
        return view('absen.editpulang', [
            'title' => 'Edit Absen Pulang',
            'data_absen' => MappingShift::findOrFail($id),
            'lokasi_kantor' => Lokasi::first()
        ]);
    }

    public function prosesEditPulang(Request $request, $id)
    {
        $mapping_shift = MappingShift::where('id', $id)->get();
        foreach ($mapping_shift as $mp) {
            $shiftmasuk = $mp->Shift->jam_masuk;
            $shiftpulang = $mp->Shift->jam_keluar;
            $tanggal = $mp->tanggal;
        }
        $new_tanggal = "";
        $timeMasuk = strtotime($shiftmasuk);
        $timePulang = strtotime($shiftpulang);


        if ($timePulang < $timeMasuk) {
            $new_tanggal = date('Y-m-d', strtotime('+1 days', strtotime($tanggal)));
        } else {
            $new_tanggal = $tanggal;
        }

        $akhir = strtotime($new_tanggal . $shiftpulang);
        $awal  = strtotime($new_tanggal . $request["jam_pulang"]);
        $diff  = $akhir - $awal;

        if ($diff <= 0) {
            $request["pulang_cepat"] = 0;
        } else {
            $request["pulang_cepat"] = $diff;
        }

        $lokasi_kantor = Lokasi::first();
        $lat_kantor = $lokasi_kantor->lat_kantor;
        $long_kantor = $lokasi_kantor->long_kantor;

        $request["jarak_pulang"] = $this->distance($request["lat_pulang"], $request["long_pulang"], $lat_kantor, $long_kantor, "K") * 1000;

        $validatedData = $request->validate([
            'jam_pulang' => 'required',
            'foto_jam_pulang' => 'image|max:5000',
            'lat_pulang' => 'required',
            'long_pulang' => 'required',
            'pulang_cepat' => 'required',
            'jarak_pulang' => 'required'
        ]);

        if ($request->file('foto_jam_pulang')) {
            if ($request->foto_jam_pulang_lama) {
                Storage::delete($request->foto_jam_pulang_lama);
            }
            $validatedData['foto_jam_pulang'] = $request->file('foto_jam_pulang')->store('foto_jam_pulang');
        }

        MappingShift::where('id', $id)->update($validatedData);
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'tambah',
            'description' => 'Edit Absen Pulang Pada Tanggal ' . $tanggal
        ]);

        return redirect('/data-absen')->with('success', 'Berhasil Edit Absen Pulang (Manual)');
    }

    public function deleteAdmin($id)
    {
        $delete = MappingShift::find($id);
        Storage::delete($delete->foto_jam_absen);
        Storage::delete($delete->foto_jam_pulang);
        $delete->delete();
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'hapus',
            'description' => 'Hapus Absen'
        ]);
        return redirect('/data-absen')->with('success', 'Data Berhasil di Delete');
    }

    public function myAbsen(Request $request)
    {
        $user_login = auth()->user()->id;
        $date_now = date('Y');
        $month_now = date('m');
        $month_yesterday = \Carbon\Carbon::now()->subMonthsNoOverflow()->isoFormat('MM');
        $month_yesterday1 = \Carbon\Carbon::now()->subMonthsNoOverflow()->isoFormat('MMMM');
        $month_now1 = \Carbon\Carbon::now()->isoFormat('MMMM');
        date_default_timezone_set('Asia/Jakarta');
        $user_login = auth()->user()->id;
        $tanggal = "";
        $tglskrg = date('Y-m-d');
        $tglkmrn = date('Y-m-d', strtotime('-1 days'));
        $mapping_shift = MappingShift::where('user_id', $user_login)->where('tanggal', $tglkmrn)->get();
        $tidak_masuk = MappingShift::where('status_absen', 'Tidak Masuk')
            ->where('user_id', $user_login)
            ->select(DB::raw("COUNT(*) as count"))
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw("Month(tanggal)"))
            ->pluck('count');
        $masuk = MappingShift::where('mapping_shifts.status_absen', 'Masuk')
            ->where('user_id', $user_login)
            ->select(DB::raw("COUNT(mapping_shifts.tanggal) as count"))
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw("Month(tanggal)"))
            ->pluck('count');
        $telat = MappingShift::where('status_absen', 'Telat')
            ->where('user_id', $user_login)
            ->select(DB::raw("COUNT(*) as count"))
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw("Month(tanggal)"))
            ->pluck('count');
        // dd();
        $telat_now = MappingShift::whereMonth('tanggal', $month_now)
            ->where('user_id', $user_login)
            ->select(DB::raw("telat as count"))
            ->pluck('count');
        $telat_yesterday = MappingShift::whereMonth('tanggal', $month_yesterday)
            ->where('user_id', $user_login)
            ->select(DB::raw("telat as count"))
            ->pluck('count');
        $lembur_now = MappingShift::whereMonth('tanggal', $month_now)
            ->where('user_id', $user_login)
            ->select(DB::raw("lembur as count"))
            ->pluck('count');
        $lembur_yesterday = MappingShift::whereMonth('tanggal', $month_yesterday)
            ->where('user_id', $user_login)
            ->select(DB::raw("lembur as count"))
            ->pluck('count');
        $data_telat_now = MappingShift::whereMonth('tanggal', $month_yesterday)
            ->where('user_id', $user_login)
            ->select(DB::raw("tanggal as count"))
            ->pluck('count');
        $data_telat_yesterday = MappingShift::whereMonth('tanggal', $month_yesterday)
            ->where('user_id', $user_login)
            ->select(DB::raw("tanggal as count "))
            ->pluck('count');
        if ($mapping_shift->count() > 0) {
            foreach ($mapping_shift as $mp) {
                $jam_absen = $mp->jam_absen;
                $jam_pulang = $mp->jam_pulang;
            }
        } else {
            $jam_absen = "-";
            $jam_pulang = "-";
        }
        if ($jam_absen != null && $jam_pulang == null) {
            $tanggal = $tglkmrn;
        } else {
            $tanggal = $tglskrg;
        }

        date_default_timezone_set('Asia/Jakarta');
        $tglskrg = date('Y-m-d');
        $data_absen = MappingShift::where('tanggal', $tglskrg)->where('user_id', auth()->user()->id);

        if ($request["mulai"] == null) {
            $request["mulai"] = $request["akhir"];
        }

        if ($request["akhir"] == null) {
            $request["akhir"] = $request["mulai"];
        }

        if ($request["mulai"] && $request["akhir"]) {
            $data_absen = MappingShift::where('user_id', auth()->user()->id)->whereBetween('tanggal', [$request["mulai"], $request["akhir"]]);
        }

        return view('absen.myabsen', [
            'title' => 'My Absen',
            'shift_karyawan' => MappingShift::where('user_id', $user_login)->where('tanggal', $tanggal)->get(),
            'data_absen' => $data_absen->get(),
            'masuk' => array_map('intval', json_decode($masuk)),
            'tidak_masuk' => array_map('intval', json_decode($tidak_masuk)),
            'telat' => array_map('intval', json_decode($telat)),
            'date_now' => $date_now,
            'month_now1' => $month_now1,
            'month_yesterday1' => $month_yesterday1,
            'telat_now' => array_map('intval', json_decode($telat_now)),
            'telat_yesterday' => array_map('intval', json_decode($telat_yesterday)),
            'lembur_now' => array_map('intval', json_decode($lembur_now)),
            'data_telat_now' => $data_telat_now,
            'data_telat_yesterday' => $data_telat_yesterday,
            'lembur_yesterday' => array_map('intval', json_decode($lembur_yesterday))
        ]);
    }
}
