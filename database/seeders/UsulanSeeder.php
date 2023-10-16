<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengajuan_usulans')->delete();
        DB::table('pengajuan_usulans')->insert([
            'id' => 1
            , 'usulan' => 'Pergeseran antar objek dalam jenis yang sama' 
        ]); 
        DB::table('pengajuan_usulans')->insert([
            'id' => 2
            , 'usulan' => 'Pergeseran antar rincian objek dalam objek yang sama' 
        ]); 
        DB::table('pengajuan_usulans')->insert([
            'id' => 3
            , 'usulan' => 'Pergeseran antar sub rincian objek dalam rincian objek yang sama' 
        ]); 
        DB::table('pengajuan_usulans')->insert([ 
            'id' => 4
            , 'usulan' => 'Perubahan atau pergeseran atas uraian/ keterangan dari sub rincian objek' 
        ]); 
    }
}