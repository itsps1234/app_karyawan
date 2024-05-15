<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Lembur;
use App\Models\User;
use App\Models\MappingShift;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class RekapDataController extends Controller
{
    public function index(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        date_default_timezone_set('Asia/Jakarta');

        // $bulan = date('m');
        // $tahun = date('Y');
        // $hari_per_bulan = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
        $tanggal_mulai = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        $title = "Rekap Data Absensi Tanggal " . date('Y-m-01') . " s/d " . date('Y-m-d');

        $user = User::with('Cuti')->with('Izin')->get();
        // dd($user->Cuti->nama_cuti);

        if ($request["mulai"] && $request["akhir"]) {
            $tanggal_mulai = $request["mulai"];
            $tanggal_akhir = $request["akhir"];
            $title = "Rekap Data Absensi Tanggal " . $tanggal_mulai . " s/d " . $tanggal_akhir;
        }

        return view('admin.rekapdata.index', [
            'title' => $title,
            'data_user' => $user,
            'tanggal_mulai' => $tanggal_mulai,
            'holding' => $holding,
            'tanggal_akhir' => $tanggal_akhir
        ]);
    }
    public function datatable(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $table = User::with('Cuti')->with('Izin')->with('Mappingshift')->where('users.kontrak_kerja', $holding)->get();
        if (request()->ajax()) {
            return DataTables::of($table)
                ->addColumn('total_hadir', function ($row) {
                    $jumlah_izin_pulang_cepat = $row->MappingShift->where('status_absen', 'Izin Pulang Cepat')->count();
                    $jumlah_izin_telat = $row->MappingShift->where('status_absen', 'Izin Telat')->count();
                    $total_hadir = $row->MappingShift->where('status_absen', '=', 'Masuk')->count();
                    return $total_hadir + $jumlah_izin_telat + $jumlah_izin_pulang_cepat . " x";
                })
                ->addColumn('izin_terlambat', function ($row) {
                    $izin_terlambat = $row->MappingShift->where('status_absen', 'Izin Telat')->count();
                    return $izin_terlambat  . " x";
                })
                ->addColumn('total_terlambat', function ($row) {
                    $total = $row->MappingShift->sum('telat');
                    $jam = floor($total / (60 * 60));
                    $menit = $total - ($jam * (60 * 60));
                    $menit2 = floor($menit / 60);
                    $detik = $total % 60;

                    if ($jam <= 0 && $menit2 <= 0) {
                        $total_terlambat = '<span class="badge bg-label-success">Tidak Pernah Telat</span>';
                    } else {
                        $total_terlambat = '<span class="badge bg-label-danger">' . $jam . ' Jam ' . $menit2 . ' Menit</span>';
                    }
                    return $total_terlambat;
                })
                ->addColumn('izin_pulang_cepat', function ($row) {
                    $izin_pulang_cepat = $row->MappingShift->where('status_absen', 'Izin Pulang Cepat')->count();
                    return $izin_pulang_cepat  . " x";
                })
                ->addColumn('total_pulang_cepat', function ($row) {
                    $total = $row->MappingShift->sum('pulang_cepat');
                    $jam = floor($total / (60 * 60));
                    $menit = $total - ($jam * (60 * 60));
                    $menit2 = floor($menit / 60);
                    $detik = $total % 60;

                    if ($jam <= 0 && $menit2 <= 0) {
                        $total_pulang_cepat =  '<span class="badge bg-label-success">Tidak Pernah Pulang Cepat</span>';
                    } else {
                        $total_pulang_cepat =   '<span class="badge bg-label-danger">' . $jam . ' Jam ' . $menit2 . ' Menit</span>';
                    }
                    return $total_pulang_cepat;
                })
                ->addColumn('alfa', function ($row) {
                    $alfa = $row->MappingShift->where('status_absen', 'Tidak Masuk')->count() . " x";
                    return $alfa;
                })
                ->addColumn('libur', function ($row) {
                    $libur = $row->MappingShift->where('status_absen', 'Libur')->count() . " x";
                    return $libur;
                })
                ->addColumn('cuti_bersama', function ($row) {
                    $cuti_bersama = $row->Cuti->where('nama_cuti', 'Cuti Bersama')->where('status_cuti', 'Diterima')->count() . " x";
                    return $cuti_bersama;
                })
                ->addColumn('cuti_menikah', function ($row) {
                    $cuti_menikah = $row->Cuti->where('nama_cuti', 'Cuti Menikah')->where('status_cuti', 'Diterima')->count() . " x";
                    return $cuti_menikah;
                })
                ->addColumn('cuti_diluar_tanggungan', function ($row) {
                    $cuti_diluar_tanggungan = $row->Cuti->where('nama_cuti', 'Cuti Diluar Tanggungan')->where('status_cuti', 'Diterima')->count() . " x";
                    return $cuti_diluar_tanggungan;
                })
                ->addColumn('cuti_khusus', function ($row) {
                    $cuti_khusus = $row->Cuti->where('nama_cuti', 'Cuti Khusus')->where('status_cuti', 'Diterima')->count() . " x";
                    return $cuti_khusus;
                })
                ->addColumn('cuti_melahirkan', function ($row) {
                    $cuti_melahirkan = $row->Cuti->where('nama_cuti', 'Cuti Melahirkan')->where('status_cuti', 'Diterima')->count() . " x";
                    return $cuti_melahirkan;
                })
                ->addColumn('cuti_dadakan', function ($row) {
                    $cuti_dadakan = $row->Cuti->where('nama_cuti', 'Cuti Dadakan')->where('status_cuti', 'Diterima')->count() . " x";
                    return $cuti_dadakan;
                })
                ->rawColumns(['total_hadir', 'izin_terlambat', 'total_terlambat', 'izin_pulang_cepat', 'total_pulang_cepat', 'alfa', 'libur', 'cuti_bersama', 'cuti_menikah', 'cuti_diluar_tanggungan', 'cuti_khusus', 'cuti_melahirkan', 'cuti_dadakan'])
                ->make(true);
        }
    }
}
