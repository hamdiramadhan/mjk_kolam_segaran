<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_statuses')->delete();
        DB::table('master_statuses')->insert([
            'id' => 1
            , 'kode' => 0
            , 'nama' => 'Draft' 
            , 'ket' => 'Menunggu Staff untuk klik "KIRIM" ke tim Verifikator'
            , 'color' => 'cyan'
            , 'color_div' => 'info'
        ]); 
        DB::table('master_statuses')->insert([
            'id' => 2
            , 'kode' => 1
            , 'nama' => 'Pending' 
            , 'ket' => 'Menunggu tim Verifikator untuk memverifikasi.'
            , 'color' => 'yellow'
            , 'color_div' => 'warning'
        ]); 
        DB::table('master_statuses')->insert([
            'id' => 3
            , 'kode' => 2
            , 'nama' => 'Setuju' 
            , 'ket' => 'Disetujui Oleh tim Verifikator'
            , 'color' => 'green'
            , 'color_div' => 'success'
        ]); 
        DB::table('master_statuses')->insert([
            'id' => 4
            , 'kode' => 3
            , 'nama' => 'Tolak' 
            , 'ket' => 'Ditolak Pergeserah Anggaran'
            , 'color' => 'red'
            , 'color_div' => 'danger'
        ]); 
    }
}