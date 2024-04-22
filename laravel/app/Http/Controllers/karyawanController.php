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
use App\Models\Departemen;
use App\Models\Divisi;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Laravolt\Indonesia\IndonesiaService;

class karyawanController extends Controller
{
    public function index()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('karyawan.index', [
            'title' => 'Karyawan',
            'holding' => $holding,
            'data_user' => User::all()
        ]);
    }
    public function provinces()
    {
    }
    public function tambahKaryawan()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('karyawan.tambah', [
            "title" => 'Tambah Karyawan',
            'holding' => $holding,
            "data_departemen" => Departemen::all(),
            "data_jabatan" => Jabatan::all()
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
            'fullname' => 'required|max:255',
            'motto' => 'required|max:255',
            'email' => 'required|max:255',
            'telepon' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'required|max:255',
            'tgl_lahir' => 'required|max:255',
            'gender' => 'required',
            'tgl_join' => 'required|max:255',
            'status_nikah' => 'required',
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
        ]);
        $size = count(collect($request["addmore"]));
        // dd(collect($request["addmore"]));
        if ($size == '1') {
            $get_divisi_id = $request["addmore"]['0']["divisi_id"];
            $divisi_id = Divisi::where('id', $get_divisi_id)->value('id');
            $get_jabatan_id = $request["addmore"]['0']["jabatan_id"];
            $jabatan_id = Jabatan::where('id', $get_jabatan_id)->value('id');
            $divisi1_id = NULL;
            $jabatan1_id = NULL;
            $divisi2_id = NULL;
            $jabatan2_id = NULL;
            $divisi3_id = NULL;
            $jabatan3_id = NULL;
            $divisi4_id = NULL;
            $jabatan4_id = NULL;
            // dd('oke 1 '.$jabatan_id);
        } else if ($size == '2') {
            // dd('oke 2');
            $get_divisi_id = $request["addmore"]['0']["divisi_id"];
            $divisi_id = Divisi::where('id', $get_divisi_id)->value('id');
            $get_jabatan_id = $request["addmore"]['0']["jabatan_id"];
            $jabatan_id = Jabatan::where('id', $get_jabatan_id)->value('id');
            $get_divisi1_id = $request["addmore"]['1']["divisi_id"];
            $divisi1_id = Divisi::where('id', $get_divisi1_id)->value('id');
            $get_jabatan1_id = $request["addmore"]['1']["jabatan_id"];
            $jabatan1_id = Jabatan::where('id', $get_jabatan1_id)->value('id');
            $divisi2_id = NULL;
            $jabatan2_id = NULL;
            $divisi3_id = NULL;
            $jabatan3_id = NULL;
            $divisi4_id = NULL;
            $jabatan4_id = NULL;
        } else if ($size == '3') {
            // dd('oke 3');
            $get_divisi_id = $request["addmore"]['0']["divisi_id"];
            $divisi_id = Divisi::where('id', $get_divisi_id)->value('id');
            $get_jabatan_id = $request["addmore"]['0']["jabatan_id"];
            $jabatan_id = Jabatan::where('id', $get_jabatan_id)->value('id');
            $get_divisi1_id = $request["addmore"]['1']["divisi_id"];
            $divisi1_id = Divisi::where('id', $get_divisi1_id)->value('id');
            $get_jabatan1_id = $request["addmore"]['1']["jabatan_id"];
            $jabatan1_id = Jabatan::where('id', $get_jabatan1_id)->value('id');
            $get_divisi2_id = $request["addmore"]['2']["divisi_id"];
            $divisi2_id = Divisi::where('id', $get_divisi2_id)->value('id');
            $get_jabatan2_id = $request["addmore"]['2']["jabatan_id"];
            $jabatan2_id = Jabatan::where('id', $get_jabatan2_id)->value('id');
            $divisi3_id = NULL;
            $jabatan3_id = NULL;
            $divisi4_id = NULL;
            $jabatan4_id = NULL;
        } else if ($size == '4') {
            // dd('oke 3');
            $get_divisi_id = $request["addmore"]['0']["divisi_id"];
            $divisi_id = Divisi::where('id', $get_divisi_id)->value('id');
            $get_jabatan_id = $request["addmore"]['0']["jabatan_id"];
            $jabatan_id = Jabatan::where('id', $get_jabatan_id)->value('id');
            $get_divisi1_id = $request["addmore"]['1']["divisi_id"];
            $divisi1_id = Divisi::where('id', $get_divisi1_id)->value('id');
            $get_jabatan1_id = $request["addmore"]['1']["jabatan_id"];
            $jabatan1_id = Jabatan::where('id', $get_jabatan1_id)->value('id');
            $get_divisi2_id = $request["addmore"]['2']["divisi_id"];
            $divisi2_id = Divisi::where('id', $get_divisi2_id)->value('id');
            $get_jabatan2_id = $request["addmore"]['2']["jabatan_id"];
            $jabatan2_id = Jabatan::where('id', $get_jabatan2_id)->value('id');
            $get_divisi3_id = $request["addmore"]['3']["divisi_id"];
            $divisi3_id = Divisi::where('id', $get_divisi3_id)->value('id');
            $get_jabatan3_id = $request["addmore"]['3']["jabatan_id"];
            $jabatan3_id = Jabatan::where('id', $get_jabatan3_id)->value('id');
            $divisi4_id = NULL;
            $jabatan4_id = NULL;
        } else if ($size == '5') {
            // dd($request["addmore"]['4']["jabatan_id"]);
            $get_divisi_id = $request["addmore"]['0']["divisi_id"];
            $divisi_id = Divisi::where('id', $get_divisi_id)->value('id');
            $get_jabatan_id = $request["addmore"]['0']["jabatan_id"];
            $jabatan_id = Jabatan::where('id', $get_jabatan_id)->value('id');
            $get_divisi1_id = $request["addmore"]['1']["divisi_id"];
            $divisi1_id = Divisi::where('id', $get_divisi1_id)->value('id');
            $get_jabatan1_id = $request["addmore"]['1']["jabatan_id"];
            $jabatan1_id = Jabatan::where('id', $get_jabatan1_id)->value('id');
            $get_divisi2_id = $request["addmore"]['2']["divisi_id"];
            $divisi2_id = Divisi::where('id', $get_divisi2_id)->value('id');
            $get_jabatan2_id = $request["addmore"]['2']["jabatan_id"];
            $jabatan2_id = Jabatan::where('id', $get_jabatan2_id)->value('id');
            $get_divisi3_id = $request["addmore"]['3']["divisi_id"];
            $divisi3_id = Divisi::where('id', $get_divisi3_id)->value('id');
            $get_jabatan3_id = $request["addmore"]['3']["jabatan_id"];
            $jabatan3_id = Jabatan::where('id', $get_jabatan3_id)->value('id');
            $get_divisi4_id = $request["addmore"]['4']["divisi_id"];
            $divisi4_id = Divisi::where('id', $get_divisi4_id)->value('id');
            $get_jabatan4_id = $request["addmore"]['4']["jabatan_id"];
            $jabatan4_id = Jabatan::where('id', $get_jabatan4_id)->value('id');
        } else {
            $divisi_id = NULL;
            $jabatan_id = NULL;
            $divisi1_id = NULL;
            $jabatan1_id = NULL;
            $divisi2_id = NULL;
            $jabatan2_id = NULL;
            $divisi3_id = NULL;
            $jabatan3_id = NULL;
            $divisi4_id = NULL;
            $jabatan4_id = NULL;
        }


        // dd($validatedData);
        $insert = User::create(
            [
                'name' => $validatedData['name'],
                'fullname' => $validatedData['fullname'],
                'motto' => $validatedData['motto'],
                'foto_karyawan' => $request['foto_karyawan'],
                'email' => $validatedData['email'],
                'telepon' => $validatedData['telepon'],
                'username' => $validatedData['username'],
                'password' => Hash::make($validatedData['password']),
                'tgl_lahir' => $validatedData['tgl_lahir'],
                'gender' => $validatedData['gender'],
                'tgl_join' => $validatedData['tgl_join'],
                'status_nikah' => $validatedData['status_nikah'],
                'alamat' => $validatedData['alamat'],
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
        $holding = request()->segment(count(request()->segments()));
        return redirect('/karyawan/' . $holding)->with('success', 'Data Berhasil di Tambahkan');
    }

    public function detail($id)
    {
        $holding = request()->segment(count(request()->segments()));
        return view('karyawan.editkaryawan', [
            'title' => 'Detail Karyawan',
            'holding' => $holding,
            'karyawan' => User::find($id),
            'data_jabatan' => Jabatan::all()
        ]);
    }

    public function editKaryawanProses(Request $request, $id)
    {
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
            'foto_karyawan' => 'image|file|max:10240',
            'telepon' => 'required',
            'password' => 'required',
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'tgl_join' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'required',
            'cuti_dadakan' => 'required',
            'cuti_bersama' => 'required',
            'cuti_menikah' => 'required',
            'cuti_diluar_tanggungan' => 'required',
            'cuti_khusus' => 'required',
            'cuti_melahirkan' => 'required',
            'izin_telat' => 'required',
            'izin_pulang_cepat' => 'required',
            'is_admin' => 'required',
            'jabatan_id' => 'required',
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
            'description' => 'Mengubah data karyawan ' . $request->name,
        ]);
        $request->session()->flash('success', 'Data Berhasil di Update');
        return redirect('/karyawan');
    }

    public function deleteKaryawan($id)
    {
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
        return redirect('/karyawan')->with('success', 'Data Berhasil di Delete');
    }

    public function editpassword($id)
    {
        return view('karyawan.editpassword', [
            'title' => 'Edit Password',
            'karyawan' => User::find($id)
        ]);
    }

    public function editPasswordProses(Request $request, $id)
    {
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
        return redirect('/karyawan');
    }

    public function shift($id)
    {
        // dd($id);
        return view('karyawan.mappingshift', [
            'title' => 'Mapping Shift',
            'karyawan' => User::find($id),
            'shift_karyawan' => MappingShift::where('user_id', $id)->orderBy('id', 'desc')->limit(100)->get(),
            'shift' => Shift::all()
        ]);
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
        // dd($request->all());
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


        foreach ($daterange as $date) {
            $tanggal = $date->format("Y-m-d");

            if ($request["shift_id"] == 1) {
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

            MappingShift::create($validatedData);
        }
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'create',
            'description' => 'Menambahkan shift karyawan ' . $request->name,
        ]);
        return redirect('/karyawan/shift/' . $request["user_id"])->with('success', 'Data Berhasil di Tambahkan');
    }

    public function deleteShift(Request $request, $id)
    {
        $delete = MappingShift::find($id);
        $delete->delete();
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'delete',
            'description' => 'Menghapus shift karyawan ' . $delete->user->name,
        ]);
        return redirect('/karyawan/shift/' . $request["user_id"])->with('success', 'Data Berhasil di Delete');
    }

    public function editShift($id)
    {
        return view('karyawan.editshift', [
            'title' => 'Edit Shift',
            'shift_karyawan' => MappingShift::find($id),
            'shift' => Shift::all()
        ]);
    }

    public function prosesEditShift(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');


        if ($request["shift_id"] == 1) {
            $request["status_absen"] = "Libur";
        } else {
            $request["status_absen"] = "Tidak Masuk";
        }

        $validatedData = $request->validate([
            'shift_id' => 'required',
            'tanggal' => 'required',
            'status_absen' => 'required'
        ]);

        MappingShift::where('id', $id)->update($validatedData);
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'update',
            'description' => 'Mengubah shift karyawan ' . $request->name,
        ]);
        return redirect('/karyawan/shift/' . $request["user_id"])->with('success', 'Data Berhasil di Update');
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
        return view('karyawan.masterreset', [
            'title' => 'Master Data Reset Cuti',
            'data_cuti' => ResetCuti::first()
        ]);
    }

    public function resetCutiProses(Request $request, $id)
    {
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
        return redirect('/reset-cuti')->with('success', 'Master Cuti Berhasil Diupdate');
    }
}
