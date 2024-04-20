<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class DivisiController extends Controller
{
    public function index()
    {
        // $get = Divisi::with('Departemen')->get();
        // dd($get);
        return view('divisi.index', [
            'title' => 'Master Divisi',
            'data_divisi' => Divisi::with('Departemen')->get()
        ]);
    }

    public function create()
    {
        return view('divisi.create', [
            'title' => 'Tambah Data Divisi',
            'data_departemen' => Departemen::all(),
        ]);
    }

    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'nama_divisi' => 'required|max:255',
            'nama_departemen' => 'required',
        ]);

        Divisi::create(
            [
                'id' => Uuid::uuid4(),
                'nama_divisi' => $validatedData['nama_divisi'],
                'dept_id' => Departemen::where('id', $validatedData['nama_departemen'])->value('id'),
            ]
        );
        return redirect('/divisi')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        return view('divisi.edit', [
            'title' => 'Edit Data Divisi',
            'data_departemen' => Departemen::all(),
            'data_divisi' => Divisi::with('Departemen')->findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_divisi' => 'required|max:255',
            'nama_departemen' => 'required',
        ]);

        Divisi::where('id', $id)->update(
            [
                'nama_divisi' => $validatedData['nama_divisi'],
                'dept_id' => Departemen::where('id', $validatedData['nama_departemen'])->value('id'),
            ]
        );
        return redirect('/divisi')->with('success', 'Data Berhasil di Update');
    }

    public function delete($id)
    {
        $divisi = Divisi::findOrFail($id);
        $divisi->delete();
        return redirect('/divisi')->with('success', 'Data Berhasil di Delete');
    }
}
