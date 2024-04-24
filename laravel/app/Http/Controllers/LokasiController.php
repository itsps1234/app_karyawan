<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class LokasiController extends Controller
{
    public function index()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('lokasi.index', [
            'title' => 'Setting Lokasi Kantor',
            'holding' => $holding,
            'lokasi' => Lokasi::get(),
            'data_lokasi' => Lokasi::all()
        ]);
    }

    public function addLokasi(Request $request)
    {
        // dd($request->all());
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'lokasi_kantor' => 'required',
            'lat_kantor' => 'required',
            'long_kantor' => 'required',
            'radius' => 'required'
        ]);

        Lokasi::insert(
            [
                'kode_kantor' => Uuid::uuid4(),
                'lokasi_kantor' => $validatedData['lokasi_kantor'],
                'lat_kantor' => $validatedData['lat_kantor'],
                'long_kantor' => $validatedData['long_kantor'],
                'radius' => $validatedData['radius'],
            ]
        );
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'Tambah',
            'description' => 'Menambah data lokasi kantor'
        ]);
        return redirect('/lokasi-kantor/' . $holding)->with('success', 'Lokasi Berhasil Ditambahkan');
    }
    public function updateLokasi(Request $request)
    {
        // dd($request->all());
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'lokasi_kantor' => 'required',
            'lat_kantor' => 'required',
            'long_kantor' => 'required',
            'radius' => 'required'
        ]);

        Lokasi::where('id', $request->id_lokasi)->update($validatedData);
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'update',
            'description' => 'Mengubah data lokasi kantor'
        ]);
        return redirect('/lokasi-kantor/' . $holding)->with('success', 'Lokasi Berhasil Diupdate');
    }

    public function deleteLokasi($id)
    {
        $query = Lokasi::where('id', $id)->delete();
        return json_encode($query);
    }
    public function updateRadiusLokasi(Request $request, $id)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'radius' => 'required',
        ]);

        Lokasi::where('id', $id)->update($validatedData);
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'update',
            'description' => 'Mengubah data radius lokasi kantor'
        ]);
        return redirect('/lokasi-kantor/' . $holding)->with('success', 'Lokasi Berhasil Diupdate');
    }
}
