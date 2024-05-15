<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class DepartemenController extends Controller
{
    public function index()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('admin.departemen.index', [
            'title' => 'Master Departemen',
            'holding' => $holding,
            'data_departemen' => Departemen::all()
        ]);
    }
    public function datatable(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $table = Departemen::all();
        if (request()->ajax()) {
            return DataTables::of($table)
                ->addColumn('option', function ($row) use ($holding) {
                    $btn = '<button id="btn_edit_dept" data-id="' . $row->id . '" data-dept="' . $row->nama_departemen . '" data-holding="' . $holding . '" type="button" class="btn btn-icon btn-warning waves-effect waves-light"><span class="tf-icons mdi mdi-pencil-outline"></span></button>';
                    $btn = $btn . '<button type="button" id="btn_delete_dept" data-id="' . $row->id . '" data-holding="' . $holding . '" class="btn btn-icon btn-danger waves-effect waves-light"><span class="tf-icons mdi mdi-delete-outline"></span></button>';
                    return $btn;
                })
                ->rawColumns(['option'])
                ->make(true);
        }
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

    public function update(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_departemen_update' => 'required|max:255',
        ]);

        Departemen::where('id', $request->id_departemen)->update([
            'nama_departemen' => $validatedData['nama_departemen_update'],
        ]);
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
