<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MappingShift;
use Illuminate\Http\Request;
use App\Models\Cuti;
use App\Models\Lembur;
use App\Models\ResetCuti;
use App\Models\ActivityLog;
use Ramsey\Uuid\Uuid;

class dashboardController extends Controller
{
    public function index()
    {
        // $arr [4,2,1,6]
        // Echo dadine [2,1,-5...
        // $arr = [5, 4, 3, 2, 1];
        // dd(count($arr));

        // foreach ($arr as $a) {
        // $result = $a;
        // dd($result);
        // }
        // return view('admin.layouts.dashboard');
        $holding = request()->segment(count(request()->segments()));
        // $md5_sp = md5('sp');
        // $holding = md5($get_holding);
        // dd(request()->segment(count(request()->segments())));
        date_default_timezone_set('Asia/Jakarta');
        $tgl_skrg = date("Y-m-d");

        $logs = ActivityLog::query();

        $logs = $logs->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard.index', [
            // 'arr' => $arr,
            'title' => 'Dashboard',
            'jumlah_user' => User::count(),
            'jumlah_masuk' => MappingShift::where('tanggal_masuk', $tgl_skrg)->where('status_absen', 'HADIR KERJA')->count(),
            'jumlah_tidak_masuk' => MappingShift::where('tanggal_masuk', $tgl_skrg)->where('status_absen', 'TIDAK HADIR KERJA')->count(),
            'jumlah_libur' => MappingShift::where('tanggal_masuk', $tgl_skrg)->where('status_absen', 'Libur')->count(),
            'jumlah_cuti' => MappingShift::where('tanggal_masuk', $tgl_skrg)->where('status_absen', 'Cuti')->count(),
            'jumlah_izin_telat' => MappingShift::where('tanggal_masuk', $tgl_skrg)->where('status_absen', 'Izin Telat')->count(),
            'jumlah_izin_pulang_cepat' => MappingShift::where('tanggal_masuk', $tgl_skrg)->where('status_absen', 'Izin Pulang Cepat')->count(),
            'jumlah_karyawan_lembur' => Lembur::where('tanggal', $tgl_skrg)->count(),
            'logs' => $logs,
            'holding' => $holding,
        ]);
    }

    public function holding()
    {
        // dd($sp);
        return view('admin.dashboard.holding');
    }
}
