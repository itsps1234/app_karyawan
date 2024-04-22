<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class DepartemenController extends Controller
{
    public function index()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('departemen.index', [
            'title' => 'Master Departemen',
            'holding' => $holding,
            'data_departemen' => Departemen::all()
        ]);
    }

    public function create()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('departemen.create', [
            'holding' => $holding,
            'title' => 'Tambah Data Departemen'
        ]);
    }

    public function insert(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_departemen' => 'required|max:255',
        ]);

        Departemen::create(
            [
                'id' => Uuid::uuid4(),
                'nama_departemen' => $validatedData['nama_departemen'],
            ]
        );
        return redirect('/departemen/' . $holding)->with('success', 'Data Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        $holding = request()->segment(count(request()->segments()));
        return view('departemen.edit', [
            'title' => 'Edit Data Departemen',
            'holding' => $holding,
            'data_departemen' => Departemen::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_departemen' => 'required|max:255',
        ]);

        Departemen::where('id', $id)->update($validatedData);
        return redirect('/departemen/' . $holding)->with('success', 'Data Berhasil di Update');
    }

    public function delete($id)
    {
        $holding = request()->segment(count(request()->segments()));
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();
        return redirect('/departemen/' . $holding)->with('success', 'Data Berhasil di Delete');
    }
}
