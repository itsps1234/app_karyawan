<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\Lokasi;
use App\Models\ResetCuti;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'Admin',
            'foto_karyawan' => '',
            'email' => 'admin@gmail.com',
            'telepon' => '0987654321',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'tgl_lahir' => date('Y-m-d'),
            'gender' => 'Laki-Laki',
            'tgl_join' => date('Y-m-d'),
            'status_nikah' => 'Menikah',
            'alamat' => 'alamat admin',
            'cuti_dadakan' => '12',
            'cuti_bersama' => '5',
            'cuti_menikah' => '2',
            'cuti_diluar_tanggungan' => '10',
            'cuti_khusus' => '8',
            'cuti_melahirkan' => '6',
            'izin_telat' => '16',
            'izin_pulang_cepat' => '9',
            'is_admin' => 'admin',
            'jabatan_id' => '1'
        ]);

        User::create([
            'name' => 'User',
            'foto_karyawan' => '',
            'email' => 'user@gmail.com',
            'telepon' => '123456789',
            'username' => 'user',
            'password' => Hash::make('user123'),
            'tgl_lahir' => date('Y-m-d'),
            'gender' => 'Laki-Laki',
            'tgl_join' => '2022-01-28',
            'status_nikah' => 'Menikah',
            'alamat' => 'alamat user',
            'cuti_dadakan' => '12',
            'cuti_bersama' => '5',
            'cuti_menikah' => '2',
            'cuti_diluar_tanggungan' => '10',
            'cuti_khusus' => '8',
            'cuti_melahirkan' => '6',
            'izin_telat' => '16',
            'izin_pulang_cepat' => '9',
            'is_admin' => 'user',
            'jabatan_id' => '2'
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Teknologi Informasi'
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Medik dan Keperawatan'
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Keuangan dan Akutansi'
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Administrasi & Umum'
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Humas & Pemasaran'
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Sekretariat'
        ]);

        Jabatan::create([
            'nama_jabatan' => 'PT. Permata Husada Sakti'
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Dokter Full Timer'
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Casemix'
        ]);
        
        Jabatan::create([
            'nama_jabatan' => 'Direktur'
        ]);
       

        Shift::create([
            'nama_shift' => "Libur",
            'jam_masuk' => "00:00",
            'jam_keluar' => "00:00",
        ]);

        Shift::create([
            'nama_shift' => "Office",
            'jam_masuk' => "08:00",
            'jam_keluar' => "17:00",
        ]);

        Shift::create([
            'nama_shift' => "Siang",
            'jam_masuk' => "13:00",
            'jam_keluar' => "21:00",
        ]);

        Shift::create([
            'nama_shift' => "Malam",
            'jam_masuk' => "21:00",
            'jam_keluar' => "07:00",
        ]);

        Lokasi::create([
            'lat_kantor' => '-6.3707314',
            'long_kantor' => '106.8138057',
            'radius' => '200',
        ]);

        ResetCuti::create([
            'cuti_dadakan' => 10,
            'cuti_bersama' => 10,
            'cuti_menikah' => 10,
            'cuti_diluar_tanggungan' => 10,
            'cuti_khusus' => 10,
            'cuti_melahirkan' => 10,
            'izin_telat' => 10, 
            'izin_pulang_cepat' => 10
        ]);
    }
}
