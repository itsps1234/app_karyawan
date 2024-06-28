<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $holding = request()->segment(count(request()->segments()));
        if ($holding == 'sp') {
            $kontrak = 'SP';
        } else if ($holding == 'sps') {
            $kontrak = 'SPS';
        } else {
            $kontrak = 'SIP';
        }

        $user = User::join('jabatans', 'jabatans.id', 'users.jabatan_id')
            ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
            ->join('level_jabatans', 'level_jabatans.id', '=', 'jabatans.level_id')
            ->join('departemens', 'departemens.id', '=', 'users.dept_id')
            ->join('bagians', 'bagians.id', '=', 'users.bagian_id')
            ->where('kategori', 'Karyawan Bulanan')
            ->whereNotNull('users.bagian_id')
            ->where('kontrak_kerja', $kontrak)
            ->where('is_admin', 'user')
            ->select('users.*', 'users.foto_karyawan', 'bagians.nama_bagian', 'jabatans.nama_jabatan', 'divisis.nama_divisi', 'level_jabatans.level_jabatan')
            ->get();
        // dd(count($user));
        if (count($user) == 0) {
            // dd('ok');
            $user_struktur = $user;
        } else {
            foreach ($user as $user) {
                $user_cek = User::join('jabatans', 'jabatans.id', 'users.jabatan_id')
                    ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                    ->join('level_jabatans', 'level_jabatans.id', '=', 'jabatans.level_id')
                    ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                    ->join('bagians', 'bagians.id', '=', 'users.bagian_id')
                    ->where('kategori', 'Karyawan Bulanan')
                    ->whereNotNull('users.bagian_id')
                    ->where('kontrak_kerja', $kontrak)
                    ->where('is_admin', 'user')
                    ->where('users.id', $user['atasan_1'])
                    ->first();
                if ($user['foto_karyawan'] == NULL || $user['foto_karyawan'] == '') {
                    $user['foto_karyawan'] = 'https://karyawan.sumberpangan.store/public/admin/assets/img/avatars/1.png';
                } else {
                    $user['foto_karyawan'] = "https://karyawan.sumberpangan.store/laravel/storage/app/public/foto_karyawan/" . $user['foto_karyawan'];
                }
                if ($user['nama_bagian'] == NULL || $user['nama_bagian'] == '') {
                    $user['nama_bagian'] = NULL;
                } else {
                    $user['nama_bagian'] = "(" . $user['nama_bagian'] . ")";
                }
                if ($user_cek == NULL || $user_cek == '') {
                    $user_cek = $user['atasan_2'];
                } else {
                    $user_cek = $user['atasan_1'];
                }
                $user_struktur[] = array('id' => $user['id'], 'name' => $user['name'], 'foto' => $user['foto_karyawan'], 'jabatan' => $user['nama_jabatan'] . ' ' . $user['nama_bagian'], 'pid' => $user_cek);
            }
        }

        // dd(json_encode($level1));
        // dd($user_struktur);
        // dd(json_encode($user_struktur));
        return view('admin.struktur_organisasi.index', [
            'holding' => $holding,
            'user' => $user_struktur
        ]);
    }
}
