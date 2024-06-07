<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\Departemen;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class BagianController extends Controller
{
    public function index()
    {
        $holding = request()->segment(count(request()->segments()));
        // $get = Bagian::with('Divisi')->get();
        // dd($get);
        return view('admin.bagian.index', [
            'title' => 'Master Divisi',
            'holding' => $holding,
            'data_bagian' => Bagian::with('Divisi')->get(),
            'data_dept' => Departemen::orderBy('nama_departemen', 'asc')->get(),
            'data_divisi' => Divisi::orderBy('nama_divisi', 'asc')->get()
        ]);
    }
    public function get_divisi($id)
    {
        // dd($id);
        $get_divisi = Divisi::where('dept_id', $id)->get();
        // dd($get_divisi);
        echo "<option value=''>Pilih Divisi...</option>";
        foreach ($get_divisi as $divisi) {
            echo "<option value='$divisi->id'>$divisi->nama_divisi</option>";
        }
    }
    public function datatable(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $table =  Bagian::with([
            'Divisi' =>  function ($query) {
                $query->with('Departemen');
            },
        ])->get();
        if (request()->ajax()) {
            return DataTables::of($table)
                ->addColumn('nama_departemen', function ($row) {
                    $nama_departemen = $row->Divisi->Departemen->nama_departemen;
                    return $nama_departemen;
                })
                ->addColumn('nama_divisi', function ($row) {
                    $nama_divisi = $row->Divisi->nama_divisi;
                    return $nama_divisi;
                })
                ->addColumn('option', function ($row) use ($holding) {
                    $btn = '<button id="btn_edit_bagian" data-id="' . $row->id . '" data-dept="' . $row->Divisi->Departemen->id . '" data-divisi="' . $row->divisi_id . '" data-bagian="' . $row->nama_bagian . '" data-holding="' . $holding . '" type="button" class="btn btn-icon btn-warning waves-effect waves-light"><span class="tf-icons mdi mdi-pencil-outline"></span></button>';
                    $btn = $btn . '<button type="button" id="btn_delete_bagian" data-id="' . $row->id . '" data-holding="' . $holding . '" class="btn btn-icon btn-danger waves-effect waves-light"><span class="tf-icons mdi mdi-delete-outline"></span></button>';
                    return $btn;
                })
                ->rawColumns(['nama_departemen', 'nama_divisi', 'option'])
                ->make(true);
        }
    }
    public function create()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('bagian.create', [
            'title' => 'Tambah Data Divisi',
            'holding' => $holding,
            'data_divisi' => Divisi::all(),
        ]);
    }

    public function insert(Request $request)
    {
        // dd($request->all());
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_divisi' => 'required|max:255',
            'nama_bagian' => 'required',
        ]);

        Bagian::create(
            [
                'id' => Uuid::uuid4(),
                'nama_bagian' => $validatedData['nama_bagian'],
                'divisi_id' => Divisi::where('id', $validatedData['nama_divisi'])->value('id'),
            ]
        );
        return redirect('/bagian/' . $holding)->with('success', 'Data Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        $holding = request()->segment(count(request()->segments()));
        return view('bagian.edit', [
            'title' => 'Edit Data Divisi',
            'holding' => $holding,
            'data_divisi' => Divisi::all(),
            'data_bagian' => Bagian::with('Divisi')->findOrFail($id)
        ]);
    }

    public function update(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_divisi_update' => 'required|max:255',
            'nama_bagian_update' => 'required',
        ]);

        Bagian::where('id', $request->id_bagian)->update(
            [
                'nama_bagian' => $validatedData['nama_bagian_update'],
                'divisi_id' => Divisi::where('id', $validatedData['nama_divisi_update'])->value('id'),
            ]
        );
        return redirect('/bagian/' . $holding)->with('success', 'Data Berhasil di Update');
    }

    public function delete($id)
    {
        $holding = request()->segment(count(request()->segments()));
        $divisi = Bagian::findOrFail($id);
        $divisi->delete();
        return redirect('/bagian/' . $holding)->with('success', 'Data Berhasil di Delete');
    }
}
