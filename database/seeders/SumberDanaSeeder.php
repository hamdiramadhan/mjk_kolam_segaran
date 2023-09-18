<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SumberDanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sumber_danas')->delete();
        DB::table('sumber_danas')->insert([
            'id' => 1
            , 'nama' => 'APBD'
            , 'keterangan' => 'Anggaran Pendapatan, dan Belanja Daerah'  
        ]); 
        DB::table('sumber_danas')->insert([
            'id' => 2
            , 'nama' => 'PAD'
            , 'keterangan' => 'Pendapatan Asli Daerah'  
        ]); 
        DB::table('sumber_danas')->insert([
            'id' => 3
            , 'nama' => 'DBHCHT'
            , 'keterangan' => 'Dana Bagi Hasil Cukai Hasil Tembakau'  
        ]); 
        DB::table('sumber_danas')->insert([
            'id' => 4
            , 'nama' => 'PAJAK ROKOK'
            , 'keterangan' => 'Pajak Rokok'  
        ]); 
        DB::table('sumber_danas')->insert([
            'id' => 5
            , 'nama' => 'DAU'
            , 'keterangan' => 'Dana Alokasi Umum'  
        ]); 
        DB::table('sumber_danas')->insert([
            'id' => 6
            , 'nama' => 'DAU Earmark'
            , 'keterangan' => 'Dana Alokasi Umum Earmark'  
        ]); 
        DB::table('sumber_danas')->insert([
            'id' => 7
            , 'nama' => 'DAK Fisik'
            , 'keterangan' => 'Dana Alokasi Khusus Fisik'  
        ]); 
        DB::table('sumber_danas')->insert([
            'id' => 8
            , 'nama' => 'DAK Non Fisik'
            , 'keterangan' => 'Dana Alokasi Khusus Non Fisik'  
        ]); 
        DB::table('sumber_danas')->insert([
            'id' => 9
            , 'nama' => 'BK Prov'
            , 'keterangan' => 'Bantuan Keuangan Provinsi'  
        ]); 
        DB::table('sumber_danas')->insert([
            'id' => 10
            , 'nama' => 'DIF'
            , 'keterangan' => 'Dana Insentif Fiskal'  
        ]); 
    }
}
