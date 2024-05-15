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
use App\Models\Lokasi;
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
        if ($user->kontrak_kerja == 'sp') {
            // Bu fitri
            $hrd = User::where('id', 'e30d4a42-5562-415c-b1b6-f6b9ccc379a1')->first();
            $finance = User::where('id', '436da676-5782-4f4e-ad50-52b45060430c')->first();
        } else if ($user->kontrak_kerja == 'sps') {
            $hrd = User::where('id', 'e30d4a42-5562-415c-b1b6-f6b9ccc379a1')->first();
            // diana sps
            $finance = User::where('id', 'b709b754-7b00-4118-ab3f-e9b2760b08cf')->first();
            $hrd = User::where('id', 'e30d4a42-5562-415c-b1b6-f6b9ccc379a1')->first();
        } else {
            $hrd = User::where('id', 'e30d4a42-5562-415c-b1b6-f6b9ccc379a1')->first();
            $finance = User::where('id', '436da676-5782-4f4e-ad50-52b45060430c')->first();
        }
        if ($userLevel->level_jabatan == 4) {
            $levelatasan    = 0;
            $levelatasan1    = $userLevel->level_jabatan - 1;
            $levelatasan2    = $userLevel->level_jabatan - 2;
            $levelatasan3    = $userLevel->level_jabatan - 3;
            $IdLevelAsasan   = DB::table('level_jabatans')->where('level_jabatan', $levelatasan)->first();
            $IdLevelAsasan1   = DB::table('level_jabatans')->where('level_jabatan', $levelatasan1)->first();
            $IdLevelAsasan2  = DB::table('level_jabatans')->where('level_jabatan', $levelatasan2)->first();
            $IdLevelAsasan3  = DB::table('level_jabatans')->where('level_jabatan', $levelatasan3)->first();
            $getAsatan       = DB::table('jabatans')->where('level_id', $IdLevelAsasan->id)->first();
            $getAsatan1       = DB::table('jabatans')->where('level_id', $IdLevelAsasan1->id)->where('divisi_id', $user->divisi_id)->first();
            $getAsatan2      = DB::table('jabatans')->where('level_id', $IdLevelAsasan2->id)->where('divisi_id', $user->divisi_id)->first();
            $getAsatan3      = DB::table('jabatans')->where('level_id', $IdLevelAsasan3->id)->where('divisi_id', $user->divisi_id)->first();
            $atasandirektur  = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan->id)->orWhere('jabatan1_id', $getAsatan->id)->orWhere('jabatan2_id', $getAsatan->id)->orWhere('jabatan3_id', $getAsatan->id)->orWhere('jabatan4_id', $getAsatan->id)->first();;
            $atasan1          = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan1->id)->orWhere('jabatan1_id', $getAsatan1->id)->orWhere('jabatan2_id', $getAsatan1->id)->orWhere('jabatan3_id', $getAsatan1->id)->orWhere('jabatan4_id', $getAsatan1->id)->first();
            $atasan2         = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan2->id)->orWhere('jabatan1_id', $getAsatan2->id)->orWhere('jabatan2_id', $getAsatan2->id)->orWhere('jabatan3_id', $getAsatan2->id)->orWhere('jabatan4_id', $getAsatan2->id)->first();
            $atasan3         = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan3->id)->orWhere('jabatan1_id', $getAsatan3->id)->orWhere('jabatan2_id', $getAsatan3->id)->orWhere('jabatan3_id', $getAsatan3->id)->orWhere('jabatan4_id', $getAsatan3->id)->first();
            // dd($user, $atasan, $atasan2, $atasan3);
            if ($atasan1 == '' || $atasan1 == NULL) {
                $getUserAtasan = $atasan2;
                $getUseratasan2 = $atasan3;
                // dd('atasan null');
                if ($getUserAtasan == NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
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
                $getUserAtasan = $atasan1;
                $getUseratasan2 = $atasan3;
                // dd('atasan null');
                if ($getUserAtasan == NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
                    // atasan bertingkat 4
                } else if ($getUserAtasan == NULL && $getUseratasan2 != NULL) {
                    $getUserAtasan = $atasan3;
                    $getUseratasan2 = $atasan3;
                } else if ($getUserAtasan != NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasan1;
                    $getUseratasan2 = $atasan1;
                } else if ($getUserAtasan != NULL && $getUseratasan2 != NULL) {
                    // dd('atasan null');
                    $getUserAtasan = $atasan1;
                    $getUseratasan2 = $atasan3;
                }
            } else {
                $getUserAtasan = $atasan1;
                $getUseratasan2 = $atasan2;
            }
        } else if ($userLevel->level_jabatan == 3) {
            $levelatasan    = 0;
            $levelatasan1    = $userLevel->level_jabatan - 1;
            $levelatasan2    = $userLevel->level_jabatan - 2;
            $IdLevelAsasan   = DB::table('level_jabatans')->where('level_jabatan', $levelatasan)->first();
            $IdLevelAsasan1   = DB::table('level_jabatans')->where('level_jabatan', $levelatasan1)->first();
            $IdLevelAsasan2  = DB::table('level_jabatans')->where('level_jabatan', $levelatasan2)->first();
            $getAsatan       = DB::table('jabatans')->where('level_id', $IdLevelAsasan->id)->first();
            $getAsatan1       = DB::table('jabatans')->where('level_id', $IdLevelAsasan1->id)->where('divisi_id', $user->divisi_id)->first();
            $getAsatan2      = DB::table('jabatans')->where('level_id', $IdLevelAsasan2->id)->where('divisi_id', $user->divisi_id)->first();
            $atasandirektur  = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan->id)->orWhere('jabatan1_id', $getAsatan->id)->orWhere('jabatan2_id', $getAsatan->id)->orWhere('jabatan3_id', $getAsatan->id)->orWhere('jabatan4_id', $getAsatan->id)->first();;
            $atasan1          = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan1->id)->orWhere('jabatan1_id', $getAsatan1->id)->orWhere('jabatan2_id', $getAsatan1->id)->orWhere('jabatan3_id', $getAsatan1->id)->orWhere('jabatan4_id', $getAsatan1->id)->first();
            $atasan2         = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan2->id)->orWhere('jabatan1_id', $getAsatan2->id)->orWhere('jabatan2_id', $getAsatan2->id)->orWhere('jabatan3_id', $getAsatan2->id)->orWhere('jabatan4_id', $getAsatan2->id)->first();
            // dd($user, $atasan, $atasan2, $atasan3);
            if ($atasan1 == '' || $atasan1 == NULL) {
                $getUserAtasan = $atasan2;
                $getUseratasan2 = $atasandirektur;
                // dd('atasan null');
                if ($getUserAtasan == NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
                    // atasan bertingkat 4
                } else if ($getUserAtasan == NULL && $getUseratasan2 != NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
                } else if ($getUserAtasan != NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasan2;
                    $getUseratasan2 = $atasan2;
                } else if ($getUserAtasan != NULL && $getUseratasan2 != NULL) {
                    $getUserAtasan = $atasan2;
                    $getUseratasan2 = $atasandirektur;
                }
            } else if ($atasan2 == '' && $atasan2 == NULL) {
                $getUserAtasan = $atasan1;
                $getUseratasan2 = $atasandirektur;
                // dd('atasan null');
                if ($getUserAtasan == NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
                    // atasan bertingkat 4
                } else if ($getUserAtasan == NULL && $getUseratasan2 != NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
                } else if ($getUserAtasan != NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasan1;
                    $getUseratasan2 = $atasan1;
                } else if ($getUserAtasan != NULL && $getUseratasan2 != NULL) {
                    // dd('atasan null');
                    $getUserAtasan = $atasan1;
                    $getUseratasan2 = $atasandirektur;
                }
            } else {
                $getUserAtasan = $atasan1;
                $getUseratasan2 = $atasan2;
            }
        } else if ($userLevel->level_jabatan == 2) {
            $levelatasan    = 0;
            $levelatasan1    = $userLevel->level_jabatan - 1;
            $IdLevelAsasan   = DB::table('level_jabatans')->where('level_jabatan', $levelatasan)->first();
            $IdLevelAsasan1   = DB::table('level_jabatans')->where('level_jabatan', $levelatasan1)->first();
            $getAsatan       = DB::table('jabatans')->where('level_id', $IdLevelAsasan->id)->first();
            $getAsatan1       = DB::table('jabatans')->where('level_id', $IdLevelAsasan1->id)->where('divisi_id', $user->divisi_id)->first();
            $atasandirektur  = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan->id)->orWhere('jabatan1_id', $getAsatan->id)->orWhere('jabatan2_id', $getAsatan->id)->orWhere('jabatan3_id', $getAsatan->id)->orWhere('jabatan4_id', $getAsatan->id)->first();
            $atasan1          = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan1->id)->orWhere('jabatan1_id', $getAsatan1->id)->orWhere('jabatan2_id', $getAsatan1->id)->orWhere('jabatan3_id', $getAsatan1->id)->orWhere('jabatan4_id', $getAsatan1->id)->first();
            // dd($user, $atasan, $atasan2, $atasan3);
            if ($atasan1 == '' || $atasan1 == NULL) {
                $getUserAtasan = $atasandirektur;
                $getUseratasan2 = $atasandirektur;
                // dd('atasan null');
                if ($getUserAtasan == NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
                    // atasan bertingkat 4
                } else if ($getUserAtasan == NULL && $getUseratasan2 != NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
                } else if ($getUserAtasan != NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
                } else if ($getUserAtasan != NULL && $getUseratasan2 != NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
                }
            } else if ($atasandirektur == '' && $atasandirektur == NULL) {
                $getUserAtasan = $atasan1;
                $getUseratasan2 = $atasandirektur;
                // dd('atasan null');
                if ($getUserAtasan == NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
                    // atasan bertingkat 4
                } else if ($getUserAtasan == NULL && $getUseratasan2 != NULL) {
                    $getUserAtasan = $atasandirektur;
                    $getUseratasan2 = $atasandirektur;
                } else if ($getUserAtasan != NULL && $getUseratasan2 == NULL) {
                    $getUserAtasan = $atasan1;
                    $getUseratasan2 = $atasan1;
                } else if ($getUserAtasan != NULL && $getUseratasan2 != NULL) {
                    // dd('atasan null');
                    $getUserAtasan = $atasan1;
                    $getUseratasan2 = $atasandirektur;
                }
            } else {
                $getUserAtasan = $atasan1;
                $getUseratasan2 = $atasandirektur;
            }
        } else {
            $IdLevelAsasan   = DB::table('level_jabatans')->where('level_jabatan', '0')->first();
            $getAsatan       = DB::table('jabatans')->where('level_id', $IdLevelAsasan->id)->first();
            $atasandirektur  = User::with('jabatan')->where('is_admin', 'user')->where('jabatan_id', $getAsatan->id)->orWhere('jabatan1_id', $getAsatan->id)->orWhere('jabatan2_id', $getAsatan->id)->orWhere('jabatan3_id', $getAsatan->id)->orWhere('jabatan4_id', $getAsatan->id)->first();
            $getUserAtasan = $atasandirektur;
            $getUseratasan2 = $atasandirektur;
        }

        $record_data        = DB::table('penugasans')->join('users', 'users.id', 'penugasans.id_user')->where('id_user', Auth::user()->id)
            ->select('penugasans.*', 'users.fullname')->orderBy('tanggal_pengajuan', 'DESC')->get();
        // dd($record_data);
        $lokasi_kantor = Lokasi::where('lokasi_kantor', '!=', $user->penempatan_kerja)->get();
        $get_kategori_cuti  = KategoriCuti::where('status', 1)->get();
        $get_user_backup    = User::where('dept_id', Auth::user()->dept_id)->where('divisi_id', Auth::user()->divisi_id)->where('id', '!=', Auth::user()->id)->get();
        return view(
            'users.penugasan.index',
            [
                'title'                 => 'Tambah Permintaan Cuti Karyawan',
                'data_user'             => $user,
                'data_cuti_user'        => Penugasan::where('id_user', $user_id)->orderBy('id', 'desc')->get(),
                'getUserAtasan'         => $getUserAtasan,
                'getUseratasan2'        => $getUseratasan2,
                'get_user_backup'       => $get_user_backup,
                'get_kategori_cuti'     => $get_kategori_cuti,
                'user'                  => $user,
                'record_data'           => $record_data,
                'hrd'           => $hrd,
                'finance'           => $finance,
                'lokasi_kantor'           => $lokasi_kantor,
            ]
        );
    }

    public function tambahPenugasan(Request $request)
    {
        $date_now = Carbon::now();
        if ($request->tanggal_kunjungan > $date_now || $request->tanggal_kunjungan == $date_now) {
            // dd('oke');
            if ($request->alamat_dikunjungi == NULL) {
                $alamat_dikunjungi = $request->alamat_dikunjungi1;
            } else {
                $alamat_dikunjungi = $request->alamat_dikunjungi;
            }
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
                'id_user_hrd'                    => $request->proses_hrd,
                'ttd_proses_hrd'                => $request->ttd_proses_hrd,
                'waktu_ttd_proses_hrd'          => $request->waktu_ttd_proses_hrd,
                'id_user_finance'                => $request->proses_finance,
                'ttd_proses_finance'            => $request->ttd_proses_finance,
                'waktu_ttd_proses_finance'      => $request->waktu_ttd_proses_finance,
                'penugasan'                     => $request->penugasan,
                'wilayah_penugasan'             => $request->wilayah_penugasan,
                'tanggal_kunjungan'             => $request->tanggal_kunjungan,
                'selesai_kunjungan'             => $request->selesai_kunjungan,
                'kegiatan_penugasan'            => $request->kegiatan_penugasan,
                'pic_dikunjungi'                => $request->pic_dikunjungi,
                'alamat_dikunjungi'             => $alamat_dikunjungi,
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
            $request->session()->flash('penugasangagal1');
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
        $diminta = User::where(['id' => $penugasan->id_diminta_oleh])->first();
        $disahkan = User::where(['id' => $penugasan->id_disahkan_oleh])->first();
        $hrd = User::where('id', 'e30d4a42-5562-415c-b1b6-f6b9ccc379a1')->first();
        if ($user->kontrak_kerja == 'sp') {
            // kasir SP
            $finance = User::where('id', '436da676-5782-4f4e-ad50-52b45060430c')->first();
        } else {
            // diana sps
            $finance = User::where('id', 'b709b754-7b00-4118-ab3f-e9b2760b08cf')->first();
        }
        $lokasi_kantor = Lokasi::where('lokasi_kantor', '!=', $user->penempatan_kerja)->get();
        // dd($hrd);
        return view('users.penugasan.edit', [
            'penugasan'     => $penugasan,
            'user'          => $user,
            'diminta'          => $diminta,
            'disahkan'          => $disahkan,
            'hrd'          => $hrd,
            'finance'          => $finance,
            'id_penugasan'  => $id,
            'lokasi_kantor'  => $lokasi_kantor,
        ]);
    }

    public function penugasanUpdate(Request $request, $id)
    {
        if ($request->alamat_dikunjungi == NULL) {
            $alamat_dikunjungi = $request->alamat_dikunjungi1;
        } else {
            $alamat_dikunjungi = $request->alamat_dikunjungi;
        }
        $folderPath     = public_path('signature/');
        $image_parts    = explode(";base64,", $request->signature);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type     = $image_type_aux[1];
        $image_base64   = base64_decode($image_parts[1]);
        $uniqid         = date('y-m-d') . '-' . uniqid();
        $file           = $folderPath . $uniqid . '.' . $image_type;
        file_put_contents($file, $image_base64);
        $data                               = Penugasan::find($id);
        $data->asal_kerja                   = $request->asal_kerja;
        $data->penugasan                    = $request->penugasan;
        $data->wilayah_penugasan                    = $request->wilayah_penugasan;
        $data->tanggal_kunjungan            = $request->tanggal_kunjungan;
        $data->selesai_kunjungan            = $request->selesai_kunjungan;
        $data->kegiatan_penugasan           = $request->kegiatan_penugasan;
        $data->pic_dikunjungi               = $request->pic_dikunjungi;
        $data->alamat_dikunjungi            = $alamat_dikunjungi;
        $data->transportasi                 = $request->transportasi;
        $data->kelas                        = $request->kelas;
        $data->budget_hotel                 = $request->budget_hotel;
        $data->makan                        = $request->makan;
        $data->ttd_id_diajukan_oleh         = $uniqid;
        $data->waktu_ttd_id_diajukan_oleh   = date('Y-m-d h:i:s');
        $data->status_penugasan             = 1;
        $data->save();
        $request->session()->flash('updatesukses', 'Berhasil Membuat Perdin');
        return redirect('/penugasan/dashboard');
    }

    public function penugasanDelete(Request $request, $id)
    {
        $delete = Penugasan::find($id);
        $delete->delete();
        $request->session()->flash('hapussukses', 'Berhasil MembuatHapus Perdin');
        return redirect('/penugasan/dashboard');
    }

    public function approveShow($id)
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
        // $id_penugasan   = $id;
        $diminta = User::where(['id' => $penugasan->id_diminta_oleh])->first();
        $disahkan = User::where(['id' => $penugasan->id_disahkan_oleh])->first();
        $hrd = User::where('id', 'e30d4a42-5562-415c-b1b6-f6b9ccc379a1')->first();
        if ($user->kontrak_kerja == 'sp') {
            // kasir SP
            $finance = User::where('id', '436da676-5782-4f4e-ad50-52b45060430c')->first();
        } else {
            // diana sps
            $finance = User::where('id', 'b709b754-7b00-4118-ab3f-e9b2760b08cf')->first();
        }
        $id_penugasan   = DB::table('penugasans')->where('id', $id)->first();
        return view('users.penugasan.approve', [
            'penugasan' => $penugasan,
            'user'      => $user,
            'id_penugasan'  => $id_penugasan,
            'diminta'  => $diminta,
            'disahkan'  => $disahkan,
            'hrd'  => $hrd,
            'finance'  => $finance,
        ]);
    }

    public function approvePenugasan(Request $request, $id)
    {
        // dd($request->all());
        $folderPath     = public_path('signature/');
        $image_parts    = explode(";base64,", $request->signature);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type     = $image_type_aux[1];
        $image_base64   = base64_decode($image_parts[1]);
        $uniqid         = date('y-m-d') . '-' . uniqid();
        $file           = $folderPath . $uniqid . '.' . $image_type;
        file_put_contents($file, $image_base64);
        $data                               = Penugasan::find($id);
        if ($request->status_penugasan == 2) {
            $data->ttd_id_diminta_oleh          = $uniqid;
            $data->waktu_ttd_id_diminta_oleh    = date('Y-m-d h:i:s');
        } else if ($request->status_penugasan == 3) {
            $data->ttd_id_disahkan_oleh          = $uniqid;
            $data->waktu_ttd_id_disahkan_oleh    = date('Y-m-d h:i:s');
        } else if ($request->status_penugasan == 4) {
            $data->ttd_proses_hrd          = $uniqid;
            $data->waktu_ttd_proses_hrd    = date('Y-m-d h:i:s');
        } else if ($request->status_penugasan == 5) {
            $data->ttd_proses_finance          = $uniqid;
            $data->waktu_ttd_proses_finance    = date('Y-m-d h:i:s');
        }
        $data->status_penugasan             = $request->status_penugasan;
        $data->save();
        $request->session()->flash('approveperdinsukses', 'Berhasil Approve Perdin');
        return redirect('/home');
    }
}
