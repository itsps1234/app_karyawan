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

        $kontrak = 'SP';
        // syncfusion
        $jabatan = Jabatan::with(['User' => function ($query) {;
            $query->select('jabatan_id', 'users.name');
        }])->with(['User1' => function ($query) {
            $query->select('jabatan1_id', 'users.name');
        }])->with(['User2' => function ($query) {
            $query->select('jabatan2_id', 'users.name');
        }])->with(['User3' => function ($query) {
            $query->select('jabatan3_id', 'users.name');
        }])->with(['User4' => function ($query) {
            $query->select('jabatan4_id', 'users.name');
        }])
            ->join('divisis', 'divisis.id', '=', 'jabatans.divisi_id')
            ->join('level_jabatans', 'level_jabatans.id', '=', 'jabatans.level_id')
            ->join('departemens', 'departemens.id', '=', 'divisis.dept_id')
            ->join('bagians', 'bagians.id', '=', 'jabatans.bagian_id')
            ->where('jabatans.holding', 'sp')
            ->orderBy('jabatans.nama_jabatan', 'ASC')
            ->select('bagians.nama_bagian', 'jabatans.id', 'jabatans.atasan_id', 'jabatans.nama_jabatan', 'divisis.nama_divisi', 'level_jabatans.level_jabatan')
            // ->take('10')
            ->get();
        // dd($jabatan->User->toArray());
        if (count($jabatan) == 0) {
            $jabatan_struktur = NULL;
        } else {
            foreach ($jabatan as $jabatan) {
                $ok = $jabatan->User->toArray();
                $ok1 = $jabatan->User1->toArray();
                $ok2 = $jabatan->User2->toArray();
                $ok3 = $jabatan->User3->toArray();
                $ok4 = $jabatan->User4->toArray();
                // $get_jabatan_sps = Jabatan::where('nama_jabatan', $jabatan->nama_jabatan)->where('holding', 'sps')->first();
                // $user_sps = User::where('jabatan_id', $get_jabatan_sps)->value('name');
                // $userssps[] = array($user_sps);
                if ($ok == []) {
                    $user_name = NULL;
                } else {
                    $user_name = str_replace('[{"jabatan_id":"' . $jabatan->id . '",', '', json_encode($ok));
                    $user_name = str_replace('{"jabatan_id":"' . $jabatan->id . '",', '', $user_name);
                    $user_name = str_replace('"', '', $user_name);
                    $user_name = str_replace('}', '', $user_name);
                    $user_name = str_replace(']', '', $user_name);
                    $user_name = str_replace('name:', ' ', $user_name);
                    $user_name = str_replace(' ', '&nbsp;', $user_name);
                    $user_name = str_replace(',', ',<br>', $user_name);
                }
                if ($ok1 == []) {
                    $user_name1 = NULL;
                } else {
                    $user_name1 = str_replace('[{"jabatan1_id":"' . $jabatan->id . '",', '', json_encode($ok1));
                    $user_name1 = str_replace('{"jabatan1_id":"' . $jabatan->id . '",', '', $user_name1);
                    $user_name1 = str_replace('"', '', $user_name1);
                    $user_name1 = str_replace('}', '', $user_name1);
                    $user_name1 = str_replace(']', '', $user_name1);
                    $user_name1 = str_replace('name:', ' ', $user_name1);
                    $user_name1 = str_replace(' ', '&nbsp;', $user_name1);
                    $user_name1 = str_replace(',', ',<br>', $user_name1);
                }
                if ($ok2 == []) {
                    $user_name2 = NULL;
                } else {
                    $user_name2 = str_replace('[{"jabatan2_id":"' . $jabatan->id . '",', '', json_encode($ok2));
                    $user_name2 = str_replace('{"jabatan2_id":"' . $jabatan->id . '",', '', $user_name2);
                    $user_name2 = str_replace('"', '', $user_name2);
                    $user_name2 = str_replace('}', '', $user_name2);
                    $user_name2 = str_replace(']', '', $user_name2);
                    $user_name2 = str_replace('name:', ' ', $user_name2);
                    $user_name2 = str_replace(' ', '&nbsp;', $user_name2);
                    $user_name2 = str_replace(',', ',<br>', $user_name2);
                }
                if ($ok3 == []) {
                    $user_name3 = NULL;
                } else {
                    $user_name3 = str_replace('[{"jabatan2_id":"' . $jabatan->id . '",', '', json_encode($ok3));
                    $user_name3 = str_replace('{"jabatan2_id":"' . $jabatan->id . '",', '', $user_name3);
                    $user_name3 = str_replace('"', '', $user_name3);
                    $user_name3 = str_replace('}', '', $user_name3);
                    $user_name3 = str_replace(']', '', $user_name3);
                    $user_name3 = str_replace('name:', ' ', $user_name3);
                    $user_name3 = str_replace(' ', '&nbsp;', $user_name3);
                    $user_name3 = str_replace(',', ',<br>', $user_name3);
                }
                if ($ok4 == []) {
                    $user_name4 = NULL;
                } else {
                    $user_name4 = str_replace('[{"jabatan2_id":"' . $jabatan->id . '",', '', json_encode($ok4));
                    $user_name4 = str_replace('{"jabatan2_id":"' . $jabatan->id . '",', '', $user_name4);
                    $user_name4 = str_replace('"', '', $user_name4);
                    $user_name4 = str_replace('}', '', $user_name4);
                    $user_name4 = str_replace(']', '', $user_name4);
                    $user_name4 = str_replace('name:', ' ', $user_name4);
                    $user_name4 = str_replace(' ', '&nbsp;', $user_name4);
                    $user_name4 = str_replace(',', ',<br>', $user_name4);
                }
                $foto = '<img width=30 height=30 style="border-radius: 50%;" align=center margin_bottom=4 margin_top=4 src=https://karyawan.sumberpangan.store/public/admin/assets/img/avatars/1.png><br>';
                $jabatan_struktur[] = array('x' => $jabatan['nama_jabatan'] . ' (' . $jabatan['nama_bagian'] . ')', 'id' => str_replace("-", "", $jabatan['id']), 'parent' => str_replace("-", "", $jabatan['atasan_id']), 'attributes' => array('role' => $user_name  . $user_name1 . $user_name2 . $user_name3 . $user_name4, 'photo' => $foto));
            }
        }
        // dd($userssps);
        // dd($user_name1);
        $jabatan1 = Jabatan::with(['User' => function ($query) {
            $query->where('penempatan_kerja', 'PT. SURYA PANGAN SEMESTA - NGAWI');
            $query->orWhere('penempatan_kerja', 'PT. SURYA PANGAN SEMESTA - SUBANG');
            $query->orWhere('penempatan_kerja', 'ALL SITES (SP, SPS, SIP)');
            $query->orWhere('penempatan_kerja', 'ALL SITES (SPS)');
            $query->orWhere('penempatan_kerja', 'DEPO SPS SIDOARJO');
            $query->select('jabatan_id', 'name');
        }])->join('divisis', 'divisis.id', '=', 'jabatans.divisi_id')
            ->join('level_jabatans', 'level_jabatans.id', '=', 'jabatans.level_id')
            ->join('departemens', 'departemens.id', '=', 'divisis.dept_id')
            ->join('bagians', 'bagians.id', '=', 'jabatans.bagian_id')
            ->where('jabatans.holding', 'sps')
            ->orderBy('level_jabatans.level_jabatan', 'ASC')
            ->select('bagians.nama_bagian', 'jabatans.id', 'jabatans.atasan_id', 'jabatans.nama_jabatan', 'divisis.nama_divisi', 'level_jabatans.level_jabatan')
            // ->take('10')
            ->get();
        // dd($jabatan);
        // dd($jabatan);
        if (count($jabatan1) == 0) {
            $jabatan_struktur1 = NULL;
        } else {
            foreach ($jabatan1 as $jabatan) {
                $ok = $jabatan->User->toArray();
                if ($ok == []) {
                    $user_name = NULL;
                } else {
                    $user_name = str_replace('[{"jabatan_id":"' . $jabatan->id . '",', '', json_encode($ok));
                    $user_name = str_replace('{"jabatan_id":"' . $jabatan->id . '",', '', $user_name);
                    $user_name = str_replace('"', '', $user_name);
                    $user_name = str_replace('}', '', $user_name);
                    $user_name = str_replace(']', '', $user_name);
                    $user_name = str_replace('name:', ' ', $user_name);
                    $user_name = str_replace(' ', '&nbsp;', $user_name);
                    $user_name = str_replace(',', ',<br>', $user_name);
                }
                $foto = '<img width=30 height=30 style="border-radius: 50%;" align=center margin_bottom=4 margin_top=4 src=https://karyawan.sumberpangan.store/public/admin/assets/img/avatars/1.png><br>';
                $jabatan_struktur1[] = array('x' => $jabatan['nama_jabatan'] . ' (' . $jabatan['nama_bagian'] . ')', 'id' => str_replace("-", "", $jabatan['id']), 'parent' => str_replace("-", "", $jabatan['atasan_id']), 'attributes' => array('role' => $user_name, 'photo' => $foto));
            }
        }
        // dd($jabatan_struktur);
        $jabatan2 = Jabatan::with(['User' => function ($query) {
            $query->where('penempatan_kerja', 'CV. SURYA INTI PANGAN - MAKASAR');
            $query->orWhere('penempatan_kerja', 'ALL SITES (SP, SPS, SIP)');
            $query->orWhere('penempatan_kerja', 'ALL SITES (SIP)');
            $query->select('jabatan_id', 'users.name');
        }])->join('divisis', 'divisis.id', '=', 'jabatans.divisi_id')
            ->join('level_jabatans', 'level_jabatans.id', '=', 'jabatans.level_id')
            ->join('departemens', 'departemens.id', '=', 'divisis.dept_id')
            ->join('bagians', 'bagians.id', '=', 'jabatans.bagian_id')
            ->where('jabatans.holding', 'sip')
            ->orderBy('level_jabatans.level_jabatan', 'ASC')
            ->select('bagians.nama_bagian', 'jabatans.id', 'jabatans.atasan_id', 'jabatans.nama_jabatan', 'divisis.nama_divisi', 'level_jabatans.level_jabatan')
            // ->take('10')
            ->get();
        // dd($jabatan2);
        // dd($jabatan);
        if (count($jabatan2) == 0) {
            $jabatan_struktur2 = NULL;
        } else {
            foreach ($jabatan2 as $jabatan) {
                $ok = $jabatan->User->toArray();
                if ($ok == []) {
                    $user_name = NULL;
                } else {
                    $user_name = str_replace('[{"jabatan_id":"' . $jabatan->id . '",', '', json_encode($ok));
                    $user_name = str_replace('{"jabatan_id":"' . $jabatan->id . '",', '', $user_name);
                    $user_name = str_replace('"', '', $user_name);
                    $user_name = str_replace('}', '', $user_name);
                    $user_name = str_replace(']', '', $user_name);
                    $user_name = str_replace('name:', ' ', $user_name);
                    $user_name = str_replace(' ', '&nbsp;', $user_name);
                    $user_name = str_replace(',', ',<br>', $user_name);
                }
                $foto = '<img width=30 height=30 style="border-radius: 50%;" align=center margin_bottom=4 margin_top=4 src=https://karyawan.sumberpangan.store/public/admin/assets/img/avatars/1.png><br>';
                $jabatan_struktur2[] = array('x' => $jabatan['nama_jabatan'] . ' (' . $jabatan['nama_bagian'] . ')', 'id' => str_replace("-", "", $jabatan['id']), 'parent' => str_replace("-", "", $jabatan['atasan_id']), 'attributes' => array('role' => $user_name, 'photo' => $foto));
            }
        }
        return view('admin.struktur_organisasi.index', [
            'holding' => $holding,
            'user' => $jabatan_struktur,
            'user1' => $jabatan_struktur1,
            'user2' => $jabatan_struktur2,
            'user_node' => $jabatan_struktur
        ]);
    }
    public function index1()
    {
        $holding = request()->segment(count(request()->segments()));
        if ($holding == 'sp') {
            $kontrak = 'SP';
            // syncfusion
            $user = User::join('jabatans', 'jabatans.id', 'users.jabatan_id')
                ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                ->join('level_jabatans', 'level_jabatans.id', '=', 'jabatans.level_id')
                ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                ->join('bagians', 'bagians.id', '=', 'users.bagian_id')
                ->where('users.kategori', 'Karyawan Bulanan')
                ->whereNotNull('users.bagian_id')
                ->where('users.penempatan_kerja', 'CV. SUMBER PANGAN - KEDIRI')
                // ->where('divisis.nama_divisi', 'PRODUCTION')
                ->orWhere('users.penempatan_kerja', 'CV. SUMBER PANGAN - TUBAN')
                ->orWhere('users.penempatan_kerja', 'ALL SITES (SP, SPS, SIP)')
                ->orWhere('users.penempatan_kerja', 'DEPO SPS SIDOARJO')
                // ->where('penempatan_kerja', 'ALL SITES (SP, SPS, SIP)')
                // ->orWhere('users.penempatan_kerja', 'ALL SITES (SP)')
                // ->where('departemens.nama_departemen', 'PENGEMBANGAN TEKNOLOGI & SISTEM INFORMASI')
                ->where('users.is_admin', 'user')
                ->orderBy('level_jabatans.level_jabatan', 'ASC')
                ->select('users.*', 'bagians.nama_bagian', 'jabatans.id as id_jabatan', 'jabatans.nama_jabatan', 'divisis.nama_divisi', 'level_jabatans.level_jabatan')
                // ->select('users.id', 'users.name')
                // ->limit(1)
                ->get();
            // dd(json_encode($user));
            foreach ($user as $user) {
                $user_struktur[] = array('x' => $user['name'], 'id' => str_replace("-", "", $user['id']), 'parent' => str_replace("-", "", $user['atasan_1']), 'attributes' => array('role' => $user['nama_jabatan'] . ' (' . $user['nama_bagian'] . ')', 'photo' => ''));
            }
        } else if ($holding == 'sps') {
            $user = User::join('jabatans', 'jabatans.id', 'users.jabatan_id')
                ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                ->join('level_jabatans', 'level_jabatans.id', '=', 'jabatans.level_id')
                ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                ->join('bagians', 'bagians.id', '=', 'users.bagian_id')
                ->where('users.kategori', 'Karyawan Bulanan')
                ->whereNotNull('users.bagian_id')
                ->where('users.penempatan_kerja', 'PT. SURYA PANGAN SEMESTA - KEDIRI')
                // ->where('divisis.nama_divisi', 'PRODUCTION')
                ->orWhere('users.penempatan_kerja', 'PT. SURYA PANGAN SEMESTA - NGAWI')
                ->orWhere('users.penempatan_kerja', 'PT. SURYA PANGAN SEMESTA - SUBANG')
                ->orWhere('users.penempatan_kerja', 'ALL SITES (SP, SPS, SIP)')
                ->orWhere('users.penempatan_kerja', 'DEPO SPS SIDOARJO')
                // ->where('penempatan_kerja', 'ALL SITES (SP, SPS, SIP)')
                // ->orWhere('users.penempatan_kerja', 'ALL SITES (SP)')
                // ->where('departemens.nama_departemen', 'PENGEMBANGAN TEKNOLOGI & SISTEM INFORMASI')
                ->where('users.is_admin', 'user')
                ->orderBy('level_jabatans.level_jabatan', 'ASC')
                ->select('users.*', 'bagians.nama_bagian', 'jabatans.id as id_jabatan', 'jabatans.nama_jabatan', 'divisis.nama_divisi', 'level_jabatans.level_jabatan')
                // ->select('users.id', 'users.name')
                // ->limit(1)
                ->get();
            // dd(json_encode($user));
            foreach ($user as $user) {
                $user_struktur1[] = array('x' => $user['name'], 'id' => str_replace("-", "", $user['id']), 'parent' => str_replace("-", "", $user['atasan_1']), 'attributes' => array('role' => $user['nama_jabatan'] . ' (' . $user['nama_bagian'] . ')', 'photo' => ''));
            }
        } else {
            $user = User::join('jabatans', 'jabatans.id', 'users.jabatan_id')
                ->join('divisis', 'divisis.id', '=', 'users.divisi_id')
                ->join('level_jabatans', 'level_jabatans.id', '=', 'jabatans.level_id')
                ->join('departemens', 'departemens.id', '=', 'users.dept_id')
                ->join('bagians', 'bagians.id', '=', 'users.bagian_id')
                ->where('users.kategori', 'Karyawan Bulanan')
                ->whereNotNull('users.bagian_id')
                ->where('users.penempatan_kerja', 'CV. SURYA INTI PANGAN - MAKASAR')
                ->orWhere('users.penempatan_kerja', 'ALL SITES (SP, SPS, SIP)')
                // ->where('penempatan_kerja', 'ALL SITES (SP, SPS, SIP)')
                // ->orWhere('users.penempatan_kerja', 'ALL SITES (SP)')
                // ->where('departemens.nama_departemen', 'PENGEMBANGAN TEKNOLOGI & SISTEM INFORMASI')
                ->where('users.is_admin', 'user')
                ->orderBy('level_jabatans.level_jabatan', 'ASC')
                ->select('users.*', 'bagians.nama_bagian', 'jabatans.id as id_jabatan', 'jabatans.nama_jabatan', 'divisis.nama_divisi', 'level_jabatans.level_jabatan')
                // ->select('users.id', 'users.name')
                // ->limit(1)
                ->get();
            // dd(json_encode($user));
            foreach ($user as $user) {
                $user_struktur2[] = array('x' => $user['name'], 'id' => str_replace("-", "", $user['id']), 'parent' => str_replace("-", "", $user['atasan_1']), 'attributes' => array('role' => $user['nama_jabatan'] . ' (' . $user['nama_bagian'] . ')', 'photo' => ''));
            }
        }
        return view('admin.struktur_organisasi.index', [
            'holding' => $holding,
            'user' => $user_struktur,
            'user1' => $user_struktur1,
            'user2' => $user_struktur2,
            'user_node' => $user_struktur
        ]);
    }
}
