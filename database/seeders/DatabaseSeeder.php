<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\LevelJabatan;
use App\Models\Lokasi;
use App\Models\ResetCuti;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Shift::create([
            'id' => Uuid::uuid4(),
            'nama_shift' => "Libur",
            'jam_masuk' => "00:00",
            'jam_keluar' => "00:00",
        ]);

        Shift::create([
            'id' => Uuid::uuid4(),
            'nama_shift' => "Office",
            'jam_masuk' => "08:00",
            'jam_keluar' => "17:00",
        ]);

        Shift::create([
            'id' => Uuid::uuid4(),
            'nama_shift' => "Siang",
            'jam_masuk' => "13:00",
            'jam_keluar' => "21:00",
        ]);

        Shift::create([
            'id' => Uuid::uuid4(),
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
