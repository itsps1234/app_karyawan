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
use PDF;
use App\Models\Jabatan;
use App\Models\Izin;
use App\Models\Departemen;
use App\Models\Divisi;
use App\Models\KategoriIzin;
use App\Models\LevelJabatan;
use DB;

class IzinUserController extends Controller
{
    public function index(Request $request)
    {
        $user_id        = Auth()->user()->id;
        $kontrak = Auth::guard('web')->user()->kontrak_kerja;
        $user = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('level_jabatans', 'jabatans.level_id', '=', 'level_jabatans.id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        if ($kontrak == '') {
            $request->session()->flash('kontrakkerjaNULL');
            return redirect('/home');
        }
        if ($user->level_jabatan == 4) {
            // dd($kontrak);
            $IdLevelAsasan  = LevelJabatan::where('level_jabatan', '3')->first();
            $IdLevelAsasan1  = LevelJabatan::where('level_jabatan', '2')->first();
            $IdLevelAsasan2  = LevelJabatan::where('level_jabatan', '1')->first();
            // $atasan  = User::with([
            //     'Jabatan' => function ($query) {
            //         $query->with(['LevelJabatan']);
            //     },
            // ])->with('Departemen')
            //     ->with('Divisi')
            //     ->whereHas('Jabatan.LevelJabatan', function ($levelQuery) use ($IdLevelAsasan) {
            //         $levelQuery->where('level_id', $IdLevelAsasan->id);
            //     })
            //     ->where('divisi_id', $user->divisi_id)
            //     ->where('is_admin', 'user')
            //     ->first();
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
                ->where('users.divisi_id', $user->divisi_id)
                ->orWhere('users.divisi1_id', $user->divisi_id)
                ->orWhere('users.divisi2_id', $user->divisi_id)
                ->orWhere('users.divisi3_id', $user->divisi_id)
                ->orWhere('users.divisi4_id', $user->divisi_id)
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
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
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
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
                        })->where('users.divisi_id', $user->divisi_id)
                        ->orWhere('users.divisi1_id', $user->divisi1_id)
                        ->orWhere('users.divisi2_id', $user->divisi2_id)
                        ->orWhere('users.divisi3_id', $user->divisi3_id)
                        ->orWhere('users.divisi4_id', $user->divisi4_id)
                        ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                        ->first();
                    if ($atasan2->kontrak_kerja == $kontrak) {
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
                })->where('users.divisi_id', $user->divisi_id)
                ->orWhere('users.divisi1_id', $user->divisi_id)
                ->orWhere('users.divisi2_id', $user->divisi_id)
                ->orWhere('users.divisi3_id', $user->divisi_id)
                ->orWhere('users.divisi4_id', $user->divisi_id)
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
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
                })->where('users.divisi_id', $user->divisi_id)
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
            $getUserAtasan = NULL;
        }
        $jam_kerja = MappingShift::with('Shift')->where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
        // dd($jam_kerja);
        $record_data    = DB::table('izins')->where('user_id', Auth::user()->id)->orderBy('tanggal', 'DESC')->get();
        $kategori_izin = KategoriIzin::orderBy('id', 'ASC')->get();
        return view('users.izin.index', [
            'title'             => 'Tambah Permintaan Cuti Karyawan',
            'data_user'         => $user,
            'data_izin_user'    => Cuti::where('user_id', $user_id)->orderBy('id', 'desc')->get(),
            'getUserAtasan'     => $getUserAtasan,
            'user'              => $user,
            'record_data'       => $record_data,
            'kategori_izin'       => $kategori_izin,
            'jam_kerja'       => $jam_kerja,
        ]);
    }
    public function izinEdit($id)
    {
        $user = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('level_jabatans', 'jabatans.level_id', '=', 'level_jabatans.id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        $get_izin_id = Izin::where('id', $id)->first();
        $kategori_izin = KategoriIzin::orderBy('id', 'ASC')->get();
        return view(
            'users.izin.edit',
            [
                'user' => $user,
                'get_izin' => $get_izin_id,
                'kategori_izin' => $kategori_izin,
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
            if ($request->level_jabatan == '1') {
                $data->status_izin      = 2;
            } else {
                $data->status_izin      = 1;
            }
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
            if ($request->izin == 'Datang Terlambat') {
                $jam_terlambat = $request->terlambat;
                $jam_masuk_kerja = $request->jam_masuk;
                $jam_pulang_cepat = NULL;
                $no_form = Auth::user()->kontrak_kerja . '/SK/FKDT/' . date('Y/m/d') . '/' . $no;
            } else if ($request->izin == 'Pulang Cepat') {
                $jam_pulang_cepat = $request->pulang_cepat;
                $jam_terlambat = NULL;
                $jam_masuk_kerja = NULL;
                $no_form = Auth::user()->kontrak_kerja . '/IP-MK/' . date('Y/m/d') . '/' . $no;
            } else {
                $jam_masuk_kerja = NULL;
                $jam_terlambat = NULL;
                $jam_pulang_cepat = NULL;
            }
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
            $data->tanggal          = $request->tanggal;
            $data->jam              = $request->jam;
            $data->keterangan_izin  = $request->keterangan_izin;
            $data->approve_atasan   = $request->approve_atasan;
            $data->id_approve_atasan = $request->id_user_atasan;
            $data->status_izin      = 0;
            $data->no_form_izin      = $no_form;
            $data->ttd_atasan      = NULL;
            $data->waktu_approve      = NULL;
            $data->save();
        }
        $request->session()->flash('izinsuccess');
        return redirect('/izin/dashboard');
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

    public function izinApproveProses(Request $request)
    {
        if ($request->approve == 'not_approve') {
            $data = Izin::where('id', $request->id_user)->first();
            $data->status_izin  = 'NOT APPROVE';
            $data->catatan      = $request->catatan;
            $data->waktu_approve = date('Y-m-d H:i:s');
            $data->update();
            $alert = $request->session()->flash('approveizin_not_approve');
            return response()->json($alert);
        } else if ($request->approve == 'approve') {
            // dd($request->all());
            $folderPath     = public_path('signature/');
            $image_parts    = explode(";base64,", $request->signature);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type     = $image_type_aux[1];
            $image_base64   = base64_decode($image_parts[1]);
            $uniqid         = date('y-m-d') . '-' . uniqid();
            $file           = $folderPath . $uniqid . '.' . $image_type;
            file_put_contents($file, $image_base64);
            if ($request->signature != null) {
                $data = Izin::find($request->id);
                $data->status_izin  = $request->status_izin;
                $data->catatan      = $request->catatan;
                $data->ttd_atasan      = $uniqid;
                $data->waktu_approve = date('Y-m-d H:i:s');
                $data->save();
                $alert = $request->session()->flash('approveizin_success');
                return response()->json($alert);
            } else {
                Alert::info('info', 'Tanda Tangan Harus Terisi');
                return redirect()->back()->with('info', 'Tanda Tangan Harus Terisi');
            }
        }
    }
    public function delete_izin(Request $request, $id)
    {
        // dd($id);
        $query = Izin::where('id', $id)->delete();
        $request->session()->flash('hapus_izin_sukses');
        return redirect('izin/dashboard');
    }
    public function cetak_form_izin($id)
    {
        $jabatan = Jabatan::join('users', function ($join) {
            $join->on('jabatans.id', '=', 'users.jabatan_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
        })->where('users.id', Auth::user()->id)->get();
        $divisi = Divisi::join('users', function ($join) {
            $join->on('divisis.id', '=', 'users.divisi_id');
            $join->orOn('divisis.id', '=', 'users.divisi1_id');
            $join->orOn('divisis.id', '=', 'users.divisi2_id');
            $join->orOn('divisis.id', '=', 'users.divisi3_id');
            $join->orOn('divisis.id', '=', 'users.divisi4_id');
        })->where('users.id', Auth::user()->id)->get();
        $izin = Izin::where('id', $id)->first();
        $departemen = Departemen::where('id', Auth::user()->dept_id)->first();
        // dd(Izin::with('User')->where('izins.id', $id)->where('izins.status_izin', '2')->first());
        $data = [
            'data_izin' => Izin::with('User')->where('izins.id', $id)->where('izins.status_izin', '2')->first(),
            'jabatan' => $jabatan,
            'divisi' => $divisi,
            'departemen' => $departemen,
        ];
        if ($izin->izin == 'Datang Terlambat') {
            $pdf = PDF::loadView('users/izin/form_izin', $data)->setPaper('A5', 'landscape');;
            return $pdf->stream('FORM_KETERANGAN_DATANG_TERLAMBAT_' . Auth::user()->name . '_' . date('Y-m-d H:i:s') . '.pdf');
        } else if ($izin->izin == 'Tidak Masuk (Mendadak)') {
            $pdf = PDF::loadView('users/izin/form_izin', $data);
            return $pdf->download('FORM_PENGAJUAN_IZIN_' . Auth::user()->name . '_' . date('Y-m-d H:i:s') . '.pdf');
        } else if ($izin->izin == 'Pulang Cepat') {
            $pdf = PDF::loadView('users/izin/form_izin', $data);
            return $pdf->download('FORM_PENGAJUAN_IZIN_' . Auth::user()->name . '_' . date('Y-m-d H:i:s') . '.pdf');
        } else if ($izin->izin == 'Sakit') {
            $pdf = PDF::loadView('users/izin/form_izin', $data);
            return $pdf->download('FORM_PENGAJUAN_IZIN_' . Auth::user()->name . '_' . date('Y-m-d H:i:s') . '.pdf');
        }
    }
}
