<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('shift.index', [
            'title' => 'Master Shift',
            'holding' => $holding,
            'shift' => Shift::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $holding = request()->segment(count(request()->segments()));
        return view('shift.create', [
            'title' => 'Tambah Data Master Shift',
            'holding' => $holding,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_shift' => 'required|max:255',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required'
        ]);

        Shift::create($validatedData);
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'create',
            'description' => 'Menambahkan data master shift dengan nama shift ' . $request->nama_shift
        ]);
        return redirect('/shift/' . $holding)->with('success', 'Data Berhasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $holding = request()->segment(count(request()->segments()));
        return view("shift.edit", [
            'title' => 'Edit Shift',
            'holding' => $holding,
            'shift' => Shift::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $holding = request()->segment(count(request()->segments()));
        $validatedData = $request->validate([
            'nama_shift' => 'required|max:255',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required'
        ]);

        Shift::where('id', $id)->update($validatedData);
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'update',
            'description' => 'Mengubah data master shift dengan nama shift ' . $request->nama_shift
        ]);
        return redirect('/shift/' . $holding)->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $holding = request()->segment(count(request()->segments()));
        $delete = Shift::find($id);
        $delete->delete();
        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'delete',
            'description' => 'Menghapus data master shift dengan nama shift ' . $delete->nama_shift
        ]);
        return redirect('/shift/' . $holding)->with('success', 'Data Berhasil di Delete');
    }
}
