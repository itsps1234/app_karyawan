<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class DivisiController extends Controller
{
    public function index()
    {
        $holding = request()->segment(count(request()->segments()));
        // $get = Divisi::with('Departemen')->get();
        // dd($get);
        return view('admin.divisi.index', [
            'title' => 'Master Divisi',
            'holding' => $holding,
            'data_divisi' => Divisi::with('Departemen')->get(),
            'data_departemen' => Departemen::orderBy('nama_departemen', 'asc')->get()
        ]);
    }

    public function datatable(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $table =  Divisi::with('Departemen')->get();
        if (request()->ajax()) {
            return DataTables::of($table)
                ->addColumn('nama_departemen', function ($row) {
                    $nama_departemen = $row->Departemen->nama_departemen;
                    return $nama_departemen;
                })
                ->addColumn('option', function ($row) use ($holding) {
                    $btn = '<button id="btn_edit_divisi" data-id="' . $row->id . '" data-dept="' . $row->dept_id . '" data-divisi="' . $row->nama_divisi . '" data-holding="' . $holding . '" type="button" class="btn btn-icon btn-warning waves-effect waves-light"><span class="tf-icons mdi mdi-pencil-outline"></span></button>';
                    $btn = $btn . '<button type="button" id="btn_delete_divisi" data-id="' . $row->id . '" data-holding="' . $holding . '" class="btn btn-icon btn-danger waves-effect waves-light"><span class="tf-icons mdi mdi-delete-outline"></span></button>';
                    return $btn;
                })
                ->rawColumns(['nama_departemen', 'option'])
                ->make(true);
        }
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

    public function update(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_divisi_update' => 'required|max:255',
            'nama_departemen_update' => 'required',
        ]);

        Divisi::where('id', $request->id_divisi)->update(
            [
                'nama_divisi' => $validatedData['nama_divisi_update'],
                'dept_id' => Departemen::where('id', $validatedData['nama_departemen_update'])->value('id'),
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
