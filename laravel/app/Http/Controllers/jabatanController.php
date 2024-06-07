<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\LevelJabatan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class jabatanController extends Controller
{
    public function index()
    {
        $holding = request()->segment(count(request()->segments()));
        // $get = Jabatan::with('Bagian')->with('LevelJabatan')->get();
        // dd($get);
        return view('admin.jabatan.index', [
            'title' => 'Master Jabatan',
            'holding' => $holding,
            'data_jabatan' => Jabatan::with('Bagian')->with('LevelJabatan')->get(),
            'data_divisi' => Divisi::get(),
            'data_bagian' => Bagian::get(),
            'get_level' => LevelJabatan::orderBy('level_jabatan', 'ASC')->get()
        ]);
    }
    public function datatable(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $table =  Jabatan::with(['Bagian' => function ($query) {
            $query->with([
                'Divisi' => function ($query) {
                    $query->with('Departemen');
                },
            ]);
        },])->with('LevelJabatan')->get();
        if (request()->ajax()) {
            return DataTables::of($table)

                ->addColumn('nama_divisi', function ($row) {
                    if ($row->Bagian == NULL) {
                        $nama_divisi = NULL;
                    } else {
                        if ($row->Bagian->Divisi == NULL) {
                            $nama_divisi = NULL;
                        } else {
                            $nama_divisi = $row->Bagian->Divisi->nama_divisi;
                        }
                    }
                    return $nama_divisi;
                })
                ->addColumn('nama_bagian', function ($row) {
                    if ($row->Bagian == NULL) {
                        $nama_bagian = NULL;
                    } else {
                        $nama_bagian = $row->Bagian->nama_bagian;
                        return $nama_bagian;
                    }
                })
                ->addColumn('level_jabatan', function ($row) {
                    $level_jabatan = $row->LevelJabatan->level_jabatan;
                    return $level_jabatan;
                })
                ->addColumn('option', function ($row) use ($holding) {
                    $btn = '<button id="btn_edit_jabatan" data-id="' . $row->id . '" data-jabatan="' . $row->nama_jabatan . '" data-divisi="' . $row->Divisi->id . '" data-bagian="' . $row->bagian_id . '" data-level="' . $row->level_id . '" data-holding="' . $holding . '" type="button" class="btn btn-icon btn-warning waves-effect waves-light"><span class="tf-icons mdi mdi-pencil-outline"></span></button>';
                    $btn = $btn . '<button type="button" id="btn_delete_jabatan" data-id="' . $row->id . '" data-holding="' . $holding . '" class="btn btn-icon btn-danger waves-effect waves-light"><span class="tf-icons mdi mdi-delete-outline"></span></button>';
                    return $btn;
                })
                ->rawColumns(['nama_divisi', 'nama_bagian', 'level_jabatan', 'option'])
                ->make(true);
        }
    }
    public function get_bagian($id)
    {
        // dd($id);
        $get_bagian = Bagian::where('divisi_id', $id)->get();
        // dd($get_bagian);
        echo "<option value=''>Pilih Bagian...</option>";
        foreach ($get_bagian as $bagian) {
            echo "<option value='$bagian->id'>$bagian->nama_bagian</option>";
        }
    }
    public function create()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('jabatan.create', [
            'title' => 'Tambah Data Jabatan',
            'holding' => $holding,
            'get_bagian' => Bagian::get(),
            'get_level' => LevelJabatan::orderBy('level_jabatan', 'ASC')->get(),
        ]);
    }

    public function insert(Request $request)
    {
        // dd($request->all());
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_divisi' => 'required',
            'nama_bagian' => 'required',
            'nama_jabatan' => 'required|max:255',
            'level_jabatan' => 'required',
        ]);

        Jabatan::create(
            [
                'divisi_id' => Divisi::where('id', $validatedData['nama_divisi'])->value('id'),
                'bagian_id' => Bagian::where('id', $validatedData['nama_bagian'])->value('id'),
                'nama_jabatan' => $validatedData['nama_jabatan'],
                'level_id' => LevelJabatan::where('level_jabatan', $validatedData['level_jabatan'])->value('id'),
            ]
        );
        return redirect('/jabatan/' . $holding)->with('success', 'Data Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        $holding = request()->segment(count(request()->segments()));
        return view('jabatan.edit', [
            'title' => 'Edit Data Jabatan',
            'get_bagian' => Bagian::get(),
            'holding' => $holding,
            'get_level' => LevelJabatan::get(),
            'data_jabatan' => Jabatan::with('Bagian')->with('LevelJabatan')->findOrFail($id)
        ]);
    }

    public function update(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_bagian_update' => 'required',
            'nama_jabatan_update' => 'required|max:255',
            'level_jabatan_update' => 'required',
        ]);

        Jabatan::where('id', $request->id_jabatan)->update(
            [
                'bagian_id' => Bagian::where('id', $validatedData['nama_bagian_update'])->value('id'),
                'nama_jabatan' => $validatedData['nama_jabatan_update'],
                'level_id' => LevelJabatan::where('id', $validatedData['level_jabatan_update'])->value('id'),
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
