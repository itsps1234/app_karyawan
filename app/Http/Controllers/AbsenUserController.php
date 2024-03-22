<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\MappingShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DataTables;

class AbsenUserController extends Controller
{
    public function index()
    {
        return view('users.absen.dashboard', [
            'title' => 'Absen',
            'data_user' => User::all()
        ]);
    }

    // public function recordabsen(Request $request)
    // {
    //     return view('karyawan.index', [
    //         'title' => 'Karyawan',
    //         'data_user' => User::all()
    //     ]);
    //     return view('users.absen.dashboard');
    // }

}
