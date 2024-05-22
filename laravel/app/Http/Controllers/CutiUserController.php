<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MappingShift;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ActivityLog;
use App\Models\Departemen;
use App\Models\Divisi;
use App\Models\Izin;
use App\Models\Jabatan;
use App\Models\KategoriCuti;
use App\Models\LevelJabatan;
use App\Models\ResetCuti;
use PDF;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Carbon\CarbonPeriod;
use DateTime;

class CutiUserController extends Controller
{
    public function index(Request $request)
    {
        $user_id        = Auth()->user()->id;
        $kontrak = Auth::guard('web')->user()->kontrak_kerja;
        if ($kontrak == '') {
            $request->session()->flash('kontrakkerjaNULL');
            return redirect('/home');
        }
        $user = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('level_jabatans', 'jabatans.level_id', '=', 'level_jabatans.id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        // dd($userLevel->level_jabatan);
        // dd($kontrak);
        // jika level staff/admin
        if ($user->level_jabatan == 4) {
            // dd($kontrak);
            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                ->where('id', '!=', Auth::user()->id)
                ->where('is_admin', 'user')
                ->where('divisi_id', Auth::user()->divisi_id)
                ->orWhere('divisi1_id', Auth::user()->divisi_id)
                ->orWhere('divisi2_id', Auth::user()->divisi_id)
                ->orWhere('divisi3_id', Auth::user()->divisi_id)
                ->orWhere('divisi4_id', Auth::user()->divisi_id)
                ->get();
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

            // Atasan Tingkat 1
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
                ->where('is_admin', 'user')
                ->where('users.divisi_id', $user->divisi_id)
                ->orWhere('users.divisi1_id', $user->divisi_id)
                ->orWhere('users.divisi2_id', $user->divisi_id)
                ->orWhere('users.divisi3_id', $user->divisi_id)
                ->orWhere('users.divisi4_id', $user->divisi_id)
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                ->first();
            // Atasan Tingkat 2
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
                ->where('is_admin', 'user')
                ->where('users.divisi_id', $user->divisi_id)
                ->orWhere('users.divisi1_id', $user->divisi_id)
                ->orWhere('users.divisi2_id', $user->divisi_id)
                ->orWhere('users.divisi3_id', $user->divisi_id)
                ->orWhere('users.divisi4_id', $user->divisi_id)
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                ->first();
            // dd($atasan1);
            // jika atasan tingkat 1 
            if ($atasan == '' && $atasan1 == '') {
                // dd('oke1');
                $atasan = DB::table('users')
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
                    ->where('is_admin', 'user')
                    ->where('users.divisi_id', $user->divisi_id)
                    ->orWhere('users.divisi1_id', $user->divisi_id)
                    ->orWhere('users.divisi2_id', $user->divisi_id)
                    ->orWhere('users.divisi3_id', $user->divisi_id)
                    ->orWhere('users.divisi4_id', $user->divisi_id)
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
                $atasan1 = DB::table('users')
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
                    ->where('is_admin', 'user')
                    ->where('users.divisi_id', $user->divisi_id)
                    ->orWhere('users.divisi1_id', $user->divisi_id)
                    ->orWhere('users.divisi2_id', $user->divisi_id)
                    ->orWhere('users.divisi3_id', $user->divisi_id)
                    ->orWhere('users.divisi4_id', $user->divisi_id)
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
                if ($atasan1->kontrak_kerja == $kontrak) {
                    $getUserAtasan  = $atasan;
                    $getUserAtasan2  = $atasan1;
                } else {
                    $getUserAtasan  = NULL;
                    $getUserAtasan2  = NULL;
                }
            } else if ($atasan == '' && $atasan1 != '') {
                // dd('oke2');
                $atasan = DB::table('users')
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
                    ->where('is_admin', 'user')
                    ->where('users.divisi_id', $user->divisi_id)
                    ->orWhere('users.divisi1_id', $user->divisi_id)
                    ->orWhere('users.divisi2_id', $user->divisi_id)
                    ->orWhere('users.divisi3_id', $user->divisi_id)
                    ->orWhere('users.divisi4_id', $user->divisi_id)
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
                $atasan1 = DB::table('users')
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
                    ->where('is_admin', 'user')
                    ->where('users.divisi_id', $user->divisi_id)
                    ->orWhere('users.divisi1_id', $user->divisi_id)
                    ->orWhere('users.divisi2_id', $user->divisi_id)
                    ->orWhere('users.divisi3_id', $user->divisi_id)
                    ->orWhere('users.divisi4_id', $user->divisi_id)
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
                // dd($atasan1);
                if ($atasan->kontrak_kerja == $kontrak && $atasan1->kontrak_kerja == $kontrak) {
                    // dd('ya');
                    $getUserAtasan  = $atasan;
                    $getUserAtasan2  = $atasan1;
                } else {
                    $getUserAtasan  = NULL;
                    $getUserAtasan2  = NULL;
                    // dd($getUserAtasan2);
                }
            } else if ($atasan != '' && $atasan1 == '') {
                // dd('oke2');
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
                    ->where('is_admin', 'user')
                    ->where('users.divisi_id', $user->divisi_id)
                    ->orWhere('users.divisi1_id', $user->divisi_id)
                    ->orWhere('users.divisi2_id', $user->divisi_id)
                    ->orWhere('users.divisi3_id', $user->divisi_id)
                    ->orWhere('users.divisi4_id', $user->divisi_id)
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
                $atasan1 = DB::table('users')
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
                    ->where('is_admin', 'user')
                    ->where('users.divisi_id', $user->divisi_id)
                    ->orWhere('users.divisi1_id', $user->divisi_id)
                    ->orWhere('users.divisi2_id', $user->divisi_id)
                    ->orWhere('users.divisi3_id', $user->divisi_id)
                    ->orWhere('users.divisi4_id', $user->divisi_id)
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
                // dd($atasan);
                if ($atasan1 == '') {
                    $atasan1 = DB::table('users')
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
                        ->where('is_admin', 'user')
                        ->where('users.divisi_id', $user->divisi_id)
                        ->orWhere('users.divisi1_id', $user->divisi_id)
                        ->orWhere('users.divisi2_id', $user->divisi_id)
                        ->orWhere('users.divisi3_id', $user->divisi_id)
                        ->orWhere('users.divisi4_id', $user->divisi_id)
                        ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                        ->first();
                    if ($atasan->kontrak_kerja == $kontrak && $atasan1->kontrak_kerja == $kontrak) {
                        $getUserAtasan  = $atasan;
                        $getUserAtasan2  = $atasan1;
                    } else {
                        $getUserAtasan  = NULL;
                        $getUserAtasan2  = NULL;
                    }
                } else {
                    if ($atasan->kontrak_kerja == $kontrak && $atasan1->kontrak_kerja == $kontrak) {
                        $getUserAtasan  = $atasan;
                        $getUserAtasan2  = $atasan1;
                    } else {
                        $getUserAtasan  = NULL;
                        $getUserAtasan2  = NULL;
                    }
                }
            } else {
                if ($atasan->kontrak_kerja == $kontrak && $atasan1->kontrak_kerja == $kontrak) {
                    $getUserAtasan  = $atasan;
                    $getUserAtasan2  = $atasan1;
                } else {
                    $getUserAtasan  = NULL;
                    $getUserAtasan2  = NULL;
                }
            }
        } else if ($user->level_jabatan == 3) {
            // dd('ya');
            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                ->where('id', '!=', Auth::user()->id)
                ->where('is_admin', 'user')
                ->where('divisi_id', Auth::user()->divisi_id)
                ->orWhere('divisi1_id', Auth::user()->divisi_id)
                ->orWhere('divisi2_id', Auth::user()->divisi_id)
                ->orWhere('divisi3_id', Auth::user()->divisi_id)
                ->orWhere('divisi4_id', Auth::user()->divisi_id)
                ->get();
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
                })
                ->where('is_admin', 'user')
                ->where('users.divisi_id', $user->divisi_id)
                ->orWhere('users.divisi1_id', $user->divisi_id)
                ->orWhere('users.divisi2_id', $user->divisi_id)
                ->orWhere('users.divisi3_id', $user->divisi_id)
                ->orWhere('users.divisi4_id', $user->divisi_id)
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                ->first();
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
                })->where('is_admin', 'user')
                ->where('users.divisi_id', $user->divisi_id)
                ->orWhere('users.divisi1_id', $user->divisi_id)
                ->orWhere('users.divisi2_id', $user->divisi_id)
                ->orWhere('users.divisi3_id', $user->divisi_id)
                ->orWhere('users.divisi4_id', $user->divisi_id)
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                ->first();
            // dd($atasan1);
            if ($atasan == '' && $atasan1 == '') {
                $getUserAtasan  = NULL;
                $getUserAtasan2  = NULL;
            } else if ($atasan == '' && $atasan1 != '') {
                $atasan = DB::table('users')
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
                    })->where('is_admin', 'user')
                    ->where('users.divisi_id', $user->divisi_id)
                    ->orWhere('users.divisi1_id', $user->divisi_id)
                    ->orWhere('users.divisi2_id', $user->divisi_id)
                    ->orWhere('users.divisi3_id', $user->divisi_id)
                    ->orWhere('users.divisi4_id', $user->divisi_id)
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
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
                    })->where('is_admin', 'user')
                    ->where('users.divisi_id', $user->divisi_id)
                    ->orWhere('users.divisi1_id', $user->divisi_id)
                    ->orWhere('users.divisi2_id', $user->divisi_id)
                    ->orWhere('users.divisi3_id', $user->divisi_id)
                    ->orWhere('users.divisi4_id', $user->divisi_id)
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
                if ($atasan->kontrak_kerja == $kontrak && $atasan1->kontrak_kerja == $kontrak) {
                    $getUserAtasan  = $atasan;
                    $getUserAtasan2  = $atasan1;
                } else {
                    $getUserAtasan  = NULL;
                    $getUserAtasan2  = NULL;
                }
            } else if ($atasan != '' && $atasan1 == '') {
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
                    })->where('is_admin', 'user')
                    ->where('users.divisi_id', $user->divisi_id)
                    ->orWhere('users.divisi1_id', $user->divisi_id)
                    ->orWhere('users.divisi2_id', $user->divisi_id)
                    ->orWhere('users.divisi3_id', $user->divisi_id)
                    ->orWhere('users.divisi4_id', $user->divisi_id)
                    ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                    ->first();
                $atasan1 = DB::table('users')
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
                if ($atasan->kontrak_kerja == $kontrak && $atasan1->kontrak_kerja == $kontrak) {
                    $getUserAtasan  = $atasan;
                    $getUserAtasan2  = $atasan1;
                } else {
                    $getUserAtasan  = NULL;
                    $getUserAtasan2  = NULL;
                }
            } else {
                if ($atasan->kontrak_kerja == $kontrak) {
                    $getUserAtasan  = $atasan;
                    $getUserAtasan2  = $atasan1;
                } else {
                    $getUserAtasan  = NULL;
                    $getUserAtasan2  = NULL;
                }
            }
        } else if ($user->level_jabatan == 2) {
            // dd('ok');
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
                })->where('users.is_admin', 'user')
                ->where('users.divisi_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi4_id)
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                ->first();
            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                ->where('is_admin', 'user')
                ->where('users.divisi_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi_id)
                ->where('users.divisi_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi1_id)
                ->where('users.divisi_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi2_id)
                ->where('users.divisi_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi3_id)
                ->where('users.divisi_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi4_id)
                ->where('users.id', '!=', Auth::user()->id)
                ->get();
            // dd($get_user_backup);
            if ($atasan == '' || $atasan == NULL) {
                $getUserAtasan  = NULL;
                $getUserAtasan2  = NULL;
            } else {
                if ($atasan->kontrak_kerja == $kontrak) {
                    $getUserAtasan  = $atasan;
                    $getUserAtasan2  = $atasan;
                } else {
                    $getUserAtasan  = NULL;
                    $getUserAtasan2  = NULL;
                }
            }
        } else if ($user->level_jabatan == 1) {
            $IdLevelAsasan  = LevelJabatan::where('level_jabatan', '0')->first();
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
                })->where('is_admin', 'user')
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                ->first();
            // dd($atasan);
            $atasan1 = DB::table('users')
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
                })->where('is_admin', 'user')
                ->select('users.*', 'jabatans.nama_jabatan', 'level_jabatans.level_jabatan')
                ->first();
            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                ->where('is_admin', 'user')
                ->where('users.divisi_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi_id)
                ->where('users.divisi_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi1_id)
                ->where('users.divisi_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi2_id)
                ->where('users.divisi_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi3_id)
                ->where('users.divisi_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi4_id)
                ->where('users.id', '!=', Auth::user()->id)
                ->get();
            // dd($get_user_backup);
            $getUserAtasan = $atasan;
            $getUserAtasan2 = $atasan1;
        }

        // dd($getUseratasan2);
        // $getUserAtasan  = DB::table('users')->where('jabatan_id', $getAsatan->id)->first();
        $record_data    = Cuti::with('KategoriCuti')->where('user_id', Auth::user()->id)
            // ->select('cutis.*', '_cuti')
            ->orderBy('tanggal', 'DESC')->get();
        // dd($record_data);
        $get_kategori_cuti = KategoriCuti::where('status', 1)->get();
        // dd($get_user_backup);
        return view('users.cuti.index', [
            'title'             => 'Tambah Permintaan Cuti Karyawan',
            'data_user'         => $user,
            'data_cuti_user'    => Cuti::where('user_id', $user_id)->orderBy('id', 'desc')->get(),
            'getUserAtasan'     => $getUserAtasan,
            'getUserAtasan2'     => $getUserAtasan2,
            'get_user_backup'     => $get_user_backup,
            'get_kategori_cuti'     => $get_kategori_cuti,
            'user'              => $user,
            'record_data'       => $record_data
        ]);
    }

    public function get_cuti(Request $request)
    {
        $id_cuti    = $request->id_cuti;
        $cuti      = KategoriCuti::where('status', 1)->where('id', $id_cuti)->first();
        // dd($cuti);
        echo "$cuti->jumlah_cuti";
    }
    public function cutiEdit($id)
    {
        $user = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('level_jabatans', 'jabatans.level_id', '=', 'level_jabatans.id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        $get_cuti_id = Cuti::where('id', $id)->first();
        $get_kategori_cuti = KategoriCuti::all();
        // dd($get_user_backup);
        if ($user->level_jabatan == 4) {
            // dd($kontrak);
            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                ->where('id', '!=', Auth::user()->id)
                ->where('is_admin', 'user')
                ->where('divisi_id', Auth::user()->divisi_id)
                ->orWhere('divisi1_id', Auth::user()->divisi_id)
                ->orWhere('divisi2_id', Auth::user()->divisi_id)
                ->orWhere('divisi3_id', Auth::user()->divisi_id)
                ->orWhere('divisi4_id', Auth::user()->divisi_id)
                ->get();
        } else if ($user->level_jabatan == 3) {
            // dd('ya');
            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                ->where('id', '!=', Auth::user()->id)
                ->where('is_admin', 'user')
                ->where('divisi_id', Auth::user()->divisi_id)
                ->orWhere('divisi1_id', Auth::user()->divisi_id)
                ->orWhere('divisi2_id', Auth::user()->divisi_id)
                ->orWhere('divisi3_id', Auth::user()->divisi_id)
                ->orWhere('divisi4_id', Auth::user()->divisi_id)
                ->get();
        } else if ($user->level_jabatan == 2) {
            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                ->where('is_admin', 'user')
                ->where('users.divisi_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi_id)
                ->where('users.divisi_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi1_id)
                ->where('users.divisi_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi2_id)
                ->where('users.divisi_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi3_id)
                ->where('users.divisi_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi4_id)
                ->where('users.id', '!=', Auth::user()->id)
                ->get();
        } else if ($user->level_jabatan == 1) {
            $get_user_backup = User::where('dept_id', Auth::user()->dept_id)
                ->where('is_admin', 'user')
                ->where('users.divisi_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi_id)
                ->where('users.divisi_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi1_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi1_id)
                ->where('users.divisi_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi2_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi2_id)
                ->where('users.divisi_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi3_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi3_id)
                ->where('users.divisi_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi1_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi2_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi3_id', Auth::user()->divisi4_id)
                ->orWhere('users.divisi4_id', Auth::user()->divisi4_id)
                ->where('users.id', '!=', Auth::user()->id)
                ->get();
        }
        $get_user_atasan = User::where('id', $get_cuti_id->id_user_atasan)->first();
        $get_user_atasan2 = User::where('id', $get_cuti_id->id_user_atasan2)->first();
        return view(
            'users.cuti.edit',
            [
                'user' => $user,
                'get_kategori_cuti' => $get_kategori_cuti,
                'get_user_atasan' => $get_user_atasan,
                'get_user_atasan2' => $get_user_atasan2,
                'get_user_backup' => $get_user_backup,
                'get_cuti' => $get_cuti_id,
            ]
        );
    }
    public function cutiUpdateProses(Request $request)
    {
        // dd($request->all());
        if ($request->cuti == 'Diluar Cuti Tahunan') {
            $jumlah_hari = explode(' ', $request->jumlah_cuti);
            $jumlah_kuota = explode(' ', $request->kuota_cuti);
            $hari = trim($jumlah_hari[0]);
            $hitung_end_date        = now()->parse($request->tanggal_cuti)->addDays($hari);
            $kuota = trim($jumlah_kuota[0]);
            $data_interval  = $hari;
            $startDate = $request->tanggal_cuti;
            $endDate = $hitung_end_date;
            $date1          = new DateTime($request->tanggal_cuti);
            $date2          = new DateTime($hitung_end_date);
            $kategori_cuti = $request->kategori_cuti;

            if ($request->signature !== null) {
                $folderPath     = public_path('signature/');
                $image_parts    = explode(";base64,", $request->signature);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type     = $image_type_aux[1];
                $image_base64   = base64_decode($image_parts[1]);
                $uniqid         = date('y-m-d') . '-' . uniqid();
                $file           = $folderPath . $uniqid . '.' . $image_type;
                file_put_contents($file, $image_base64);
            } else {
                $uniqid = NULL;
            }
            $data = Cuti::where('id', $request->id)->first();
            $data->user_id                  = User::where('id', Auth::user()->id)->value('id');
            $data->kategori_cuti_id         = KategoriCuti::where('id', $kategori_cuti)->value('id');
            $data->nama_cuti                = $request->cuti;
            $data->tanggal                  = date('Y-m-d H:i:s');
            $data->tanggal_mulai            = date('Y-m-d', strtotime($startDate));
            $data->tanggal_selesai          = date('Y-m-d', strtotime($endDate));
            $data->total_cuti               = $data_interval;
            $data->keterangan_cuti          = $request->keterangan_cuti;
            $data->foto_cuti                = NULL;
            $data->ttd_user                 = $uniqid;
            $data->waktu_ttd_user           = date('Y-m-d H:i:s');
            $data->status_cuti              = 1;
            $data->user_id_backup           = $request->user_backup;
            $data->approve_atasan           = User::where('id', $request->id_user_atasan)->value('name');
            $data->approve_atasan2          = User::where('id', $request->id_user_atasan2)->value('name');
            $data->id_user_atasan           = User::where('id', $request->id_user_atasan)->value('id');
            $data->id_user_atasan2          = User::where('id', $request->id_user_atasan2)->value('id');
            $data->ttd_atasan               = NULL;
            $data->ttd_atasan2              = NULL;
            $data->waktu_approve            = NULL;
            $data->waktu_approve2           = NULL;
            $data->catatan                  = NULL;
            $data->catatan2                 = NULL;
            $data->update();

            $request->session()->flash('statuscutieditsuccess', 'Berhasil');
            return redirect('cuti/dashboard');
        } else {
            // cuti tahunan
            $date_range = explode(' - ', $request->tanggal_cuti);
            $startDate = trim($date_range[0]);
            $endDate = trim($date_range[1]);
            $date1          = new DateTime($startDate);
            $date2          = new DateTime($endDate);
            $interval       = $date1->diff($date2);
            $data_interval  = $interval->days + 1;
            $kategori_cuti = NULL;
            $hMin14         = now()->parse($request->startDate)->addDays(14); //2024-04-18
            $format_startDate = date('Y-m-d', strtotime($startDate));
            $format_hmin14 = date('Y-m-d', strtotime($hMin14));
            $kuota_cuti     = DB::table('users')->where('id', $request->id_user)->first();
            // dd($data_interval);
            $hMin14         = date('Y-m-d', strtotime("+14 day", strtotime($request->tgl_pengajuan))); //2024-04-18
            $kuota_cuti     = DB::table('users')->where('id', $request->id_user)->first();
            // dd($file_save);
            if ($request->signature !== null) {
                $folderPath     = public_path('signature/');
                $image_parts    = explode(";base64,", $request->signature);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type     = $image_type_aux[1];
                $image_base64   = base64_decode($image_parts[1]);
                $uniqid         = date('y-m-d') . '-' . uniqid();
                $file           = $folderPath . $uniqid . '.' . $image_type;
                file_put_contents($file, $image_base64);
            } else {
                $uniqid = NULL;
            }
            if ($kuota_cuti->kuota_cuti >= $data_interval) {
                $data = Cuti::where('id', $request->id)->first();
                $data->user_id                  = User::where('id', Auth::user()->id)->value('id');
                $data->kategori_cuti_id         = KategoriCuti::where('id', $kategori_cuti)->value('id');
                $data->nama_cuti                = $request->cuti;
                $data->tanggal                  = date('Y-m-d H:i:s');
                $data->tanggal_mulai            = date('Y-m-d', strtotime($startDate));
                $data->tanggal_selesai          = date('Y-m-d', strtotime($endDate));
                $data->total_cuti               = $data_interval;
                $data->keterangan_cuti          = $request->keterangan_cuti;
                $data->foto_cuti                = NULL;
                $data->ttd_user                 = $uniqid;
                $data->waktu_ttd_user           = date('Y-m-d H:i:s');
                $data->status_cuti              = 1;
                $data->user_id_backup           = $request->user_backup;
                $data->approve_atasan           = User::where('id', $request->id_user_atasan)->value('name');
                $data->approve_atasan2          = User::where('id', $request->id_user_atasan2)->value('name');
                $data->id_user_atasan           = User::where('id', $request->id_user_atasan)->value('id');
                $data->id_user_atasan2          = User::where('id', $request->id_user_atasan2)->value('id');
                $data->ttd_atasan               = NULL;
                $data->ttd_atasan2              = NULL;
                $data->waktu_approve            = NULL;
                $data->waktu_approve2           = NULL;
                $data->catatan                  = NULL;
                $data->catatan2                 = NULL;
                $data->update();

                $request->session()->flash('statuscutieditsuccess', 'Berhasil');
                return redirect('cuti/dashboard');
            } else {
                $request->session()->flash('statuscutiediterror', 'Anda Tidak Memiliki Kuota Cuti');
                return redirect('cuti/dashboard');
            }
        }
    }
    public function cutiApprove($id)
    {
        $user = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('level_jabatans', 'jabatans.level_id', '=', 'level_jabatans.id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->where('users.id', Auth()->user()->id)->first();
        $data   = Cuti::with('KategoriCuti')->where('cutis.id', $id)
            ->join('users', 'users.id', '=', 'cutis.user_id')
            ->select('cutis.*', 'users.name', 'users.fullname', 'users.kuota_cuti')
            ->first();
        // dd($data);
        $get_id_backup = User::where('id', $data->user_id_backup)->first();
        return view('users.cuti.approvecuti', [
            'user'  => $user,
            'get_id_backup'  => $get_id_backup,
            'data'  => $data
        ]);
    }
    public function cutiAbsen(Request $request)
    {
        // dd($request->all());
        if ($request->approve_atasan == '') {
            $request->session()->flash('atasan1NULL');
            return redirect('cuti/dashboard');
        } else if ($request->approve_atasan2 == '') {
            $request->session()->flash('atasan2NULL');
            return redirect('cuti/dashboard');
        } else {
        }
        // No form
        $count_tbl_cuti = Cuti::count();
        $countstr = strlen($count_tbl_cuti + 1);
        if ($countstr == '1') {
            $no = '0000' . $count_tbl_cuti + 1;
        } else if ($countstr == '2') {
            $no = '000' . $count_tbl_cuti + 1;
        } else if ($countstr == '3') {
            $no = '00' . $count_tbl_cuti + 1;
        } else if ($countstr == '4') {
            $no = '0' . $count_tbl_cuti + 1;
        } else {
            $no = $count_tbl_cuti + 1;
        }
        $no_form = Auth::user()->kontrak_kerja . '/FCT/' . date('Y/m/d') . '/' . $no;
        // dd($no_form);
        if ($request->cuti == 'Diluar Cuti Tahunan') {
            $jumlah_hari = explode(' ', $request->jumlah_cuti);
            $jumlah_kuota = explode(' ', $request->kuota_cuti);
            $hari = trim($jumlah_hari[0]);
            $hitung_end_date        = now()->parse($request->tanggal_cuti)->addDays($hari);
            $kuota = trim($jumlah_kuota[0]);
            $data_interval  = $hari;
            $startDate = $request->tanggal_cuti;
            $endDate = $hitung_end_date;
            $date1          = new DateTime($request->tanggal_cuti);
            $date2          = new DateTime($hitung_end_date);
            $kategori_cuti = $request->kategori_cuti;
            Cuti::create([
                'user_id' => User::where('id', Auth::user()->id)->value('id'),
                'kategori_cuti_id' => KategoriCuti::where('id', $kategori_cuti)->value('id'),
                'nama_cuti' => $request->cuti,
                'tanggal' => date('Y-m-d H:i:s'),
                'tanggal_mulai' => date('Y-m-d', strtotime($startDate)),
                'tanggal_selesai' => date('Y-m-d', strtotime($endDate)),
                'total_cuti' => NULL,
                'keterangan_cuti' => $request->keterangan_cuti,
                'foto_cuti' => NULL,
                'status_cuti' => 0,
                'user_id_backup' => $request->user_backup,
                'approve_atasan' => User::where('id', $request->id_user_atasan)->value('name'),
                'approve_atasan2' => User::where('id', $request->id_user_atasan2)->value('name'),
                'id_user_atasan' => User::where('id', $request->id_user_atasan)->value('id'),
                'id_user_atasan2' => User::where('id', $request->id_user_atasan2)->value('id'),
                'ttd_atasan' => NULL,
                'ttd_atasan2' => NULL,
                'waktu_approve' => NULL,
                'waktu_approve2' => NULL,
                'catatan' => NULL,
                'catatan2' => NULL,
                'no_form_cuti' => $no_form,
            ]);
        } else {
            // cuti tahunan
            $date_range = explode(' - ', $request->tanggal_cuti);
            $startDate = trim($date_range[0]);
            $endDate = trim($date_range[1]);
            $date1          = new DateTime($startDate);
            $date2          = new DateTime($endDate);
            $interval       = $date1->diff($date2);
            $data_interval  = $interval->days + 1;
            $kategori_cuti = NULL;
            $hMin14         = now()->parse($request->startDate)->addDays(14); //2024-04-18
            $format_startDate = date('Y-m-d', strtotime($startDate));
            $format_hmin14 = date('Y-m-d', strtotime($hMin14));
            $kuota_cuti     = DB::table('users')->where('id', $request->id_user)->first();
            if ($format_startDate >= $format_hmin14) {
                if ($kuota_cuti->kuota_cuti >= $data_interval) {
                    Cuti::create([
                        'user_id' => User::where('id', Auth::user()->id)->value('id'),
                        'kategori_cuti_id' => KategoriCuti::where('id', $kategori_cuti)->value('id'),
                        'nama_cuti' => $request->cuti,
                        'tanggal' => date('Y-m-d H:i:s'),
                        'tanggal_mulai' => date('Y-m-d', strtotime($startDate)),
                        'tanggal_selesai' => date('Y-m-d', strtotime($endDate)),
                        'total_cuti' => $data_interval,
                        'keterangan_cuti' => $request->keterangan_cuti,
                        'foto_cuti' => NULL,
                        'status_cuti' => 0,
                        'user_id_backup' => $request->user_backup,
                        'approve_atasan' => User::where('id', $request->id_user_atasan)->value('name'),
                        'approve_atasan2' => User::where('id', $request->id_user_atasan2)->value('name'),
                        'id_user_atasan' => User::where('id', $request->id_user_atasan)->value('id'),
                        'id_user_atasan2' => User::where('id', $request->id_user_atasan2)->value('id'),
                        'ttd_atasan' => NULL,
                        'ttd_atasan2' => NULL,
                        'waktu_approve' => NULL,
                        'waktu_approve2' => NULL,
                        'catatan' => NULL,
                        'catatan2' => NULL,
                        'no_form_cuti' => $no_form,
                    ]);

                    $request->session()->flash('addcutisuccess', 'Berhasil');
                    return redirect('cuti/dashboard');
                } else {
                    $request->session()->flash('addcutierror1', 'Anda Tidak Memiliki Kuota Cuti');
                    return redirect('cuti/dashboard');
                }
            } else {
                $request->session()->flash('addcutierror2', 'Pengajuan Harus H-14 untuk cuti');
                return redirect('cuti/dashboard');
            }
        }
        $request->session()->flash('addcutisuccess', 'Berhasil');
        return redirect('cuti/dashboard');
    }
    public function cutiApproveProses(Request $request)
    {
        if ($request->approve == 'not_approve') {
            $data = Cuti::where('id', $request->id)->first();
            $data->status_cuti  = 'NOT APPROVE';
            $data->catatan      = $request->catatan;
            $data->waktu_approve = date('Y-m-d H:i:s');
            $data->update();
            $alert = $request->session()->flash('approvecuti_not_approve');
            return response()->json($alert);
        } else {
            if ($request->signature != null) {
                $folderPath     = public_path('signature/');
                $image_parts    = explode(";base64,", $request->signature);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type     = $image_type_aux[1];
                $image_base64   = base64_decode($image_parts[1]);
                $uniqid         = date('y-m-d') . '-' . uniqid();
                $file           = $folderPath . $uniqid . '.' . $image_type;
                file_put_contents($file, $image_base64);
            } else {
                $uniqid = NULL;
            }
            if ($request->status_cuti == '2') {
                $data = Cuti::where('id', $request->id)->first();
                $data->status_cuti  = 3;
                $data->ttd_atasan2  = $uniqid;
                $data->catatan2      = $request->catatan;
                $data->waktu_approve2 = date('Y-m-d H:i:s');
                $data->update();

                $user_cuti = User::where('id', $data->user_id)->first();
                $user_cuti->kuota_cuti = ($user_cuti->kuota_cuti) - ($data->total_cuti);
                $user_cuti->update();
            } else if ($request->status_cuti == '1') {
                $data = Cuti::where('id', $request->id)->first();
                $data->status_cuti  = 2;
                $data->ttd_atasan  = $uniqid;
                $data->catatan      = $request->catatan;
                $data->waktu_approve = date('Y-m-d H:i:s');
                $data->update();
            }
            $alert = $request->session()->flash('approvecuti_success');
            return response()->json($alert);
        }
    }

    public function delete_cuti(Request $request, $id)
    {
        // dd($id);
        $query = Cuti::where('id', $id)->delete();
        $request->session()->flash('hapus_cuti_sukses');
        return redirect('cuti/dashboard');
    }
    public function cetak_form_cuti($id)
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
        $cuti = Cuti::where('id', $id)->first();
        $departemen = Departemen::where('id', Auth::user()->dept_id)->first();
        $pengganti = User::where('id', $cuti->user_id_backup)->first();
        // dd(Cuti::with('KategoriCuti')->with('User')->where('cutis.id', $id)->where('cutis.status_cuti', '3')->first());
        $data = [
            'title' => 'domPDF in Laravel 10',
            'data_cuti' => Cuti::with('KategoriCuti')->with('User')->where('cutis.id', $id)->where('cutis.status_cuti', '3')->first(),
            'jabatan' => $jabatan,
            'divisi' => $divisi,
            'departemen' => $departemen,
            'pengganti' => $pengganti,
        ];
        $pdf = PDF::loadView('users/cuti/form_cuti', $data);
        return $pdf->download('FORM_PENGAJUAN_CUTI_' . Auth::user()->name . '_' . date('Y-m-d H:i:s') . '.pdf');
    }
}
