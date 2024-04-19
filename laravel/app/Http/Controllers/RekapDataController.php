<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Lembur;
use App\Models\User;
use App\Models\MappingShift;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RekapDataController extends Controller
{
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        // $bulan = date('m');
        // $tahun = date('Y');
        // $hari_per_bulan = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
        $tanggal_mulai = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        $title = "Rekap Data Absensi Tanggal " . date('Y-m-01') . " s/d " . date('Y-m-d');

        $user = User::all();

        if ($request["mulai"] && $request["akhir"]) {
            $tanggal_mulai = $request["mulai"];
            $tanggal_akhir = $request["akhir"];
            $title = "Rekap Data Absensi Tanggal " . $tanggal_mulai . " s/d " . $tanggal_akhir;
        }
        
        return view('rekapdata.index', [
            'title' => $title,
            'data_user' => $user, 
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir
        ]);
    }
}
