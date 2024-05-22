<?php

namespace App\Http\Controllers;

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
            "data_departemen" => Departemen::all(),
            'holding' => $holding,
            'data_user' => User::where('kontrak_kerja', $holding)->get(),
            "data_departemen" => Departemen::all(),
            "data_jabatan" => Jabatan::all(),
            "data_provinsi" => Provincies::all(),
            "data_kabupaten" => Cities::all(),
            "data_kecamatan" => District::all(),
            "data_desa" => Village::all(),
            "data_lokasi" => Lokasi::all(),
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
    public function get_kabupaten($id)
    {
        // dd($id);
        $get_kabupaten = Cities::where('province_code', $id)->get();
        // return $get_kabupaten;
        echo "<option value=''>Pilih Kabupaten...</option>";
        foreach ($get_kabupaten as $kabupaten) {
            echo "<option value='$kabupaten->code'>$kabupaten->name</option>";
        }
    }
    public function get_kecamatan($id)
    {
        // dd($id);
        $get_desa = District::where('city_code', $id)->get();
        // return $get_desa;
        echo "<option value=''>Pilih Kecamatan...</option>";
        foreach ($get_desa as $desa) {
            echo "<option value='$desa->code'>$desa->name</option>";
        }
    }
    public function get_desa($id)
    {
        // dd($id);
        $get_kecamatan = Village::where('district_code', $id)->get();
        // return $get_kecamatan;
        echo "<option value=''>Pilih Desa...</option>";
        foreach ($get_kecamatan as $kecamatan) {
            echo "<option value='$kecamatan->code'>$kecamatan->name</option>";
        }
    }
    public function tambahKaryawan()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('karyawan.tambah', [
            "title" => 'Tambah Karyawan',
            'holding' => $holding,
            "data_departemen" => Departemen::all(),
            "data_jabatan" => Jabatan::all(),
            "data_provinsi" => Provincies::all(),
            "data_kabupaten" => Cities::all(),
            "data_kecamatan" => District::all(),
            "data_desa" => Village::all(),
            "data_lokasi" => Lokasi::all(),
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
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'nik' => 'required|max:255|unique:users',
            'npwp' => 'required|max:255|unique:users',
            'fullname' => 'required|max:255',
            'motto' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'telepon' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tgl_lahir' => 'required|max:255',
            'gender' => 'required',
            'tgl_join' => 'required|max:255',
            'status_nikah' => 'required',
            'nama_bank' => 'required',
            'nomor_rekening' => 'required',
            'alamat' => 'required|max:255',
            'cuti_dadakan' => 'required|max:11',
            'cuti_bersama' => 'required|max:11',
            'cuti_menikah' => 'required|max:11',
            'cuti_diluar_tanggungan' => 'required|max:11',
            'cuti_khusus' => 'required|max:11',
            'cuti_melahirkan' => 'required|max:11',
            'izin_telat' => 'required|max:11',
            'izin_pulang_cepat' => 'required|max:11',
            'kuota_cuti' => 'required|max:11',
            'kontrak_kerja' => 'required|max:255',
            'penempatan_kerja' => 'required|max:255',
            'site_job' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'rt' => 'required|max:255',
            'rw' => 'required|max:255',
        ]);
        if ($request['foto_karyawan']) {
            // dd('ok');
            $extension     = $request->file('foto_karyawan')->extension();
            // dd($extension);
            $img_name         = date('y-m-d') . '-' . Uuid::uuid4() . '.' . $extension;
            $path           = Storage::putFileAs('public/foto_karyawan/', $request->file('foto_karyawan'), $img_name);
        } else {
            $img_name = NULL;
        }
        // dd($request["addmore"]['4']["jabatan_id"]);
        $get_divisi_id = $request["addmore"]['0']["divisi_id"];
        if ($get_divisi_id == '') {
            $divisi_id = NULL;
            $jabatan_id = NULL;
        } else {
            $get_jabatan_id = $request["addmore"]['0']["jabatan_id"];
            $divisi_id = Divisi::where('id', $get_divisi_id)->value('id');
            $jabatan_id = Jabatan::where('id', $get_jabatan_id)->value('id');
        }
        $get_divisi1_id = $request["addmore"]['1']["divisi_id"];
        if ($get_divisi1_id == '') {
            $divisi1_id = NULL;
            $jabatan1_id = NULL;
        } else {
            $get_jabatan1_id = $request["addmore"]['1']["jabatan_id"];
            $divisi1_id = Divisi::where('id', $get_divisi1_id)->value('id');
            $jabatan1_id = Jabatan::where('id', $get_jabatan1_id)->value('id');
        }
        $get_divisi2_id = $request["addmore"]['2']["divisi_id"];
        if ($get_divisi2_id == '') {
            $divisi2_id = NULL;
            $jabatan2_id = NULL;
        } else {
            $get_jabatan2_id = $request["addmore"]['2']["jabatan_id"];
            $divisi2_id = Divisi::where('id', $get_divisi2_id)->value('id');
            $jabatan2_id = Jabatan::where('id', $get_jabatan2_id)->value('id');
        }
        $get_divisi3_id = $request["addmore"]['3']["divisi_id"];
        if ($get_divisi3_id == '') {
            $divisi3_id = NULL;
            $jabatan3_id = NULL;
        } else {
            $get_jabatan3_id = $request["addmore"]['3']["jabatan_id"];
            $divisi3_id = Divisi::where('id', $get_divisi3_id)->value('id');
            $jabatan3_id = Jabatan::where('id', $get_jabatan3_id)->value('id');
        }
        $get_divisi4_id = $request["addmore"]['4']["divisi_id"];
        if ($get_divisi4_id == '') {
            $divisi4_id = NULL;
            $jabatan4_id = NULL;
        } else {
            $get_jabatan4_id = $request["addmore"]['4']["jabatan_id"];
            $divisi4_id = Divisi::where('id', $get_divisi4_id)->value('id');
            $jabatan4_id = Jabatan::where('id', $get_jabatan4_id)->value('id');
        }

        $holding = request()->segment(count(request()->segments()));
        // dd($validatedData);
        $insert = User::create(
            [
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
                'kuota_cuti' => $validatedData['kuota_cuti'],
                'cuti_dadakan' => $validatedData['cuti_dadakan'],
                'cuti_bersama' => $validatedData['cuti_bersama'],
                'cuti_menikah' => $validatedData['cuti_menikah'],
                'cuti_diluar_tanggungan' => $validatedData['cuti_diluar_tanggungan'],
                'cuti_khusus' => $validatedData['cuti_khusus'],
                'cuti_melahirkan' => $validatedData['cuti_melahirkan'],
                'izin_telat' => $validatedData['izin_telat'],
                'izin_pulang_cepat' => $validatedData['izin_pulang_cepat'],
                'is_admin' => $request['is_admin'],
                'kontrak_kerja' => $holding,
                'penempatan_kerja' => $validatedData['penempatan_kerja'],
                'site_job' => $validatedData['site_job'],
                'provinsi' => Provincies::where('code', $validatedData['provinsi'])->value('code'),
                'kabupaten' => Cities::where('code', $validatedData['kabupaten'])->value('code'),
                'kecamatan' => District::where('code', $validatedData['kecamatan'])->value('code'),
                'desa' => Village::where('code', $validatedData['desa'])->value('code'),
                'rt' => $validatedData['rt'],
                'rw' => $validatedData['rw'],
                'alamat' => $validatedData['alamat'],
                'detail_alamat' => Provincies::where('code', $validatedData['provinsi'])->value('name') . ' , ' . Cities::where('code', $validatedData['kabupaten'])->value('name') . ' , ' . District::where('code', $validatedData['kecamatan'])->value('name') . ' , ' . Village::where('code', $validatedData['desa'])->value('name') . ' , RT. ' . $validatedData['rt'] . ' , RW. ' . $validatedData['rw'] . ' , ' . $validatedData['alamat'],
                'dept_id' => Departemen::where('id', $request["departemen_id"])->value('id'),
                'divisi_id' => Divisi::where('id', $divisi_id)->value('id'),
                'jabatan_id' => Jabatan::where('id', $jabatan_id)->value('id'),
                'divisi1_id' => Divisi::where('id', $divisi1_id)->value('id'),
                'jabatan1_id' => Jabatan::where('id', $jabatan1_id)->value('id'),
                'divisi2_id' => Divisi::where('id', $divisi2_id)->value('id'),
                'jabatan2_id' => Jabatan::where('id', $jabatan2_id)->value('id'),
                'divisi3_id' => Divisi::where('id', $divisi3_id)->value('id'),
                'jabatan3_id' => Jabatan::where('id', $jabatan3_id)->value('id'),
                'divisi4_id' => Divisi::where('id', $divisi4_id)->value('id'),
                'jabatan4_id' => Jabatan::where('id', $jabatan4_id)->value('id'),
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
            'data_departemen' => Departemen::all(),
            "data_lokasi" => Lokasi::all(),
            "data_provinsi" => Provincies::all(),
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

        $rules = [
            'name' => 'required|max:255',
            'nik' => 'required|max:255',
            'npwp' => 'required|max:255',
            'fullname' => 'required|max:255',
            'motto' => 'required|max:255',
            'email' => 'required|max:255',
            'telepon' => 'required|max:255',
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
            'cuti_dadakan' => 'required|max:11',
            'cuti_bersama' => 'required|max:11',
            'cuti_menikah' => 'required|max:11',
            'cuti_diluar_tanggungan' => 'required|max:11',
            'cuti_khusus' => 'required|max:11',
            'cuti_melahirkan' => 'required|max:11',
            'izin_telat' => 'required|max:11',
            'izin_pulang_cepat' => 'required|max:11',
            'kuota_cuti' => 'required|max:11',
            'kontrak_kerja' => 'required|max:255',
            'penempatan_kerja' => 'required|max:255',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'site_job' => 'required',
            'desa' => 'required',
            'rt' => 'required|max:255',
            'rw' => 'required|max:255',
        ];


        $userId = User::find($id);

        if ($request->email != $userId->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if ($request->username != $userId->username) {
            $rules['username'] = 'required|max:255|unique:users';
        }

        $validatedData = $request->validate($rules);

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
                'motto' => $validatedData['motto'],
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
                'kuota_cuti' => $validatedData['kuota_cuti'],
                'cuti_dadakan' => $validatedData['cuti_dadakan'],
                'cuti_bersama' => $validatedData['cuti_bersama'],
                'cuti_menikah' => $validatedData['cuti_menikah'],
                'cuti_diluar_tanggungan' => $validatedData['cuti_diluar_tanggungan'],
                'cuti_khusus' => $validatedData['cuti_khusus'],
                'cuti_melahirkan' => $validatedData['cuti_melahirkan'],
                'izin_telat' => $validatedData['izin_telat'],
                'izin_pulang_cepat' => $validatedData['izin_pulang_cepat'],
                'is_admin' => $request['is_admin'],
                'kontrak_kerja' => $validatedData['kontrak_kerja'],
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
                'jabatan_id' => Jabatan::where('id', $request["jabatan_id"])->value('id'),
                'divisi1_id' => Divisi::where('id', $request["divisi1_id"])->value('id'),
                'jabatan1_id' => Jabatan::where('id', $request["jabatan1_id"])->value('id'),
                'divisi2_id' => Divisi::where('id', $request["divisi2_id"])->value('id'),
                'jabatan2_id' => Jabatan::where('id', $request["jabatan2_id"])->value('id'),
                'divisi3_id' => Divisi::where('id', $request["divisi3_id"])->value('id'),
                'jabatan3_id' => Jabatan::where('id', $request["jabatan3_id"])->value('id'),
                'divisi4_id' => Divisi::where('id', $request["divisi4_id"])->value('id'),
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
        $oke = MappingShift::with('Shift')->where('user_id', $id)->orderBy('id', 'desc')->limit(100)->get();
        // dd($oke);
        $holding = request()->segment(count(request()->segments()));
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
        // dd($user);
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
        if (request()->ajax()) {
            return DataTables::of($table)
                ->addColumn('option', function ($row) use ($holding) {
                    $btn = '<button id="btn_edit_mapping_shift" type="button" data-id="' . $row->id . '" data-shift="' . $row->shift_id . '"  data-userid="' . $row->user_id . '" data-tanggal="' . $row->tanggal . '" data-holding="' . $holding . '" class="btn btn-icon btn-warning waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal_edit_shift"><span class="tf-icons mdi mdi-pencil-outline"></span></button>';
                    $btn = $btn . '<button id="btn_delete_mapping_shift" data-id="' . $row->id . '" data-holding="' . $holding . '" type="button" class="btn btn-icon btn-danger waves-effect waves-light"><span class="tf-icons mdi mdi-delete-outline"></span></button>';
                    return $btn;
                })
                ->rawColumns(['option'])
                ->make(true);
        }
    }
    public function get_divisi(Request $request)
    {
        $id_departemen    = $request->id_departemen;
        $divisi      = Divisi::where('dept_id', $id_departemen)->get();
        // dd($divisi);
        echo "<option value=''>Pilih Divisi...</option>";
        foreach ($divisi as $divisi) {
            echo "<option value='$divisi->id'>$divisi->nama_divisi</option>";
        }
    }
    public function get_jabatan(Request $request)
    {
        $id_divisi    = $request->id_divisi;
        $jabatan      = Jabatan::where('divisi_id', $id_divisi)->get();
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
            $tanggal = $date->format("Y-m-d");

            if ($request["shift_id"] == '3ac53e9a-84d6-445e-9b48-fdb8a6b02cb2') {
                $request["status_absen"] = "Libur";
            } else {
                $request["status_absen"] = "Tidak Masuk";
            }

            $request["tanggal"] = $tanggal;

            $validatedData = $request->validate([
                'user_id' => 'required',
                'shift_id' => 'required',
                'tanggal' => 'required',
                'status_absen' => 'required',
            ]);

            MappingShift::insert([
                'user_id' => User::where('id', $validatedData['user_id'])->value('id'),
                'shift_id' => Shift::where('id', $validatedData['shift_id'])->value('id'),
                'tanggal' => $validatedData['tanggal'],
                'status_absen' => $validatedData['status_absen'],
            ]);
        }
        $holding = request()->segment(count(request()->segments()));
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'create',
            'description' => 'Menambahkan shift karyawan ' . $request->name,
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


        // if ($request["shift_id_update"] == 1) {
        //     $request["status_absen"] = "Libur";
        // } else {
        //     $request["status_absen"] = "Tidak Masuk";
        // }
        // dd($request->all());
        $validatedData = $request->validate([
            'shift_id_update' => 'required',
            'tanggal_update' => 'required',
        ]);

        MappingShift::where('id', $request["id_shift"])->update([
            'user_id' => $request['user_id'],
            'shift_id' => Shift::where('id', $validatedData['shift_id_update'])->value('id'),
            'tanggal' => $validatedData['tanggal_update'],
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
