<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\LevelJabatan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class jabatanController extends Controller
{
    public function index()
    {
        $holding = request()->segment(count(request()->segments()));
        // $get = Jabatan::with('Divisi')->with('LevelJabatan')->get();
        // dd($get);
        return view('jabatan.index', [
            'title' => 'Master Jabatan',
            'holding' => $holding,
            'data_jabatan' => Jabatan::with('Divisi')->with('LevelJabatan')->get()
        ]);
    }

    public function create()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('jabatan.create', [
            'title' => 'Tambah Data Jabatan',
            'holding' => $holding,
            'get_divisi' => Divisi::get(),
            'get_level' => LevelJabatan::orderBy('level_jabatan', 'ASC')->get(),
        ]);
    }

    public function insert(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_divisi' => 'required',
            'nama_jabatan' => 'required|max:255',
            'level_jabatan' => 'required',
        ]);

        Jabatan::create(
            [
                'divisi_id' => Divisi::where('id', $validatedData['nama_divisi'])->value('id'),
                'nama_jabatan' => $validatedData['nama_jabatan'],
                'level_id' => LevelJabatan::where('id', $validatedData['level_jabatan'])->value('id'),
            ]
        );
        return redirect('/jabatan/' . $holding)->with('success', 'Data Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        $holding = request()->segment(count(request()->segments()));
        return view('jabatan.edit', [
            'title' => 'Edit Data Jabatan',
            'get_divisi' => Divisi::get(),
            'holding' => $holding,
            'get_level' => LevelJabatan::get(),
            'data_jabatan' => Jabatan::with('Divisi')->with('LevelJabatan')->findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_divisi' => 'required',
            'nama_jabatan' => 'required|max:255',
            'level_jabatan' => 'required',
        ]);

        Jabatan::where('id', $id)->update(
            [
                'divisi_id' => Divisi::where('id', $validatedData['nama_divisi'])->value('id'),
                'nama_jabatan' => $validatedData['nama_jabatan'],
                'level_id' => LevelJabatan::where('id', $validatedData['level_jabatan'])->value('id'),
            ]
        );
        return redirect('/jabatan/' . $holding)->with('success', 'Data Berhasil di Update');
    }

    public function delete($id)
    {
        $holding = request()->segment(count(request()->segments()));
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();
        return redirect('/jabatan/' . $holding)->with('success', 'Data Berhasil di Delete');
    }
}
