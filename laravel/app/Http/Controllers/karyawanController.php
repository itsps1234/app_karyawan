<?php

namespace App\Http\Controllers;

use App\Exports\KaryawanExport;
use App\Imports\UsersImport;
use App\Models\Cuti;
use App\Models\Jabatan;
use App\Models\Lembur;
use App\Models\User;
use App\Models\MappingShift;
use App\Models\ResetCuti;
use App\Models\Shift;
use App\Models\Sip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;
use App\Models\Bagian;
use App\Models\Cities;
use App\Models\City;
use App\Models\Departemen;
use App\Models\District;
use App\Models\Divisi;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Laravolt\Indonesia\IndonesiaService;
use App\Models\Provincies;
use App\Models\Regencies;
use App\Models\Village;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\AssignOp\Div;
use Yajra\DataTables\DataTables;

class karyawanController extends Controller
{
    public function index()
    {

        $holding = request()->segment(count(request()->segments()));
        return view('admin.karyawan.index', [
            // return view('karyawan.index', [
            'title' => 'Karyawan',
            "data_departemen" => Departemen::orderBy('nama_departemen', 'ASC')->where('holding', $holding)->get(),
            'holding' => $holding,
            'data_user' => User::where('kontrak_kerja', $holding)->get(),
            "data_jabatan" => Jabatan::orderBy('nama_jabatan', 'ASC')->where('holding', $holding)->get(),
            "data_provinsi" => Provincies::orderBy('name', 'ASC')->get(),
            "data_kabupaten" => Cities::orderBy('name', 'ASC')->get(),
            "data_kecamatan" => District::orderBy('name', 'ASC')->get(),
            "data_desa" => Village::orderBy('name', 'ASC')->get(),
            "data_lokasi" => Lokasi::orderBy('lokasi_kantor', 'ASC')->get(),
            "karyawan_laki" => User::where('gender', 'Laki-Laki')->where('kontrak_kerja', $holding)->count(),
            "karyawan_perempuan" => User::where('gender', 'Perempuan')->where('kontrak_kerja', $holding)->count(),
            "karyawan_office" => User::where('kategori', 'Karyawan Bulanan')->where('kontrak_kerja', $holding)->count(),
            "karyawan_shift" => User::where('kategori', 'Karyawan Harian')->where('kontrak_kerja', $holding)->count(),
        ]);
    }
    public function ImportKaryawan(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        Excel::import(new UsersImport, $request->file_excel);

        return redirect('/karyawan/' . $holding)->with('success', 'Import Karyawan Sukses');
    }
    public function ExportKaryawan(Request $request)
    {
        $date = date('YmdHis');
        $holding = request()->segment(count(request()->segments()));
        return Excel::download(new KaryawanExport($holding), 'Data Karyawan_' . $holding . '_' . $date . '.xlsx');
    }
    public function download_pdf_karyawan(Request $request)
    {
        $cek_holding = request()->segment(count(request()->segments()));
        if ($cek_holding == 'sp') {
            $holding = 'CV. SUMBER PANGAN';
        } else if ($cek_holding == 'sps') {
            $holding = 'PT. SURYA PANGAN SEMESTA';
        } else {
            $holding = 'CV. SURYA INTI PANGAN';
        }
        $date = date('YmdHis');
        $data = [
            'user' => User::leftJoin('departemens as a', 'a.id', 'users.dept_id')
                ->leftJoin('divisis as b', 'b.id', 'users.divisi_id')
                ->leftJoin('bagians as c', 'c.id', 'users.bagian_id')
                ->leftJoin('jabatans as d', 'd.id', 'users.jabatan_id')
                ->leftJoin('divisis as e', 'e.id', 'users.divisi1_id')
                ->leftJoin('bagians as f', 'f.id', 'users.bagian1_id')
                ->leftJoin('jabatans as g', 'g.id', 'users.jabatan1_id')
                ->leftJoin('divisis as h', 'h.id', 'users.divisi2_id')
                ->leftJoin('bagians as i', 'i.id', 'users.bagian2_id')
                ->leftJoin('jabatans as j', 'j.id', 'users.jabatan2_id')
                ->leftJoin('divisis as k', 'k.id', 'users.divisi3_id')
                ->leftJoin('bagians as l', 'l.id', 'users.bagian3_id')
                ->leftJoin('jabatans as m', 'm.id', 'users.jabatan3_id')
                ->leftJoin('divisis as n', 'n.id', 'users.divisi4_id')
                ->leftJoin('bagians as o', 'o.id', 'users.bagian4_id')
                ->leftJoin('jabatans as p', 'p.id', 'users.jabatan4_id')
                ->leftJoin('indonesia_provinces as q', 'q.code', 'users.provinsi')
                ->leftJoin('indonesia_cities as r', 'r.code', 'users.kabupaten')
                ->leftJoin('indonesia_districts as s', 's.code', 'users.kecamatan')
                ->leftJoin('indonesia_villages as t', 't.code', 'users.desa')
                ->where('users.kontrak_kerja', $cek_holding)
                ->where('users.is_admin', 'user')
                ->select('nomor_identitas_karyawan', 'users.name', 'nik', 'npwp', 'fullname', 'motto', 'email', 'telepon', 'username', 'tempat_lahir', 'tgl_lahir', 'gender', 'tgl_join', 'status_nikah', 'q.name as nama_provinsi', 'r.name as nama_kabupaten', 's.name as nama_kecamatan', 't.name as nama_desa', 'rt', 'rw', 'alamat', 'kuota_cuti_tahunan', 'kategori', 'lama_kontrak_kerja', 'tgl_mulai_kontrak', 'tgl_selesai_kontrak', 'kontrak_kerja', 'penempatan_kerja', 'site_job', 'nama_bank', 'nomor_rekening', 'a.nama_departemen', 'b.nama_divisi', 'c.nama_bagian', 'd.nama_jabatan', 'e.nama_divisi as nama_divisi1', 'f.nama_bagian as nama_bagian1', 'g.nama_jabatan as nama_jabatan1', 'h.nama_divisi as nama_divisi2', 'i.nama_bagian as nama_bagian2', 'j.nama_jabatan as nama_jabatan2', 'k.nama_divisi as nama_divisi3', 'l.nama_bagian as nama_bagian3', 'm.nama_jabatan as nama_jabatan3', 'n.nama_divisi as nama_divisi4', 'o.nama_bagian as nama_bagian4', 'p.nama_jabatan as nama_jabatan4')
                ->orderBy('name', 'ASC')
                ->get(),
            'holding' => $holding,
            'cek_holding' => $cek_holding,
        ];
        // dd($data);
        $pdf = PDF::loadView('admin/karyawan/cetak_pdf_karyawan', $data)->setPaper('A4', 'landscape');
        return $pdf->stream('Data Karyawan_' . $holding . '_' . $date . 'pdf');
    }
    public function datatable_bulanan(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $table = User::with('Divisi')->with('Jabatan')->where('kontrak_kerja', $holding)
            ->where('kategori', 'Karyawan Bulanan')
            ->orderBy('id', 'DESC')
            ->get();
        if (request()->ajax()) {
            return DataTables::of($table)
                ->addColumn('nama_divisi', function ($row) use ($holding) {
                    if ($row->divisi_id == '' || $row->divisi_id == NULL) {
                        $divisi = NULL;
                    } else {
                        $divisi = $row->Divisi->nama_divisi;
                    }
                    return $divisi;
                })
                ->addColumn('nama_jabatan', function ($row) use ($holding) {
                    if ($row->jabatan_id == '' || $row->jabatan_id == NULL) {
                        $jabatan = NULL;
                    } else {
                        $jabatan = $row->Jabatan->nama_jabatan;
                    }
                    return $jabatan;
                })
                ->addColumn('option', function ($row) use ($holding) {
                    $btn = '<button id="btndetail_karyawan" data-id="' . $row->id . '" data-holding="' . $holding . '" class="btn btn-icon btn-success waves-effect waves-light"><span class="tf-icons mdi mdi-eye-outline"></span></button>';
                    $btn = $btn . '<button id="btn_mapping_shift" data-id="' . $row->id . '" data-holding="' . $holding . '" type="button" class="btn btn-icon btn-info waves-effect waves-light"><span class="tf-icons mdi mdi-clock-outline"></span></button>';
                    $btn = $btn . '<button id="btn_edit_password" data-id="' . $row->id . '" data-holding="' . $holding . '" type="button" class="btn btn-icon btn-secondary waves-effect waves-light"><span class="tf-icons mdi mdi-key-outline"></span></button>';
                    $btn = $btn . '<button type="button" id="btn_delete_karyawan" data-id="' . $row->id . '" data-holding="' . $holding . '" class="btn btn-icon btn-danger waves-effect waves-light"><span class="tf-icons mdi mdi-delete-outline"></span></button>';
                    return $btn;
                })
                ->rawColumns(['nama_jabatan', 'nama_divisi', 'option'])
                ->make(true);
        }
    }
    public function datatable_harian(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $table = User::where('kontrak_kerja', $holding)->where('kategori', 'Karyawan Harian')->orderBy('id', 'DESC')->get();
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
    public function get_kabupaten($id)
    {
        // dd($id);
        $get_kabupaten = Cities::where('province_code', $id)->orderBy('name', 'ASC')->get();
        // return $get_kabupaten;
        echo "<option value=''>Pilih Kabupaten...</option>";
        foreach ($get_kabupaten as $kabupaten) {
            echo "<option value='$kabupaten->code'>$kabupaten->name</option>";
        }
    }
    public function get_kecamatan($id)
    {
        // dd($id);
        $get_desa = District::where('city_code', $id)->orderBy('name', 'ASC')->get();
        // return $get_desa;
        echo "<option value=''>Pilih Kecamatan...</option>";
        foreach ($get_desa as $desa) {
            echo "<option value='$desa->code'>$desa->name</option>";
        }
    }
    public function get_desa($id)
    {
        // dd($id);
        $get_kecamatan = Village::where('district_code', $id)->orderBy('name', 'ASC')->get();
        // return $get_kecamatan;
        echo "<option value=''>Pilih Desa...</option>";
        foreach ($get_kecamatan as $kecamatan) {
            echo "<option value='$kecamatan->code'>$kecamatan->name</option>";
        }
    }
    public function get_atasan(Request $request)
    {
        if ($request->holding == 'sp') {
            $kontrak = 'SP';
        } else if ($request->holding == 'sps') {
            $kontrak = 'SPS';
        } else {
            $kontrak = 'SIP';
        }
        // dd($holding);
        $get_user = User::where('id', $request->id_karyawan)->first();
        $get_level = Jabatan::Join('level_jabatans', 'level_jabatans.id', 'jabatans.level_id')->where('jabatans.id', $request->id)->first();
        // dd($get_level->level_jabatan);
        if ($get_level->level_jabatan <= 4) {
            $get_atasan = User::Join('jabatans', 'jabatans.id', 'users.jabatan_id')
                ->Join('divisis', 'divisis.id', 'jabatans.divisi_id')
                ->Join('bagians', 'bagians.id', 'jabatans.bagian_id')
                ->Join('level_jabatans', 'level_jabatans.id', 'jabatans.level_id')
                // ->where('users.penempatan_kerja', $get_user->penempatan_kerja)
                ->where('users.dept_id', $get_user->dept_id)
                ->where('level_jabatans.level_jabatan', '<', $get_level->level_jabatan)
                ->select('users.*', 'jabatans.nama_jabatan', 'bagians.nama_bagian')
                ->orderBy('users.name', 'ASC')
                ->get();
        } else {
            $get_atasan = User::Join('jabatans', 'jabatans.id', 'users.jabatan_id')
                ->Join('divisis', 'divisis.id', 'jabatans.divisi_id')
                ->Join('level_jabatans', 'level_jabatans.id', 'jabatans.level_id')
                ->Join('bagians', 'bagians.id', 'jabatans.bagian_id')
                // ->where('users.penempatan_kerja', $get_user->penempatan_kerja)
                // ->where('divisis.id', $request->id_divisi)
                ->where('level_jabatans.level_jabatan', '<', $get_level->level_jabatan)
                ->select('users.*', 'jabatans.nama_jabatan', 'bagians.nama_bagian')
                ->orderBy('users.name', 'ASC')
                ->get();
        }
        echo "<option value=''>Pilih Atasan...</option>";
        foreach ($get_atasan as $atasan) {
            echo "<option value='$atasan->id'>$atasan->name ($atasan->nama_jabatan | $atasan->nama_bagian)</option>";
        }
    }
    public function get_atasan2(Request $request)
    {
        // dd($request->all());
        if ($request->holding == 'sp') {
            $kontrak = 'SP';
        } else if ($request->holding == 'sps') {
            $kontrak = 'SPS';
        } else {
            $kontrak = 'SIP';
        }
        $get_user = User::where('id', $request->id_karyawan)->first();
        $get_level = Jabatan::Join('level_jabatans', 'level_jabatans.id', 'jabatans.level_id')->where('jabatans.id', $request->id)->first();
        // dd($get_level);
        if ($get_level == NULL || $get_level == '') {
            $get_atasan = User::Join('jabatans', 'jabatans.id', 'users.jabatan_id')
                ->Join('divisis', 'divisis.id', 'jabatans.divisi_id')
                ->Join('bagians', 'bagians.id', 'jabatans.bagian_id')
                ->Join('level_jabatans', 'level_jabatans.id', 'jabatans.level_id')
                ->where('users.penempatan_kerja', $get_user->penempatan_kerja)
                ->where('users.dept_id', $get_user->dept_id)
                ->where('level_jabatans.level_jabatan', '<', 2)
                ->select('users.*', 'jabatans.nama_jabatan', 'bagians.nama_bagian')
                ->get();
        } else {
            if ($get_level->level_jabatan <= 4) {
                $get_atasan = User::Join('jabatans', 'jabatans.id', 'users.jabatan_id')
                    ->Join('divisis', 'divisis.id', 'jabatans.divisi_id')
                    ->Join('bagians', 'bagians.id', 'jabatans.bagian_id')
                    ->where('users.penempatan_kerja', $get_user->penempatan_kerja)
                    ->where('users.dept_id', $get_user->dept_id)
                    ->Join('level_jabatans', 'level_jabatans.id', 'jabatans.level_id')
                    ->where('level_jabatans.level_jabatan', '<', $get_level->level_jabatan)
                    ->select('users.*', 'jabatans.nama_jabatan', 'bagians.nama_bagian')
                    ->get();
            } else {
                $get_atasan = User::Join('jabatans', 'jabatans.id', 'users.jabatan_id')
                    ->Join('divisis', 'divisis.id', 'jabatans.divisi_id')
                    ->Join('level_jabatans', 'level_jabatans.id', 'jabatans.level_id')
                    ->Join('bagians', 'bagians.id', 'jabatans.bagian_id')
                    ->where('users.penempatan_kerja', $get_user->penempatan_kerja)
                    ->where('users.dept_id', $get_user->dept_id)
                    // ->where('divisis.id', $request->id_divisi)
                    ->where('level_jabatans.level_jabatan', '<', $get_level->level_jabatan)
                    ->select('users.*', 'jabatans.nama_jabatan', 'bagians.nama_bagian')
                    ->get();
            }
        }
        echo "<option value=''>Pilih Atasan...</option>";
        foreach ($get_atasan as $atasan) {
            echo "<option value='$atasan->id'>$atasan->name ($atasan->nama_jabatan | $atasan->nama_bagian)</option>";
        }
    }
    public function tambahKaryawan()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('karyawan.tambah', [
            "title" => 'Tambah Karyawan',
            'holding' => $holding,
            "data_departemen" => Departemen::orderBy('nama_departemen', 'ASC')->get(),
            "data_jabatan" => Jabatan::orderBy('nama_jabatan', 'ASC')->get(),
            "data_provinsi" => Provincies::orderBy('name', 'ASC')->get(),
            "data_kabupaten" => Cities::orderBy('name', 'ASC')->get(),
            "data_kecamatan" => District::orderBy('name', 'ASC')->get(),
            "data_desa" => Village::orderBy('name', 'ASC')->get(),
            "data_lokasi" => Lokasi::orderBy('lokasi_kantor', 'ASC')->get(),
        ]);
    }

