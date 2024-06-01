<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AssetController extends Controller
{
    public function index()
    {

        $holding = request()->segment(count(request()->segments()));
        return view('admin.asset.index', [
            // return view('karyawan.index', [
            'title' => 'Karyawan',
            "data_departemen" => Departemen::all(),
            'holding' => $holding,
            'data_user' => User::where('kontrak_kerja', $holding)->get(),
            "data_departemen" => Departemen::all(),
            "data_jabatan" => Jabatan::all(),
            "karyawan_laki" => User::where('gender', 'Laki-Laki')->where('kontrak_kerja', $holding)->count(),
            "karyawan_perempuan" => User::where('gender', 'Perempuan')->where('kontrak_kerja', $holding)->count(),
            "karyawan_office" => User::where('gender', 'Laki-Laki')->where('kontrak_kerja', $holding)->count(),
            "karyawan_shift" => User::where('gender', 'Perempuan')->where('kontrak_kerja', $holding)->count(),
        ]);
    }
    public function datatable(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $table = User::where('kontrak_kerja', $holding)->get();
        if (request()->ajax()) {
            return DataTables::of($table)
                ->addColumn('option', function ($row) use ($holding) {
                    $btn = '<button id="btndetail_karyawan" data-id="' . $row->id . '" data-holding="' . $holding . '" class="btn btn-icon btn-success waves-effect waves-light"><span class="tf-icons mdi mdi-eye-outline"></span></button>';
                    $btn = $btn . '<button id="btn_mapping_shift" data-id="' . $row->id . '" data-holding="' . $holding . '" type="button" class="btn btn-icon btn-info waves-effect waves-light"><span class="tf-icons mdi mdi-clock-outline"></span></button>';
                    $btn = $btn . '<button id="btn_edit_password" data-id="' . $row->id . '" data-holding="' . $holding . '" type="button" class="btn btn-icon btn-secondary waves-effect waves-light"><span class="tf-icons mdi mdi-key-outline"></span></button>';
                    $btn = $btn . '<button type="button" id="btn_delete_karyawan" data-id="' . $row->id . '" data-holding="' . $holding . '" class="btn btn-icon btn-danger waves-effect waves-light"><span class="tf-icons mdi mdi-delete-outline"></span></button>';
                    return $btn;
                })
                ->rawColumns(['option'])
                ->make(true);
        }
    }
}
