<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class DepartemenController extends Controller
{
    public function index()
    {
        return view('departemen.index', [
            'title' => 'Master Departemen',
            'data_departemen' => Departemen::all()
        ]);
    }

    public function create()
    {
        return view('departemen.create', [
            'title' => 'Tambah Data Departemen'
        ]);
    }

    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'nama_departemen' => 'required|max:255',
        ]);

        Departemen::create(
            [
                'id' => Uuid::uuid4(),
                'nama_departemen' => $validatedData['nama_departemen'],
            ]
        );
        return redirect('/departemen')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        return view('departemen.edit', [
            'title' => 'Edit Data Departemen',
            'data_departemen' => Departemen::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_departemen' => 'required|max:255',
        ]);

        Departemen::where('id', $id)->update($validatedData);
        return redirect('/departemen')->with('success', 'Data Berhasil di Update');
    }

    public function delete($id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();
        return redirect('/departemen')->with('success', 'Data Berhasil di Delete');
    }
}