    public function tambahKaryawanProses(Request $request)
    {
        // dd($request->all());
        if ($request["cuti_dadakan"] == null) {
            $request["cuti_dadakan"] = "0";
        } else {
            $request["cuti_dadakan"];
        }

        if ($request["cuti_bersama"] == null) {
            $request["cuti_bersama"] = "0";
        } else {
            $request["cuti_bersama"];
        }

        if ($request["cuti_menikah"] == null) {
            $request["cuti_menikah"] = "0";
        } else {
            $request["cuti_menikah"];
        }

        if ($request["cuti_diluar_tanggungan"] == null) {
            $request["cuti_diluar_tanggungan"] = "0";
        } else {
            $request["cuti_diluar_tanggungan"];
        }

        if ($request["cuti_khusus"] == null) {
            $request["cuti_khusus"] = "0";
        } else {
            $request["cuti_khusus"];
        }

        if ($request["cuti_melahirkan"] == null) {
            $request["cuti_melahirkan"] = "0";
        } else {
            $request["cuti_melahirkan"];
        }

        if ($request["izin_telat"] == null) {
            $request["izin_telat"] = "0";
        } else {
            $request["izin_telat"];
        }

        if ($request["izin_pulang_cepat"] == null) {
            $request["izin_pulang_cepat"] = "0";
        } else {
            $request["izin_pulang_cepat"];
        }
        if ($request["kuota_cuti"] == null) {
            $request["kuota_cuti"] = "0";
        } else {
            $request["kuota_cuti"];
        }
        if ($request['foto_karyawan']) {
            // dd('ok');
            $extension     = $request->file('foto_karyawan')->extension();
            // dd($extension);
            $img_name         = date('y-m-d') . '-' . Uuid::uuid4() . '.' . $extension;
            $path           = Storage::putFileAs('public/foto_karyawan/', $request->file('foto_karyawan'), $img_name);
        } else {
            $img_name = NULL;
        }
        if ($request->kategori == 'Karyawan Harian') {
            $rules = [
                'name' => 'required|max:255',
                'nik' => 'required|max:255|unique:users',
                'npwp' => 'max:255|unique:users',
                'fullname' => 'required|max:255',
                'motto' => 'max:255',
                'email' => 'max:255|unique:users',
                'telepon' => 'max:12|min:11',
                'username' => 'required|max:255|unique:users',
                'password' => 'required|max:255',
                'tempat_lahir' => 'required|max:255',
                'tgl_lahir' => 'required|max:255',
                'gender' => 'required',
                'kategori' => 'required',
                'tgl_join' => 'required|max:255',
                'status_nikah' => 'required',
                'nama_bank' => 'required',
                'nomor_rekening' => 'required',
                'is_admin' => 'required',
                'alamat' => 'required|max:255',
                'kuota_cuti' => 'required|max:11',
                'penempatan_kerja' => 'required|max:255',
                'provinsi' => 'required',
                'kabupaten' => 'required',
                'kecamatan' => 'required',
                'desa' => 'required',
                'rt' => 'required|max:255',
                'rw' => 'required|max:255',
            ];
            $customMessages = [
                'required' => ':attribute tidak boleh kosong.',
                'unique' => ':attribute tidak boleh sama',
                // 'email' => ':attribute format email salah',
                'min' => ':attribute Kurang'
            ];
            // dd();
            $validatedData = $request->validate($rules, $customMessages);
            $site_job = NULL;
            $lama_kontrak_kerja = NULL;
            $tgl_mulai_kontrak = NULL;
            $tgl_selesai_kontrak = NULL;
            $departemen     = NULL;
            $bagian         = NULL;
            $divisi         = NULL;
            $jabatan        = NULL;
            $bagian1        = NULL;
            $divisi1        = NULL;
            $jabatan1       = NULL;
            $bagian2        = NULL;
            $divisi2        = NULL;
            $jabatan2       = NULL;
            $bagian3        = NULL;
            $divisi3        = NULL;
            $jabatan3       = NULL;
            $divisi4        = NULL;
            $bagian4        = NULL;
            $jabatan4       = NULL;
        } else if ($request->kategori == 'Karyawan Bulanan') {
            if ($request['lama_kontrak_kerja'] == 'tetap') {
                $rules = [
                    'name' => 'required|max:255',
                    'nik' => 'required|max:255',
                    'npwp' => 'required|max:255',
                    'fullname' => 'required|max:255',
                    'email' => 'max:255',
                    'telepon' => 'max:12| min:11',
                    // 'email' => 'required|max:255',
                    'telepon' => 'max:12|min:11',
                    'username' => 'required|max:255',
                    'password' => 'required|max:255',
                    'tempat_lahir' => 'required|max:255',
                    'tgl_lahir' => 'required|max:255',
                    'gender' => 'required',
                    'tgl_join' => 'required|max:255',
                    'status_nikah' => 'required',
                    'nama_bank' => 'required',
                    'nomor_rekening' => 'required',
                    'alamat' => 'required|max:255',
                    'kuota_cuti' => 'required|max:11',
                    'penempatan_kerja' => 'required|max:255',
                    'departemen_id' => 'required',
                    'divisi_id' => 'required',
                    'bagian_id' => 'required',
                    'jabatan_id' => 'required',
                    'provinsi' => 'required',
                    'kabupaten' => 'required',
                    'kecamatan' => 'required',
                    'lama_kontrak_kerja' => 'required',
                    'kategori' => 'required',
                    'site_job' => 'required',
                    'desa' => 'required',
                    'rt' => 'required|max:255',
                    'rw' => 'required|max:255',
                ];
            } else {
                $rules = [
                    'name' => 'required|max:255',
                    'nik' => 'required|max:255|unique:users',
                    'npwp' => 'max:255|unique:users',
                    'fullname' => 'required|max:255',
                    'motto' => 'max:255',
                    'email' => 'max:255|unique:users',
                    'telepon' => 'max:12|min:11',
                    'username' => 'required|max:255|unique:users',
                    'password' => 'required|max:255',
                    'tempat_lahir' => 'required|max:255',
                    'tgl_lahir' => 'required|max:255',
                    'gender' => 'required',
                    'tgl_join' => 'required|max:255',
                    'status_nikah' => 'required',
                    'kategori' => 'required',
                    'nama_bank' => 'required',
                    'is_admin' => 'required',
                    'nomor_rekening' => 'required',
                    'alamat' => 'required|max:255',
                    'kuota_cuti' => 'required|max:11',
                    'kontrak_kerja' => 'required|max:255',
                    'penempatan_kerja' => 'required|max:255',
                    'lama_kontrak_kerja' => 'required|max:255',
                    'tgl_mulai_kontrak' => 'max:25',
                    'tgl_selesai_kontrak' => 'max:25',
                    'site_job' => 'required',
                    'provinsi' => 'required',
                    'kabupaten' => 'required',
                    'kecamatan' => 'required',
                    'desa' => 'required',
                    'rt' => 'required|max:255',
                    'rw' => 'required|max:255',
                ];
            }

            $customMessages = [
                'required' => ':attribute tidak boleh kosong.',
                'unique' => ':attribute tidak boleh sama',
                // 'email' => ':attribute format email salah',
                'min' => ':attribute Kurang Dari 12 Digits',
                'min' => ':attribute Max 12 Digits'
            ];
            $validatedData = $request->validate($rules, $customMessages);
            $site_job = $validatedData['site_job'];
            $lama_kontrak_kerja = $validatedData['lama_kontrak_kerja'];
            $tgl_mulai_kontrak = $validatedData['tgl_mulai_kontrak'];
            $tgl_selesai_kontrak = $validatedData['tgl_selesai_kontrak'];
            // dd($request["addmore"]['4']["jabatan_id"]);
            $get_divisi_id = $request["divisi_id"];
            if ($get_divisi_id == '') {
                $divisi_id = NULL;
                $bagian_id = NULL;
                $jabatan_id = NULL;
            } else {
                $get_jabatan_id = $request["jabatan_id"];
                $divisi_id = Divisi::where('id', $get_divisi_id)->value('id');
                $bagian_id = Bagian::where('id', $request["bagian_id"])->value('id');
                $jabatan_id = Jabatan::where('id', $get_jabatan_id)->value('id');
            }
            $get_divisi1_id = $request["divisi1_id"];
            if ($get_divisi1_id == '') {
                $divisi1_id = NULL;
                $bagian1_id = NULL;
                $jabatan1_id = NULL;
            } else {
                $get_jabatan1_id = $request["jabatan1_id"];
                $divisi1_id = Divisi::where('id', $get_divisi1_id)->value('id');
                $bagian1_id = Bagian::where('id', $request["bagian1_id"])->value('id');
                $jabatan1_id = Jabatan::where('id', $get_jabatan1_id)->value('id');
            }
            $get_divisi2_id = $request["divisi2_id"];
            if ($get_divisi2_id == '') {
                $divisi2_id = NULL;
                $bagian2_id = NULL;
                $jabatan2_id = NULL;
            } else {
                $get_jabatan2_id = $request["jabatan2_id"];
                $divisi2_id = Divisi::where('id', $get_divisi2_id)->value('id');
                $bagian2_id = Bagian::where('id', $request["bagian2_id"])->value('id');
                $jabatan2_id = Jabatan::where('id', $get_jabatan2_id)->value('id');
            }
            $get_divisi3_id = $request["divisi3_id"];
            if ($get_divisi3_id == '') {
                $divisi3_id = NULL;
                $bagian3_id = NULL;
                $jabatan3_id = NULL;
            } else {
                $get_jabatan3_id = $request["jabatan3_id"];
                $divisi3_id = Divisi::where('id', $get_divisi3_id)->value('id');
                $bagian3_id = Bagian::where('id', $request["bagian3_id"])->value('id');
                $jabatan3_id = Jabatan::where('id', $get_jabatan3_id)->value('id');
            }
            $get_divisi4_id = $request["divisi4_id"];
            if ($get_divisi4_id == '') {
                $divisi4_id = NULL;
                $bagian4_id = NULL;
                $jabatan4_id = NULL;
            } else {
                $get_jabatan4_id = $request["jabatan4_id"];
                $divisi4_id = Divisi::where('id', $get_divisi4_id)->value('id');
                $bagian4_id = Bagian::where('id', $request["bagian4_id"])->value('id');
                $jabatan4_id = Jabatan::where('id', $get_jabatan4_id)->value('id');
            }

            $departemen = Departemen::where('id', $request["departemen_id"])->value('id');
            $divisi = Divisi::where('id', $divisi_id)->value('id');
            $bagian = Bagian::where('id', $bagian_id)->value('id');
            $jabatan = Jabatan::where('id', $jabatan_id)->value('id');
            $divisi1 = Divisi::where('id', $divisi1_id)->value('id');
            $bagian1 = Bagian::where('id', $bagian1_id)->value('id');
            $jabatan1 = Jabatan::where('id', $jabatan1_id)->value('id');
            $divisi2 = Divisi::where('id', $divisi2_id)->value('id');
            $bagian2 = Bagian::where('id', $bagian2_id)->value('id');
            $jabatan2 = Jabatan::where('id', $jabatan2_id)->value('id');
            $bagian3 = Divisi::where('id', $bagian3_id)->value('id');
            $divisi3 = Divisi::where('id', $divisi3_id)->value('id');
            $jabatan3 = Jabatan::where('id', $jabatan3_id)->value('id');
            $divisi4 = Divisi::where('id', $divisi4_id)->value('id');
            $bagian4 = Jabatan::where('id', $bagian4_id)->value('id');
            $jabatan4 = Jabatan::where('id', $jabatan4_id)->value('id');
        } else {
            $rules = [
                'name' => 'required|max:255',
                'nik' => 'required|max:255|unique:users',
                'npwp' => 'max:255|unique:users',
                'fullname' => 'required|max:255',
                'motto' => 'max:255',
                'email' => 'max:255|unique:users',
                'telepon' => 'required|max:255',
                'username' => 'required|max:255|unique:users',
                'password' => 'required|max:255',
                'tempat_lahir' => 'required|max:255',
                'tgl_lahir' => 'required|max:255',
                'gender' => 'required',
                'kategori' => 'required',
                'tgl_join' => 'required|max:255',
                'status_nikah' => 'required',
                'nama_bank' => 'required',
                'nomor_rekening' => 'required',
                'is_admin' => 'required',
                'alamat' => 'required|max:255',
                'kuota_cuti' => 'required|max:11',
                'penempatan_kerja' => 'required|max:255',
                'provinsi' => 'required',
                'kabupaten' => 'required',
                'kecamatan' => 'required',
                'desa' => 'required',
                'rt' => 'required|max:255',
                'rw' => 'required|max:255',
            ];
            $customMessages = [
                'required' => ':attribute tidak boleh kosong.',
                'unique' => ':attribute tidak boleh sama',
                // 'email' => ':attribute format email salah',
                'min' => ':attribute Kurang'
            ];
            $validatedData = $request->validate($rules, $customMessages);
        }
        $holding = request()->segment(count(request()->segments()));
        if ($holding == 'sp') {
            $id_holding = '100';
            $kontrak_kerja = 'SP';
        } else if ($holding == 'sps') {
            $id_holding = '200';
            $kontrak_kerja = 'SPS';
        } else if ($holding == 'sip') {
            $id_holding = '300';
            $kontrak_kerja = 'SIP';
        }
        $no_karyawan = $id_holding . date('ym', strtotime($validatedData['tgl_join'])) . date('dmy', strtotime($validatedData['tgl_lahir']));
        // dd($no_karyawan);
        $insert = User::create(
            [
                'nomor_identitas_karyawan' => $no_karyawan,
                'name' => $validatedData['name'],
                'nik' => $validatedData['nik'],
                'npwp' => $validatedData['npwp'],
                'fullname' => $validatedData['fullname'],
                'motto' => $validatedData['motto'],
                'foto_karyawan' => $img_name,
                'email' => $validatedData['email'],
                'telepon' => $validatedData['telepon'],
                'username' => $validatedData['username'],
                'password' => Hash::make($validatedData['password']),
                'tempat_lahir' => $validatedData['tempat_lahir'],
                'tgl_lahir' => $validatedData['tgl_lahir'],
                'gender' => $validatedData['gender'],
                'tgl_join' => $validatedData['tgl_join'],
                'status_nikah' => $validatedData['status_nikah'],
                'nama_bank' => $validatedData['nama_bank'],
                'nomor_rekening' => $validatedData['nomor_rekening'],
                'kuota_cuti_tahunan' => $validatedData['kuota_cuti'],
                'is_admin' => $request['is_admin'],
                'kategori' => $validatedData['kategori'],
                'kontrak_kerja' => $kontrak_kerja,
                'lama_kontrak_kerja' => $lama_kontrak_kerja,
                'tgl_mulai_kontrak' => $tgl_mulai_kontrak,
                'tgl_selesai_kontrak' => $tgl_selesai_kontrak,
                'penempatan_kerja' => $validatedData['penempatan_kerja'],
                'site_job' => $site_job,
                'provinsi' => Provincies::where('code', $validatedData['provinsi'])->value('code'),
                'kabupaten' => Cities::where('code', $validatedData['kabupaten'])->value('code'),
                'kecamatan' => District::where('code', $validatedData['kecamatan'])->value('code'),
                'desa' => Village::where('code', $validatedData['desa'])->value('code'),
                'rt' => $validatedData['rt'],
                'rw' => $validatedData['rw'],
                'alamat' => $validatedData['alamat'],
                'detail_alamat' => Provincies::where('code', $validatedData['provinsi'])->value('name') . ' , ' . Cities::where('code', $validatedData['kabupaten'])->value('name') . ' , ' . District::where('code', $validatedData['kecamatan'])->value('name') . ' , ' . Village::where('code', $validatedData['desa'])->value('name') . ' , RT. ' . $validatedData['rt'] . ' , RW. ' . $validatedData['rw'] . ' , ' . $validatedData['alamat'],
                'dept_id' => $departemen,
                'divisi_id' => $divisi,
                'bagian_id' => $bagian,
                'jabatan_id' => $jabatan,
                'divisi1_id' => $divisi1,
                'bagian1_id' => $bagian1,
                'jabatan1_id' => $jabatan1,
                'divisi2_id' => $divisi2,
                'bagian2_id' => $bagian2,
                'jabatan2_id' => $jabatan2,
                'divisi3_id' => $divisi3,
                'bagian3_id' => $bagian3,
                'jabatan3_id' => $jabatan3,
                'divisi4_id' => $divisi4,
                'bagian4_id' => $bagian4,
                'jabatan4_id' => $jabatan4,
            ]
        );
        // 

        // Merekam aktivitas pengguna
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'create',
            'description' => 'Menambahkan data karyawan baru ' . $request->name,
        ]);
        return redirect('/karyawan/' . $holding)->with('success', 'Data Berhasil di Tambahkan');
    }

    public function detail($id)
    {
        $holding = request()->segment(count(request()->segments()));
        return view('admin.karyawan.detail_karyawan', [
            // return view('karyawan.editkaryawan', [
            'title' => 'Detail Karyawan',
            'holding' => $holding,
            'karyawan' => User::find($id),
            'data_departemen' => Departemen::orderBy('nama_departemen', 'ASC')->where('holding', $holding)->get(),
            "data_lokasi" => Lokasi::orderBy('lokasi_kantor', 'ASC')->get(),
            "data_provinsi" => Provincies::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function editKaryawanProses(Request $request, $id)
    {
        // dd($id);
        // dd($request->all());
        if ($request["cuti_dadakan"] == null) {
            $request["cuti_dadakan"] = "0";
        } else {
            $request["cuti_dadakan"];
        }

        if ($request["cuti_bersama"] == null) {
            $request["cuti_bersama"] = "0";
        } else {
            $request["cuti_bersama"];
        }

        if ($request["cuti_menikah"] == null) {
            $request["cuti_menikah"] = "0";
        } else {
            $request["cuti_menikah"];
        }

        if ($request["cuti_diluar_tanggungan"] == null) {
            $request["cuti_diluar_tanggungan"] = "0";
        } else {
            $request["cuti_diluar_tanggungan"];
        }

        if ($request["cuti_khusus"] == null) {
            $request["cuti_khusus"] = "0";
        } else {
            $request["cuti_khusus"];
        }

        if ($request["cuti_melahirkan"] == null) {
            $request["cuti_melahirkan"] = "0";
        } else {
            $request["cuti_melahirkan"];
        }

        if ($request["izin_telat"] == null) {
            $request["izin_telat"] = "0";
        } else {
            $request["izin_telat"];
        }

        if ($request["izin_pulang_cepat"] == null) {
            $request["izin_pulang_cepat"] = "0";
        } else {
            $request["izin_pulang_cepat"];
        }
        if ($request['kategori'] == 'Karyawan Harian') {
            $rules = [
                'name' => 'required|max:255',
                'nik' => 'required|max:255',
                'npwp' => 'max:255',
                'fullname' => 'required|max:255',
                'email' => 'max:255',
                'telepon' => 'required|min:11|max:255',
                'username' => 'required|max:255',
                'password' => 'required|max:255',
                'tempat_lahir' => 'required|max:255',
                'tgl_lahir' => 'required|max:255',
                'gender' => 'required',
                'tgl_join' => 'required|max:255',
                'status_nikah' => 'required',
                'nama_bank' => 'required',
                'nomor_rekening' => 'required',
                'alamat' => 'required|max:255',
                'kuota_cuti' => 'max:11',
                'penempatan_kerja' => 'required|max:255',
                'provinsi' => 'required',
                'kabupaten' => 'required',
                'kecamatan' => 'required',
                'kategori' => 'required',
                'desa' => 'required',
                'rt' => 'required|max:255',
                'rw' => 'required|max:255',
            ];
        } else if ($request['kategori'] == 'Karyawan Bulanan') {
            if ($request['lama_kontrak_kerja'] == 'tetap') {
                $rules = [
                    'name' => 'required|max:255',
                    'nik' => 'required|max:255',
                    'npwp' => 'max:255',
                    'fullname' => 'required|max:255',
                    'email' => 'max:255',
                    'telepon' => 'min:11|max:13',
                    // 'email' => 'required|max:255',
                    // 'telepon' => 'required|max:13|min:11',
                    'username' => 'required|max:255',
                    'password' => 'required|max:255',
                    'tempat_lahir' => 'required|max:255',
                    'tgl_lahir' => 'required|max:255',
                    'gender' => 'required',
                    'tgl_join' => 'required|max:255',
                    'status_nikah' => 'required',
                    'nama_bank' => 'required',
                    'nomor_rekening' => 'required',
                    'alamat' => 'required|max:255',
                    'kuota_cuti' => 'required|max:11',
                    'kontrak_kerja' => 'required|max:255',
                    'penempatan_kerja' => 'required|max:255',
                    'departemen_id' => 'required',
                    'divisi_id' => 'required',
                    'bagian_id' => 'required',
                    'jabatan_id' => 'required',
                    'provinsi' => 'required',
                    'kabupaten' => 'required',
                    'kecamatan' => 'required',
                    'lama_kontrak_kerja' => 'required',
                    'kategori' => 'required',
                    'site_job' => 'required',
                    'desa' => 'required',
                    'rt' => 'required|max:255',
                    'rw' => 'required|max:255',
                ];
            } else {
                $rules = [
                    'name' => 'required|max:255',
                    'nik' => 'required|max:255',
                    'npwp' => 'max:255',
                    'fullname' => 'required|max:255',
                    'email' => 'max:255',
                    'telepon' => 'min:11|max:13',
                    // 'email' => 'required|max:255',
                    // 'telepon' => 'required|max:13|min:11',
                    'username' => 'required|max:255',
                    'password' => 'required|max:255',
                    'tempat_lahir' => 'required|max:255',
                    'tgl_lahir' => 'required|max:255',
                    'gender' => 'required',
                    'tgl_join' => 'required|max:255',
                    'status_nikah' => 'required',
                    'nama_bank' => 'required',
                    'nomor_rekening' => 'required',
                    'alamat' => 'required|max:255',
                    'kuota_cuti' => 'required|max:11',
                    'kontrak_kerja' => 'required|max:255',
                    'penempatan_kerja' => 'required|max:255',
                    'departemen_id' => 'required',
                    'divisi_id' => 'required',
                    'bagian_id' => 'required',
                    'jabatan_id' => 'required',
                    'provinsi' => 'required',
                    'kabupaten' => 'required',
                    'kecamatan' => 'required',
                    'lama_kontrak_kerja' => 'required',
                    'tgl_mulai_kontrak' => 'required',
                    'tgl_selesai_kontrak' => 'required',
                    'kategori' => 'required',
                    'site_job' => 'required',
                    'desa' => 'required',
                    'rt' => 'required|max:255',
                    'rw' => 'required|max:255',
                ];
            }
        }


        $userId = User::find($id);

        // if ($request->email != $userId->email) {
        //     $rules['email'] = 'required|unique:users';
        // }

        if ($request->username != $userId->username) {
            $rules['username'] = 'required|max:255|unique:users';
        }
        $customMessages = [
            'required' => ':attribute tidak boleh kosong.',
            'unique' => ':attribute tidak boleh sama',
            // 'email' => ':attribute format email salah',
            'min' => ':attribute Kurang'
        ];
        $validatedData = $request->validate($rules, $customMessages);
        if ($validatedData['kategori'] == 'Karyawan Harian') {
            $site_job = NULL;
            $kontrak_kerja = $request['kontrak_kerja'];
            $tgl_mulai_kontrak = NULL;
            $tgl_selesai_kontrak = NULL;
            $lama_kontrak_kerja = NULL;
        } else if ($validatedData['kategori'] == 'Karyawan Bulanan') {
            if ($validatedData['lama_kontrak_kerja'] == 'tetap') {
                // dd('ok');
                $tgl_mulai_kontrak = NULL;
                $tgl_selesai_kontrak = NULL;
                $lama_kontrak_kerja = NULL;
            } else {
                $tgl_mulai_kontrak = $validatedData['tgl_mulai_kontrak'];
                $tgl_selesai_kontrak = $validatedData['tgl_selesai_kontrak'];
            }
            $site_job = $validatedData['site_job'];
            $kontrak_kerja = $validatedData['kontrak_kerja'];
            $lama_kontrak_kerja = $validatedData['lama_kontrak_kerja'];
        }
        if ($request['foto_karyawan']) {
            // dd('ok');
            if ($request->foto_karyawan_lama) {
                Storage::delete('public/foto_karyawan/', $request->foto_karyawan_lama);
            }
            $extension     = $request->file('foto_karyawan')->extension();
            // dd($extension);
            $img_name         = date('y-m-d') . '-' . Uuid::uuid4() . '.' . $extension;
            $path           = Storage::putFileAs('public/foto_karyawan/', $request->file('foto_karyawan'), $img_name);
        } else {
            $img_name = NULL;
        }
        $holding = request()->segment(count(request()->segments()));
        User::where('id', $id)->update(
            [
                'name' => $validatedData['name'],
                'nik' => $validatedData['nik'],
                'npwp' => $validatedData['npwp'],
                'fullname' => $validatedData['fullname'],
                'motto' => $request['motto'],
                'foto_karyawan' => $img_name,
                'email' => $validatedData['email'],
                'telepon' => $validatedData['telepon'],
                'username' => $validatedData['username'],
                'password' => $validatedData['password'],
                'tempat_lahir' => $validatedData['tempat_lahir'],
                'tgl_lahir' => $validatedData['tgl_lahir'],
                'gender' => $validatedData['gender'],
                'tgl_join' => $validatedData['tgl_join'],
                'status_nikah' => $validatedData['status_nikah'],
                'nama_bank' => $validatedData['nama_bank'],
                'nomor_rekening' => $validatedData['nomor_rekening'],
                'kuota_cuti_tahunan' => $validatedData['kuota_cuti'],
                'is_admin' => $request['is_admin'],
                'site_job' => $site_job,
                'kategori' => $request['kategori'],
                'lama_kontrak_kerja' => $lama_kontrak_kerja,
                'tgl_mulai_kontrak' => $tgl_mulai_kontrak,
                'tgl_selesai_kontrak' => $tgl_selesai_kontrak,
                'kontrak_kerja' => $kontrak_kerja,
                'penempatan_kerja' => $validatedData['penempatan_kerja'],
                'provinsi' => Provincies::where('code', $validatedData['provinsi'])->value('code'),
                'kabupaten' => Cities::where('code', $validatedData['kabupaten'])->value('code'),
                'kecamatan' => District::where('code', $validatedData['kecamatan'])->value('code'),
                'desa' => Village::where('code', $validatedData['desa'])->value('code'),
                'rt' => $validatedData['rt'],
                'rw' => $validatedData['rw'],
                'alamat' => $validatedData['alamat'],
                'detail_alamat' => Provincies::where('code', $validatedData['provinsi'])->value('name') . ' , ' . Cities::where('code', $validatedData['kabupaten'])->value('name') . ' , ' . District::where('code', $validatedData['kecamatan'])->value('name') . ' , ' . Village::where('code', $validatedData['desa'])->value('name') . ' , RT. ' . $validatedData['rt'] . ' , RW. ' . $validatedData['rw'] . ' , ' . $validatedData['alamat'],
                'dept_id' => Departemen::where('id', $request["departemen_id"])->value('id'),
                'divisi_id' => Divisi::where('id', $request["divisi_id"])->value('id'),
                'bagian_id' => Bagian::where('id', $request["bagian_id"])->value('id'),
                'jabatan_id' => Jabatan::where('id', $request["jabatan_id"])->value('id'),
                'divisi1_id' => Divisi::where('id', $request["divisi1_id"])->value('id'),
                'bagian1_id' => Bagian::where('id', $request["bagian1_id"])->value('id'),
                'jabatan1_id' => Jabatan::where('id', $request["jabatan1_id"])->value('id'),
                'divisi2_id' => Divisi::where('id', $request["divisi2_id"])->value('id'),
                'bagian2_id' => Bagian::where('id', $request["bagian2_id"])->value('id'),
                'jabatan2_id' => Jabatan::where('id', $request["jabatan2_id"])->value('id'),
                'divisi3_id' => Divisi::where('id', $request["divisi3_id"])->value('id'),
                'bagian3_id' => Bagian::where('id', $request["bagian3_id"])->value('id'),
                'jabatan3_id' => Jabatan::where('id', $request["jabatan3_id"])->value('id'),
                'divisi4_id' => Divisi::where('id', $request["divisi4_id"])->value('id'),
                'bagian4_id' => Bagian::where('id', $request["bagian4_id"])->value('id'),
                'jabatan4_id' => Jabatan::where('id', $request["jabatan4_id"])->value('id'),
            ]
        );
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'update',
            'description' => 'Mengubah data karyawan ' . $request->name,
        ]);
        $request->session()->flash('success', 'Data Berhasil di Update');
        return redirect('/karyawan/' . $holding);
    }

    public function deleteKaryawan($id)
    {
        $holding = request()->segment(count(request()->segments()));
        $delete = User::find($id);
        $deleteShift = MappingShift::where('user_id', $id);
        $deleteLembur = Lembur::where('user_id', $id);
        $deleteCuti = Cuti::where('user_id', $id);
        $deleteSip = Sip::where('user_id', $id);
        Storage::delete($delete->foto_karyawan);
        $delete->delete();
        $deleteShift->delete();
        $deleteLembur->delete();
        $deleteCuti->delete();
        $deleteSip->delete();
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'delete',
            'description' => 'Menghapus data karyawan ' . $delete->name,
        ]);
        return redirect('/karyawan/' . $holding)->with('success', 'Data Berhasil di Delete');
    }

    public function editpassword($id)
    {
        $jabatan = Jabatan::join('users', function ($join) {
            $join->on('jabatans.id', '=', 'users.jabatan_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
        })->where('users.id', $id)->get();
        $divisi = Divisi::join('users', function ($join) {
            $join->on('divisis.id', '=', 'users.divisi_id');
            $join->orOn('divisis.id', '=', 'users.divisi1_id');
            $join->orOn('divisis.id', '=', 'users.divisi2_id');
            $join->orOn('divisis.id', '=', 'users.divisi3_id');
            $join->orOn('divisis.id', '=', 'users.divisi4_id');
        })->where('users.id', $id)->get();
        // dd($jabatan);
        $no = 1;
        $no1 = 1;
        $holding = request()->segment(count(request()->segments()));
        return view('admin.karyawan.edit_password_karyawan', [
            'title' => 'Edit Password',
            'holding' => $holding,
            'karyawan' => User::find($id),
            'jabatan_karyawan' => $jabatan,
            'divisi_karyawan' => $divisi,
            'no' => $no,
            'no1' => $no1,
        ]);
    }

    public function editPasswordProses(Request $request, $id)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'password' => 'required|min:6|max:255',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $id)->update($validatedData);
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'update',
            'description' => 'Mengubah password karyawan ' . $request->name,
        ]);
        $request->session()->flash('success', 'Password Berhasil Diganti');
        return redirect()->back();
    }

    public function shift($id)
    {
        $holding = request()->segment(count(request()->segments()));
        $user_check = User::where('id', $id)->first();
        if ($user_check->kategori == 'Karyawan Bulanan') {
            if ($user_check->dept_id == NULL || $user_check->divisi_id == NULL || $user_check->jabatan_id == NULL) {
                return redirect('/karyawan/' . $holding)->with('error', 'Jabatan Karyawan Kosong');
            }
        }
        $oke = MappingShift::with('Shift')->where('user_id', $id)->orderBy('id', 'desc')->limit(100)->get();
        // dd($oke);
        $user = User::with('Jabatan')
            ->with('Divisi')
            ->where('kontrak_kerja', $holding)
            ->where('users.id', $id)
            ->first();
        $jabatan = Jabatan::join('users', function ($join) {
            $join->on('jabatans.id', '=', 'users.jabatan_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan1_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan2_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan3_id');
            $join->orOn('jabatans.id', '=', 'users.jabatan4_id');
        })->where('users.id', $id)->get();
        $divisi = Divisi::join('users', function ($join) {
            $join->on('divisis.id', '=', 'users.divisi_id');
            $join->orOn('divisis.id', '=', 'users.divisi1_id');
            $join->orOn('divisis.id', '=', 'users.divisi2_id');
            $join->orOn('divisis.id', '=', 'users.divisi3_id');
            $join->orOn('divisis.id', '=', 'users.divisi4_id');
        })->where('users.id', $id)->get();
        $no = 1;
        $no1 = 1;
        // dd($jabatan);
        return view('admin.karyawan.mappingshift', [
            'title' => 'Mapping Shift',
            'karyawan' => $user,
            'holding' => $holding,
            'shift_karyawan' => MappingShift::where('user_id', $id)->orderBy('id', 'desc')->limit(100)->get(),
            'shift' => Shift::all(),
            'jabatan_karyawan' => $jabatan,
            'divisi_karyawan' => $divisi,
            'no' => $no,
            'no1' => $no1,
        ]);
    }
    public function mapping_shift_datatable(Request $request, $id)
    {
        $holding = request()->segment(count(request()->segments()));

        $table = MappingShift::join('shifts', 'mapping_shifts.shift_id', 'shifts.id')
            ->where('mapping_shifts.user_id', $id)
            ->select('mapping_shifts.*', 'shifts.nama_shift', 'shifts.jam_masuk', 'shifts.jam_keluar')
            ->limit(100)
            ->get();
        // dd($table);
        if (request()->ajax()) {
            return DataTables::of($table)
                ->addColumn('option', function ($row) use ($holding) {
                    $btn = '<button id="btn_edit_mapping_shift" type="button" data-id="' . $row->id . '" data-shift="' . $row->shift_id . '"  data-userid="' . $row->user_id . '" data-tanggal="' . $row->tanggal_masuk . '" data-holding="' . $holding . '" class="btn btn-icon btn-warning waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal_edit_shift"><span class="tf-icons mdi mdi-pencil-outline"></span></button>';
                    $btn = $btn . '<button id="btn_delete_mapping_shift" data-id="' . $row->id . '" data-holding="' . $holding . '" type="button" class="btn btn-icon btn-danger waves-effect waves-light"><span class="tf-icons mdi mdi-delete-outline"></span></button>';
                    return $btn;
                })
                ->rawColumns(['option'])
                ->make(true);
        }
    }
    public function get_divisi(Request $request)
    {
        // dd($request->all());
        $id_departemen    = $request->id_departemen;
        $divisi      = Divisi::where('dept_id', $id_departemen)->where('holding', $request->holding)->get();
        echo "<option value=''>Pilih Divisi...</option>";
        foreach ($divisi as $divisi) {
            echo "<option value='$divisi->id'>$divisi->nama_divisi</option>";
        }
    }
    public function get_bagian(Request $request)
    {
        $id_divisi    = $request->id_divisi;
        $bagian      = Bagian::where('divisi_id', $id_divisi)->where('holding', $request->holding)->get();
        echo "<option value=''>Pilih Bagian...</option>";
        foreach ($bagian as $bagian) {
            echo "<option value='$bagian->id'>$bagian->nama_bagian</option>";
        }
    }
    public function get_jabatan(Request $request)
    {
        $id_bagian    = $request->id_bagian;
        $jabatan      = Jabatan::where('bagian_id', $id_bagian)->where('holding', $request->holding)->get();
        echo "<option value=''>Pilih Jabatan...</option>";
        foreach ($jabatan as $jabatan) {
            echo "<option value='$jabatan->id'>$jabatan->nama_jabatan</option>";
        }
    }
    public function prosesTambahShift(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if ($request["tanggal_mulai"] == null) {
            $request["tanggal_mulai"] = $request["tanggal_akhir"];
        } else {
            $request["tanggal_mulai"] = $request["tanggal_mulai"];
        }

        if ($request["tanggal_akhir"] == null) {
            $request["tanggal_akhir"] = $request["tanggal_mulai"];
        } else {
            $request["tanggal_akhir"] = $request["tanggal_akhir"];
        }

        $begin = new \DateTime($request["tanggal_mulai"]);
        $end = new \DateTime($request["tanggal_akhir"]);
        $end = $end->modify('+1 day');

        $interval = new \DateInterval('P1D'); //referensi : https://en.wikipedia.org/wiki/ISO_8601#Durations
        $daterange = new \DatePeriod($begin, $interval, $end);


        // dd($request->all());
        foreach ($daterange as $date) {
            $tanggal_masuk = $date->format("Y-m-d");
            $tanggal_pulang = $date->format("Y-m-d");
            $malam = $date->modify('+1 day');
            $tanggal_pulang_malam = $malam->format("Y-m-d");
            // dd($tanggal_pulang_malam);

            if ($request["shift_id"] == '3ac53e9a-84d6-445e-9b48-fdb8a6b02cb2') {
                $request["status_absen"] = "Libur";
            } else {
                $request["status_absen"] = NULL;
            }

            $request["tanggal_masuk"] = $tanggal_masuk;
            $nama_shift = Shift::where('id', $request['shift_id'])->value('nama_shift');
            if ($nama_shift == 'Malam') {
                $request["tanggal_pulang"] = $tanggal_pulang_malam;
            } else {
                $request["tanggal_pulang"] = $tanggal_pulang;
            }
            // dd($request["tanggal_pulang"]);
            $validatedData = $request->validate([
                'user_id' => 'required',
                'shift_id' => 'required',
                'tanggal_masuk' => 'required',
                'tanggal_pulang' => 'required',
            ]);

            MappingShift::insert([
                'user_id' => User::where('id', $validatedData['user_id'])->value('id'),
                'nik_karyawan' => User::where('id', $validatedData['user_id'])->value('nomor_identitas_karyawan'),
                'nama_karyawan' => User::where('id', $validatedData['user_id'])->value('name'),
                'shift_id' => Shift::where('id', $validatedData['shift_id'])->value('id'),
                'nama_shift' => Shift::where('id', $validatedData['shift_id'])->value('nama_shift'),
                'tanggal_masuk' => $validatedData['tanggal_masuk'],
                'tanggal_pulang' => $validatedData['tanggal_pulang'],
                'status_absen' => $request['status_absen'],
            ]);
        }
        $holding = request()->segment(count(request()->segments()));
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'create',
            'description' => 'Menambahkan shift karyawan ' . Auth::user()->name,
        ]);
        return redirect('/karyawan/shift/' . $request["user_id"] . '/' . $holding)->with('success', 'Data Berhasil di Tambahkan');
    }

    public function deleteShift(Request $request, $id)
    {
        $holding = request()->segment(count(request()->segments()));
        $delete = MappingShift::find($id);
        $delete->delete();
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'delete',
            'description' => 'Menghapus shift karyawan ' . $delete->user->name,
        ]);
        return redirect()->back()->with('success', 'Data Berhasil di Delete');
    }

    public function editShift($id)
    {
        $holding = request()->segment(count(request()->segments()));
        return view('karyawan.editshift', [
            'title' => 'Edit Shift',
            'shift_karyawan' => MappingShift::find($id),
            'holding' => $holding,
            'shift' => Shift::all()
        ]);
    }

    public function prosesEditShift(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $nama_shift = Shift::where('id', $request['shift_id_update'])->value('nama_shift');
        if ($nama_shift == 'Libur') {
            $request["status_absen"] = "Libur";
        } else if ($nama_shift == 'Malam') {
            $tanggal_pulang = date('Y-m-d', strtotime('+1 days', strtotime($request['tanggal_update'])));
            // dd($tanggal_pulang);
            $request["status_absen"] = NULL;
            $request["tanggal_masuk"] = $request['tanggal_update'];
            $request["tanggal_pulang"] = $tanggal_pulang;
        } else {
            $request["tanggal_masuk"] = $request['tanggal_update'];
            $request["tanggal_pulang"] = $request['tanggal_update'];
            $request["status_absen"] = NULL;
        }
        // dd($request->all());
        $validatedData = $request->validate([
            'shift_id_update' => 'required',
            'tanggal_masuk' => 'required',
            'tanggal_pulang' => 'required',
        ]);

        MappingShift::where('id', $request["id_shift"])->update([
            'user_id' => $request['user_id'],
            'shift_id' => Shift::where('id', $validatedData['shift_id_update'])->value('id'),
            'tanggal_masuk' => $validatedData['tanggal_masuk'],
            'tanggal_pulang' => $validatedData['tanggal_pulang'],
        ]);
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'update',
            'description' => 'Mengubah shift karyawan ' . Auth::guard('web')->user()->name,
        ]);
        $holding = request()->segment(count(request()->segments()));
        return redirect('/karyawan/shift/' . $request["user_id"] . '/' . $holding)->with('success', 'Data Berhasil di Update');
    }

    public function myProfile()
    {
        return view('karyawan.myprofile', [
            'title' => 'My Profile'
        ]);
    }

    public function myProfileUpdate(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'foto_karyawan' => 'image|file|max:10240',
            'telepon' => 'required',
            'password' => 'required',
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'tgl_join' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'required'
        ];


        $userId = User::find($id);

        if ($request->email != $userId->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if ($request->username != $userId->username) {
            $rules['username'] = 'required|max:255|unique:users';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('foto_karyawan')) {
            if ($request->foto_karyawan_lama) {
                Storage::delete($request->foto_karyawan_lama);
            }
            $validatedData['foto_karyawan'] = $request->file('foto_karyawan')->store('foto_karyawan');
        }


        User::where('id', $id)->update($validatedData);
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'update',
            'description' => 'Mengubah profile karyawan ' . $request->name,
        ]);
        $request->session()->flash('success', 'Data Berhasil di Update');
        return redirect('/my-profile');
    }

    public function editPassMyProfile()
    {
        return view('karyawan.editpassmyprofile', [
            'title' => 'Ganti Password'
        ]);
    }

    public function editPassMyProfileProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:6|max:255|confirmed',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $id)->update($validatedData);
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'update',
            'description' => 'Mengubah password karyawan ' . $request->name,
        ]);
        $request->session()->flash('success', 'Password Berhasil di Update');
        return redirect('/my-profile');
    }

    public function resetCuti()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('admin.karyawan.reset_cuti', [
            'title' => 'Master Data Reset Cuti',
            'holding' => $holding,
            'data_cuti' => ResetCuti::first()
        ]);
    }

    public function resetCutiProses(Request $request, $id)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'cuti_dadakan' => 'required',
            'cuti_bersama' => 'required',
            'cuti_menikah' => 'required',
            'cuti_diluar_tanggungan' => 'required',
            'cuti_khusus' => 'required',
            'cuti_melahirkan' => 'required',
            'izin_telat' => 'required',
            'izin_pulang_cepat' => 'required'
        ]);

        ResetCuti::where('id', $id)->update($validatedData);
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'update',
            'description' => 'Mengubah master data reset cuti',
        ]);
        return redirect('/reset-cuti/' . $holding)->with('success', 'Master Cuti Berhasil Diupdate');
    }
}
