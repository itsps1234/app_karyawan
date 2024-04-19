<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MappingShift;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::findOrFail(auth()->user()->id);
        return view('cuti.index', [
            'title' => 'Tambah Permintaan Cuti Karyawan',
            'data_user' => $user,
            'data_cuti_user' => Cuti::where('user_id', $user_id)->orderBy('id', 'desc')->get()
        ]);
    }

    public function tambah(Request $request)
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
            $request["tanggal"] = $date->format("Y-m-d");

            $request['status_cuti'] = "Pending";
            $validatedData = $request->validate([
                'user_id' => 'required',
                'nama_cuti' => 'required',
                'tanggal' => 'required',
                'alasan_cuti' => 'required',
                'foto_cuti' => 'image|file|max:10240',
                'status_cuti' => 'required',
            ]);

            if ($request->file('foto_cuti')) {
                $validatedData['foto_cuti'] = $request->file('foto_cuti')->store('foto_cuti');
            }

            Cuti::create($validatedData);
        }
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'tambah',
            'description' => 'Menambahkan data cuti baru dengan nama cuti ' . $request->nama_cuti,
        ]);

        return redirect('/cuti')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function delete($id)
    {
        $delete = Cuti::find($id);
        // Storage::delete($delete->foto_cuti);
        $delete->delete();
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'hapus',
            'description' => 'Menghapus data cuti dengan nama cuti ' . $delete->nama_cuti,
        ]);
        return redirect('/cuti')->with('success', 'Data Berhasil di Delete');
    }

    public function edit($id){
        return view('cuti.edit', [
            'title' => 'Edit Permintaan Cuti',
            'data_cuti_user' => Cuti::findOrFail($id)
        ]);
    }

    public function editProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'nama_cuti' => 'required',
            'tanggal' => 'required',
            'alasan_cuti' => 'required',
            'foto_cuti' => 'image|file|max:10240',
        ]);

        if ($request->file('foto_cuti')) {
            // if ($request->foto_cuti_lama) {
            //     Storage::delete($request->foto_cuti_lama);
            // }
            $validatedData['foto_cuti'] = $request->file('foto_cuti')->store('foto_cuti');
        }

        Cuti::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Data Berhasil di Update');
        return redirect('/cuti');
    }

    public function dataCuti()
    {
        return view('cuti.datacuti', [
            'title' => 'Data Cuti Karyawan',
            'data_cuti' => Cuti::orderBy('id', 'desc')->get()
        ]);
    }

    public function tambahAdmin()
    {
        return view('cuti.tambahadmin', [
            'title' => 'Tambah Cuti Karyawan',
            'data_user' => User::select('id', 'name')->get()
        ]);
    }

    public function getUserId(Request $request)
    {
        $id = $request["id"];
        $data_user = User::findOrfail($id);

        $cuti_dadakan = $data_user->cuti_dadakan;
        $cuti_bersama = $data_user->cuti_bersama;
        $cuti_menikah = $data_user->cuti_menikah;
        $cuti_diluar_tanggungan = $data_user->cuti_diluar_tanggungan;
        $cuti_khusus = $data_user->cuti_khusus;
        $cuti_melahirkan = $data_user->cuti_melahirkan;
        $izin_telat = $data_user->izin_telat;
        $izin_pulang_cepat = $data_user->izin_pulang_cepat;

        $data_cuti = array(
            [
                'nama' => 'Cuti Dadakan',
                'nama_cuti' => 'Cuti Dadakan ('.$cuti_dadakan.')'
            ],
            [
                'nama' => 'Cuti Bersama',
                'nama_cuti' => 'Cuti Bersama ('.$cuti_bersama.')'
            ],
            [
                'nama' => 'Cuti Menikah',
                'nama_cuti' => 'Cuti Menikah ('.$cuti_menikah.')'
            ],
            [
                'nama' => 'Cuti Diluar Tanggungan',
                'nama_cuti' => 'Cuti Diluar Tanggungan ('.$cuti_diluar_tanggungan.')'
            ],
            [
                'nama' => 'Cuti Khusus',
                'nama_cuti' => 'Cuti Khusus ('.$cuti_khusus.')'
            ],
            [
                'nama' => 'Cuti Melahirkan',
                'nama_cuti' => 'Cuti Melahirkan ('.$cuti_melahirkan.')'
            ],
            [
                'nama' => 'Izin Telat',
                'nama_cuti' => 'Izin Telat ('.$izin_telat.')'
            ],
            [
                'nama' => 'Izin Pulang Cepat',
                'nama_cuti' => 'Izin Pulang Cepat ('.$izin_pulang_cepat.')'
            ]
        );

        foreach($data_cuti as $dc){
            echo "<option value='$dc[nama]'>$dc[nama_cuti]</option>";
        }
    }

    public function tambahAdminProses(Request $request)
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
            $request["tanggal"] = $date->format("Y-m-d");

            $request['status_cuti'] = "Pending";
            $validatedData = $request->validate([
                'user_id' => 'required',
                'nama_cuti' => 'required',
                'tanggal' => 'required',
                'alasan_cuti' => 'required',
                'foto_cuti' => 'image|file|max:10240',
                'status_cuti' => 'required',
            ]);

            if ($request->file('foto_cuti')) {
                $validatedData['foto_cuti'] = $request->file('foto_cuti')->store('foto_cuti');
            }

            Cuti::create($validatedData);
        }
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'tambah',
            'description' => 'Menambahkan data cuti karyawan dengan nama '.User::findOrfail($request["user_id"])->name,
            'time' => date('Y-m-d H:i:s')
        ]);

        return redirect('/data-cuti')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function deleteAdmin($id)
    {
        $delete = Cuti::find($id);
        // Storage::delete($delete->foto_cuti);
        $delete->delete();
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'hapus',
            'description' => 'Menghapus data cuti karyawan dengan nama '.User::findOrfail($delete->user_id)->name,
            'time' => date('Y-m-d H:i:s')
        ]);
        return redirect('/data-cuti')->with('success', 'Data Berhasil di Delete');
    }

    public function editAdmin($id)
    {
        return view('cuti.editadmin', [
            'title' => 'Edit Cuti Karyawan',
            'data_cuti_karyawan' => Cuti::findOrFail($id)
        ]);
    }

    public function editAdminProses(Request $request, $id)
     {
        $data_cuti = Cuti::where('id', $id)->get();

        foreach($data_cuti as $dc) {
            $request["cuti_dadakan"] = $dc->User->cuti_dadakan;
            $request["cuti_bersama"] = $dc->User->cuti_bersama;
            $request["cuti_menikah"] = $dc->User->cuti_menikah;
            $request["cuti_diluar_tanggungan"] = $dc->User->cuti_diluar_tanggungan;
            $request["cuti_khusus"] = $dc->User->cuti_khusus;
            $request["cuti_melahirkan"] = $dc->User->cuti_melahirkan;
            $request["izin_telat"] = $dc->User->izin_telat;
            $request["izin_pulang_cepat"] = $dc->User->izin_pulang_cepat;
            $user_id = $dc->user_id;
            $foto_cuti = $dc->foto_cuti;
        }
        
        $mapping_shift = MappingShift::where('tanggal', $request['tanggal'])->where('user_id', $user_id)->get();

        if($mapping_shift->count() == 0 ) {
            Alert::error('Error', 'Tidak Ada Shift Pada Tanggal ' . $request['tanggal'] . ', Harap Dimapping Terlebih Dahulu');
            return redirect('/data-cuti');
        } else {
            foreach($mapping_shift as $mp) {
                $mp_id = $mp->id;
                $status_absen = $mp->status_absen;
                $shift_masuk = $mp->Shift->jam_masuk;
                $shift_pulang = $mp->Shift->jam_keluar;
                $jam_absen = $mp->jam_absen;
                $telat = $mp->telat;
                $lat_absen = $mp->lat_absen;
                $long_absen = $mp->long_absen;
                $jarak_masuk = $mp->jarak_masuk;
                $foto_jam_absen = $mp->foto_jam_absen;
                $jam_pulang = $mp->jam_pulang;
                $pulang_cepat = $mp->pulang_cepat;
                $lat_pulang = $mp->lat_pulang;
                $long_pulang = $mp->long_pulang;
                $jarak_pulang = $mp->jarak_pulang;
                $foto_jam_pulang = $mp->foto_jam_pulang;
            }
    
            if($request["status_cuti"] == "Diterima"){
                if ($request["nama_cuti"] == "Izin Telat") {
                    $request['status_absen'] = $request["nama_cuti"];
                    $request['jam_absen'] = $shift_masuk;
                    $request['telat'] = 0;
                    $request['lat_absen'] = "-6.3707314";
                    $request['long_absen'] = "106.8138057";
                    $request['jarak_masuk'] = "0";
                    $request['jam_pulang'] = $jam_pulang;
                    $request['foto_jam_absen'] = $foto_cuti;
                    $request['pulang_cepat'] = $pulang_cepat;
                    $request['lat_pulang'] = $lat_pulang;
                    $request['long_pulang'] = $long_pulang;
                    $request['jarak_pulang'] = $jarak_pulang;
                    $request['foto_jam_pulang'] = $foto_jam_pulang;
                } elseif ($request["nama_cuti"] == "Izin Pulang Cepat") {
                    $request['status_absen'] = $request["nama_cuti"];
                    $request['jam_pulang'] = $shift_pulang;
                    $request['pulang_cepat'] = 0;
                    $request['lat_pulang'] = "-6.3707314";
                    $request['long_pulang'] = "106.8138057";
                    $request['jarak_masuk'] = $jarak_masuk;
                    $request['foto_jam_pulang'] = $foto_cuti;
                    $request['jam_absen'] = $jam_absen;
                    $request['telat'] = $telat;
                    $request['lat_absen'] = $lat_absen;
                    $request['long_absen'] = $long_absen;
                    $request['jarak_pulang'] = "0";
                    $request['foto_jam_absen'] = $foto_jam_absen;
                } else {
                    $request['status_absen'] = 'Cuti';
                }
                
                if($request["nama_cuti"] == "Cuti Dadakan") {
                    $request["cuti_dadakan"] = $request["cuti_dadakan"] - 1;
                } elseif($request["nama_cuti"] == "Cuti Bersama") {
                    $request["cuti_bersama"] = $request["cuti_bersama"] - 1;
                } elseif($request["nama_cuti"] == "Cuti Menikah") {
                    $request["cuti_menikah"] = $request["cuti_menikah"] - 1;
                } elseif($request["nama_cuti"] == "Cuti Diluar Tanggungan") {
                    $request["cuti_diluar_tanggungan"] = $request["cuti_diluar_tanggungan"] - 1;
                } elseif($request["nama_cuti"] == "Cuti Khusus") {
                    $request["cuti_khusus"] = $request["cuti_khusus"] - 1;
                } elseif($request["nama_cuti"] == "Cuti Melahirkan") {
                    $request["cuti_melahirkan"] = $request["cuti_melahirkan"] - 1;
                } elseif($request["nama_cuti"] == "Izin Telat") {
                    $request["izin_telat"] = $request["izin_telat"] - 1;
                } else {
                    $request["izin_pulang_cepat"] = $request["izin_pulang_cepat"] - 1;
                }
            } else {
                $request["cuti_dadakan"];
                $request["cuti_bersama"];
                $request["cuti_menikah"];
                $request["cuti_diluar_tanggungan"];
                $request["cuti_khusus"];
                $request["cuti_melahirkan"];
                $request["izin_telat"];
                $request["izin_pulang_cepat"];
                $request['status_absen'] = $status_absen;
                $request["jam_absen"] = $jam_absen;
                $request["telat"] = $telat;
                $request["lat_absen"] = $lat_absen;
                $request["long_absen"] = $long_absen;
                $request["jarak_masuk"] = $jarak_masuk;
                $request["foto_jam_absen"] = $foto_jam_absen;
                $request["jam_pulang"] = $jam_pulang;
                $request["pulang_cepat"] = $pulang_cepat;
                $request["lat_pulang"] = $lat_pulang;
                $request["long_pulang"] = $long_pulang;
                $request["jarak_pulang"] = $jarak_pulang;
                $request["foto_jam_pulang"] = $foto_jam_pulang;
            }
    
            $rules1 = [
                'nama_cuti' => 'required',
                'tanggal' => 'required',
                'status_cuti' => 'required',
                'catatan' => 'nullable'
            ];
    
            $rules2 = [
                'cuti_dadakan' => 'required',
                'cuti_bersama' => 'required',
                'cuti_menikah' => 'required',
                'cuti_diluar_tanggungan' => 'required',
                'cuti_khusus' => 'required',
                'cuti_melahirkan' => 'required',
                'izin_telat' => 'required',
                'izin_pulang_cepat' => 'required',
            ];
    
            $rules3 = [
                'status_absen' => 'required',
                'jam_absen' => 'nullable',
                'telat' => 'nullable',
                'lat_absen' => 'nullable',
                'long_absen' => 'nullable',
                'jarak_masuk' => 'nullable',
                'foto_jam_absen' => 'nullable',
                'jam_pulang' => 'nullable',
                'pulang_cepat' => 'nullable',
                'foto_jam_pulang' => 'nullable',
                'lat_pulang' => 'nullable',
                'long_pulang' => 'nullable',
                'jarak_pulang' => 'nullable'
            ];
    
            $validatedData = $request->validate($rules1);
            $validatedData2 = $request->validate($rules2);
            $validatedData3 = $request->validate($rules3);
    
    
            Cuti::where('id', $id)->update($validatedData);
            User::where('id', $user_id)->update($validatedData2);
            MappingShift::where('id', $mp_id)->update($validatedData3);
            
            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'edit',
                'description' => 'Mengubah data cuti dengan id ' . $id . ' oleh ' . Auth::user()->name,
                'time' => Carbon::now()
            ]);
    
            $request->session()->flash('success', 'Data Berhasil di Update');
            return redirect('/data-cuti');
        }
    }

}
