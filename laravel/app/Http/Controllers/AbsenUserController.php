<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\MappingShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AbsenUserController extends Controller
{
    public function index()
    {
        // dd('ok');
        date_default_timezone_set('Asia/Jakarta');
        $user_login = auth()->user()->id;
        $tanggal = "";
        $tglskrg = date('Y-m-d');
        $tglkmrn = date('Y-m-d', strtotime('-1 days'));
        $mapping_shift = MappingShift::where('user_id', $user_login)->where('tanggal', $tglkmrn)->get();
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
        return view('users.absen.index', [
            'title' => 'Absen',
            'shift_karyawan' => MappingShift::where('user_id', $user_login)->where('tanggal', $tanggal)->get()
        ]);
    }

    public function recordabsen(Request $request)
    {
        $thnskrg = date('Y');
        return view('users.absen.data_absensi', [
            'thnskrg' => $thnskrg
        ]);
    }
    public function get_table_absensi(Request $request)
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
                    $data = MappingShift::where('user_id', $user_login)->whereMonth('tanggal', $request->filter_month)->orderBy('tanggal', 'DESC')->get();
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
}
