<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis_data = [
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'HUMAN RESOURCE DEVELOPMENT')->value('id'), 'nama_jabatan' => 'MANAGER HRD', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '2')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'HUMAN RESOURCE DEVELOPMENT')->value('id'), 'nama_jabatan' => 'SUPERVISOR HRD', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'HUMAN RESOURCE DEVELOPMENT')->value('id'), 'nama_jabatan' => 'ADMIN HRD', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'GENERAL AFFAIRS')->value('id'), 'nama_jabatan' => 'ADMIN GA', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'INFORMATION TECHNOLOGY')->value('id'), 'nama_jabatan' => 'MANAGER IT', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '2')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'INFORMATION TECHNOLOGY')->value('id'), 'nama_jabatan' => 'SUPERVISOR IT', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'INFORMATION TECHNOLOGY')->value('id'), 'nama_jabatan' => 'STAFF IT', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PRODUCTION')->value('id'), 'nama_jabatan' => 'MANAGER PRODUKSI', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '2')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PRODUCTION')->value('id'), 'nama_jabatan' => 'SUPERVISOR PRODUKSI', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PRODUCTION')->value('id'), 'nama_jabatan' => 'ADMIN PRODUKSI', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'QUALITY CONTROL')->value('id'), 'nama_jabatan' => 'SUPERVISOR QUALITY CONTROL', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'QUALITY CONTROL')->value('id'), 'nama_jabatan' => 'ADMIN QUALITY CONTROL', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'MAINTENANCE')->value('id'), 'nama_jabatan' => 'SUPERVISOR MAINTENANCE', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'MAINTENANCE')->value('id'), 'nama_jabatan' => 'STAFF MAINTENANCE', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PRODUCTION PLANNING INVENTORY CONTROL')->value('id'), 'nama_jabatan' => 'MANAGER SCM', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '2')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PRODUCTION PLANNING INVENTORY CONTROL')->value('id'), 'nama_jabatan' => 'SUPERVISOR PPIC', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PRODUCTION PLANNING INVENTORY CONTROL')->value('id'), 'nama_jabatan' => 'ADMIN PPIC', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'DELIVERY')->value('id'), 'nama_jabatan' => 'MANAGER SCM', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '2')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'DELIVERY')->value('id'), 'nama_jabatan' => 'SUPERVISOR DELIVERY', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'DELIVERY')->value('id'), 'nama_jabatan' => 'KOORDINATOR DELIVERY', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'DELIVERY')->value('id'), 'nama_jabatan' => 'ADMIN', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '5')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'DELIVERY')->value('id'), 'nama_jabatan' => 'OPERATOR', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '5')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'WAREHOUSE')->value('id'), 'nama_jabatan' => 'MANAGER SCM', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '2')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'WAREHOUSE')->value('id'), 'nama_jabatan' => 'SUPERVISOR GUDANG', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'WAREHOUSE')->value('id'), 'nama_jabatan' => 'KOORDINATOR GUDANG', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'WAREHOUSE')->value('id'), 'nama_jabatan' => 'ADMIN GUDANG', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '5')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PURCHASING NON MATERIAL')->value('id'), 'nama_jabatan' => 'MANAGER PROCUREMENT', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '2')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PURCHASING NON MATERIAL')->value('id'), 'nama_jabatan' => 'SUPERVISOR PURCHASING', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PURCHASING NON MATERIAL')->value('id'), 'nama_jabatan' => 'STAFF PURCHASING', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PURCHASING MATERIAL (SOURCHING)')->value('id'), 'nama_jabatan' => 'MANAGER PROCUREMENT', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '2')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PURCHASING MATERIAL (SOURCHING)')->value('id'), 'nama_jabatan' => 'SUPERVISOR SOURCHING', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'PURCHASING MATERIAL (SOURCHING)')->value('id'), 'nama_jabatan' => 'STAFF SOURCHING', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'ACCOUNTING (GENERAL LEDGER)')->value('id'), 'nama_jabatan' => 'MANAGER PROCUREMENT', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '2')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'ACCOUNTING (GENERAL LEDGER)')->value('id'), 'nama_jabatan' => 'SUPERVISOR ACCOUNTING (GENERAL LEDGER)', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'ACCOUNTING (GENERAL LEDGER)')->value('id'), 'nama_jabatan' => 'STAFF ACCOUNTING (GENERAL LEDGER)', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'ACCOUNTING (DATABASE)')->value('id'), 'nama_jabatan' => 'STAFF ACCOUNTING (DATABASE)', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'FINANCE (ACCOUNT PAYABLE)')->value('id'), 'nama_jabatan' => 'SUPERVISOR FINANCE (ACCOUNT PAYABLE)', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'FINANCE (ACCOUNT PAYABLE)')->value('id'), 'nama_jabatan' => 'STAFF FINANCE (ACCOUNT PAYABLE)', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'FINANCE (ACCOUNT RECEIVABLE)')->value('id'), 'nama_jabatan' => 'SUPERVISOR FINANCE (ACCOUNT RECEIVABLE)', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'FINANCE (ACCOUNT RECEIVABLE)')->value('id'), 'nama_jabatan' => 'STAFF FINANCE (ACCOUNT RECEIVABLE)', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'FINANCE (CASH AND BANK - KASIR)')->value('id'), 'nama_jabatan' => 'SUPERVISOR FINANCE (CASH AND BANK - KASIR)', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'FINANCE (CASH AND BANK - KASIR)')->value('id'), 'nama_jabatan' => 'STAFF FINANCE (CASH AND BANK - KASIR)', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'TAX')->value('id'), 'nama_jabatan' => 'SUPERVISOR TAX', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'TAX')->value('id'), 'nama_jabatan' => 'STAFF TAX', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'SALES')->value('id'), 'nama_jabatan' => 'SUPERVISOR SALES', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'SALES')->value('id'), 'nama_jabatan' => 'SALES', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'MARKETING')->value('id'), 'nama_jabatan' => 'SUPERVISOR MARKETING', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '3')->value('id'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => Uuid::uuid4(), 'divisi_id' => DB::table('divisis')->where('nama_divisi', 'MARKETING')->value('id'), 'nama_jabatan' => 'MARKETING', 'level_id' => DB::table('level_jabatans')->where('level_jabatan', '4')->value('id'), 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('jabatans')->insert($jenis_data);
    }
}
