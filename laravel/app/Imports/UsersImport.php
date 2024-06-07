<?php

namespace App\Imports;

use App\Models\Bagian;
use App\Models\Cities;
use App\Models\Departemen;
use App\Models\District;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\User;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravolt\Indonesia\Models\Province;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[28] == NULL) {
            $tgl_mulai = NULL;
            // dd($tgl_mulai);
        } else {
            $tgl_mulai = Carbon::createFromFormat('d/m/Y', $row[28])->format('Y-m-d');
            // dd($tgl_mulai);
        }
        if ($row[29] == NULL) {
            $tgl_selesai = NULL;
        } else {
            $tgl_selesai = Carbon::createFromFormat('d/m/Y', $row[29])->format('Y-m-d');
        }
        return new User([
            "nomor_identitas_karyawan" => $row[1],
            "name" => $row[2],
            "nik" => $row[3],
            "npwp" => $row[4],
            "fullname" => $row[5],
            "motto" => $row[6],
            "foto_karyawan" => $row[7],
            "email" => $row[8],
            "telepon" => $row[9],
            "username" => $row[10],
            "password" => Hash::make($row[11]),
            "tempat_lahir" => $row[12],
            "tgl_lahir" => Carbon::createFromFormat('d/m/Y', $row[13])->format('Y-m-d'),
            "gender" => $row[14],
            "tgl_join" => Carbon::createFromFormat('d/m/Y', $row[15])->format('Y-m-d'),
            "status_nikah" => $row[16],
            "provinsi" => Province::where('name', $row[17])->value('code'),
            "kabupaten" => Cities::where('name', $row[18])->value('code'),
            "kecamatan" =>  District::where('name', $row[19])->value('code'),
            "desa" => Village::where('name', $row[20])->value('code'),
            "rt" => $row[21],
            "rw" => $row[22],
            "detail_alamat" => $row[24],
            "alamat" => $row[23],
            "kuota_cuti_tahunan" => $row[25],
            "is_admin" => $row[26],
            "kategori" => $row[27],
            "tgl_mulai_kontrak" => $tgl_mulai,
            "tgl_selesai_kontrak" => $tgl_selesai,
            "lama_kontrak_kerja" => $row[30],
            "kontrak_kerja" => $row[31],
            "lokasi_kontrak_kerja" => $row[32],
            "kontrak_site" => $row[33],
            "penempatan_kerja" => $row[34],
            "site_job" => $row[35],
            "nama_bank" => $row[36],
            "nomor_rekening" => $row[37],
            "dept_id" => Departemen::where('nama_departemen', $row[38])->value('id'),
            "divisi_id" => Divisi::where('nama_divisi', $row[39])->value('id'),
            "bagian_id" => Bagian::where('nama_bagian', $row[40])->value('id'),
            "jabatan_id" => Jabatan::where('nama_jabatan', $row[41])->value('id'),
            "divisi1_id" => Divisi::where('nama_divisi', $row[42])->value('id'),
            "jabatan1_id" => Jabatan::where('nama_jabatan', $row[43])->value('id'),
            "divisi2_id" => Divisi::where('nama_divisi', $row[44])->value('id'),
            "jabat2an_id" => Jabatan::where('nama_jabatan', $row[45])->value('id'),
            "divisi3_id" => Divisi::where('nama_divisi', $row[46])->value('id'),
            "jabatan3_id" => Jabatan::where('nama_jabatan', $row[47])->value('id'),
            "divisi4_id" => Divisi::where('nama_divisi', $row[48])->value('id'),
            "jabatan4_id" => Jabatan::where('nama_jabatan', $row[49])->value('id'),
        ]);
    }
}
