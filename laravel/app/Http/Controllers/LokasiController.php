<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class LokasiController extends Controller
{
    public function index()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('lokasi.index', [
            'title' => 'Setting Lokasi Kantor',
            'holding' => $holding,
            'lokasi' => Lokasi::first()
        ]);
    }

    public function updateLokasi(Request $request, $id)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'lat_kantor' => 'required',
            'long_kantor' => 'required'
        ]);

        Lokasi::where('id', $id)->update($validatedData);
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'update',
            'description' => 'Mengubah data lokasi kantor'
        ]);
        return redirect('/lokasi-kantor/' . $holding)->with('success', 'Lokasi Berhasil Diupdate');
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
