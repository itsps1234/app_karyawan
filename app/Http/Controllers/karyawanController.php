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
use Illuminate\Support\Facades\Auth;

class karyawanController extends Controller
{
    public function index()
    {
        return view('karyawan.index', [
            'title' => 'Karyawan',
            'data_user' => User::all()
        ]);
    }

    public function tambahKaryawan()
    {
        return view('karyawan.tambah',[
            "title" => 'Tambah Karyawan',
            "data_jabatan" => Jabatan::all()
        ]);
    }

    public function tambahKaryawanProses(Request $request)
    {
        if($request["cuti_dadakan"] == null) {
            $request["cuti_dadakan"] = "0";
        } else {
            $request["cuti_dadakan"];
        }

        if($request["cuti_bersama"] == null) {
            $request["cuti_bersama"] = "0";
        }  else {
            $request["cuti_bersama"];
        }

        if($request["cuti_menikah"] == null) {
            $request["cuti_menikah"] = "0";
        }  else {
            $request["cuti_menikah"];
        }

        if($request["cuti_diluar_tanggungan"] == null) {
            $request["cuti_diluar_tanggungan"] = "0";
        }  else {
            $request["cuti_diluar_tanggungan"];
        }

        if($request["cuti_khusus"] == null) {
            $request["cuti_khusus"] = "0";
        }  else {
            $request["cuti_khusus"];
        }

        if($request["cuti_melahirkan"] == null) {
            $request["cuti_melahirkan"] = "0";
        }  else {
            $request["cuti_melahirkan"];
        }

        if($request["izin_telat"] == null) {
            $request["izin_telat"] = "0";
        }  else {
            $request["izin_telat"];
        }

        if($request["izin_pulang_cepat"] == null) {
            $request["izin_pulang_cepat"] = "0";
        }  else {
            $request["izin_pulang_cepat"];
        }


        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'foto_karyawan' => 'image|file|max:10240',
            'email' => 'required|email:dns|unique:users',
            'telepon' => 'required',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6|max:255',
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
        ]);

        if ($request->file('foto_karyawan')) {
            $validatedData['foto_karyawan'] = $request->file('foto_karyawan')->store('foto_karyawan');
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        // Merekam aktivitas pengguna
        ActivityLog::create([
            'user_id' => $request->user()->id,
            'activity' => 'create',
            'description' => 'Menambahkan data karyawan baru '.$request->name,
        ]);

        return redirect('/karyawan')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function detail($id)
    {
        return view('karyawan.editkaryawan', [
            'title' => 'Detail Karyawan',
            'karyawan' => User::find($id),
            'data_jabatan' => Jabatan::all()
        ]);
    }

    public function editKaryawanProses(Request $request, $id)
    {
        if($request["cuti_dadakan"] == null) {
            $request["cuti_dadakan"] = "0";
        } else {
            $request["cuti_dadakan"];
        }

        if($request["cuti_bersama"] == null) {
            $request["cuti_bersama"] = "0";
        }  else {
            $request["cuti_bersama"];
        }

        if($request["cuti_menikah"] == null) {
            $request["cuti_menikah"] = "0";
        }  else {
            $request["cuti_menikah"];
        }

        if($request["cuti_diluar_tanggungan"] == null) {
            $request["cuti_diluar_tanggungan"] = "0";
        }  else {
            $request["cuti_diluar_tanggungan"];
        }

        if($request["cuti_khusus"] == null) {
            $request["cuti_khusus"] = "0";
        }  else {
            $request["cuti_khusus"];
        }

        if($request["cuti_melahirkan"] == null) {
            $request["cuti_melahirkan"] = "0";
        }  else {
            $request["cuti_melahirkan"];
        }

        if($request["izin_telat"] == null) {
            $request["izin_telat"] = "0";
        }  else {
            $request["izin_telat"];
        }

        if($request["izin_pulang_cepat"] == null) {
            $request["izin_pulang_cepat"] = "0";
        }  else {
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
            'description' => 'Mengubah data karyawan '.$request->name,
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
            'description' => 'Menghapus data karyawan '.$delete->name,
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
            'description' => 'Mengubah password karyawan '.$request->name,
        ]);
        $request->session()->flash('success', 'Password Berhasil Diganti');
        return redirect('/karyawan');
    }

    public function shift($id)
    {
        return view('karyawan.mappingshift', [
            'title' => 'Mapping Shift',
            'karyawan' => User::find($id),
            'shift_karyawan' => MappingShift::where('user_id', $id)->orderBy('id', 'desc')->limit(100)->get(),
            'shift' => Shift::all()
        ]);
    }
 
    public function prosesTambahShift(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if($request["tanggal_mulai"] == null) {
            $request["tanggal_mulai"] = $request["tanggal_akhir"];
        } else {
            $request["tanggal_mulai"] = $request["tanggal_mulai"];
        }

        if($request["tanggal_akhir"] == null) {
            $request["tanggal_akhir"] = $request["tanggal_mulai"];
        } else {
            $request["tanggal_akhir"] = $request["tanggal_akhir"];
        }

        $begin = new \DateTime($request["tanggal_mulai"]);
        $end = new \DateTime($request["tanggal_akhir"]);
        $end = $end->modify('+1 day');

        $interval = new \DateInterval('P1D'); //referensi : https://en.wikipedia.org/wiki/ISO_8601#Durations
        $daterange = new \DatePeriod($begin, $interval ,$end);


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
            'description' => 'Menambahkan shift karyawan '.$request->name,
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
            'description' => 'Menghapus shift karyawan '.$delete->user->name,
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
            'description' => 'Mengubah shift karyawan '.$request->name,
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
            'description' => 'Mengubah profile karyawan '.$request->name,
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
            'description' => 'Mengubah password karyawan '.$request->name,
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
