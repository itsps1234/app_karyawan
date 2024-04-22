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
        $holding = request()->segment(count(request()->segments()));
        // $get = Divisi::with('Departemen')->get();
        // dd($get);
        return view('divisi.index', [
            'title' => 'Master Divisi',
            'holding' => $holding,
            'data_divisi' => Divisi::with('Departemen')->get()
        ]);
    }

    public function create()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('divisi.create', [
            'title' => 'Tambah Data Divisi',
            'holding' => $holding,
            'data_departemen' => Departemen::all(),
        ]);
    }

    public function insert(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
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
        return redirect('/divisi/' . $holding)->with('success', 'Data Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        $holding = request()->segment(count(request()->segments()));
        return view('divisi.edit', [
            'title' => 'Edit Data Divisi',
            'holding' => $holding,
            'data_departemen' => Departemen::all(),
            'data_divisi' => Divisi::with('Departemen')->findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $holding = request()->segment(count(request()->segments()));
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
        return redirect('/divisi/' . $holding)->with('success', 'Data Berhasil di Update');
    }

    public function delete($id)
    {
        $holding = request()->segment(count(request()->segments()));
        $divisi = Divisi::findOrFail($id);
        $divisi->delete();
        return redirect('/divisi/' . $holding)->with('success', 'Data Berhasil di Delete');
    }
}
