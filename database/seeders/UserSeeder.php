<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => Uuid::uuid4(),
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
                'dept_id' => DB::table('departemens')->where('nama_departemen', 'HRD & GA')->value('id'),
                'divisi_id' => DB::table('divisis')->where('nama_divisi', 'HUMAN RESOURCE DEVELOPMENT')->value('id'),
                'jabatan_id' => DB::table('jabatans')->where('nama_jabatan', 'MANAGER HRD')->value('id')
            ], [
                'id' => Uuid::uuid4(),
                'name' => 'User1',
                'foto_karyawan' => '',
                'email' => 'user1@gmail.com',
                'telepon' => '123456789',
                'username' => 'user1',
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
                'dept_id' => DB::table('departemens')->where('nama_departemen', 'FINANCE AND ACCOUNTING')->value('id'),
                'divisi_id' => DB::table('divisis')->where('nama_divisi', 'FINANCE (CASH AND BANK - KASIR)')->value('id'),
                'jabatan_id' => DB::table('jabatans')->where('nama_jabatan', 'SUPERVISOR FINANCE (CASH AND BANK - KASIR)')->value('id')
            ], [
                'id' => Uuid::uuid4(),
                'name' => 'User2',
                'foto_karyawan' => '',
                'email' => 'user2@gmail.com',
                'telepon' => '123456789',
                'username' => 'user2',
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
                'dept_id' => DB::table('departemens')->where('nama_departemen', 'PRODUCTION')->value('id'),
                'divisi_id' => DB::table('divisis')->where('nama_divisi', 'QUALITY CONTROL')->value('id'),
                'jabatan_id' => DB::table('jabatans')->where('nama_jabatan', 'STAFF QUALITY CONTROL')->value('id')
            ],
            [
                'id' => Uuid::uuid4(),
                'name' => 'User3',
                'foto_karyawan' => '',
                'email' => 'user3@gmail.com',
                'telepon' => '123456789',
                'username' => 'user3',
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
                'dept_id' => DB::table('departemens')->where('nama_departemen', 'PROCUREMENT')->value('id'),
                'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PURCHASING MATERIAL (SOURCHING)')->value('id'),
                'jabatan_id' =>  DB::table('jabatans')->where('nama_jabatan', 'SUPERVISOR SOURCHING')->value('id')
            ]
        ];
        DB::table('users')->insert($data);
    }
}
