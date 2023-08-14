<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        DB::table('roles')->insert([
            'id' => 1
            , 'name' => 'Administrator' 
            , 'guard_name' => 'web' 
        ]); 
        DB::table('roles')->insert([
            'id' => 2
            , 'name' => 'SKPD' 
            , 'guard_name' => 'web'
        ]);
        DB::table('roles')->insert([
            'id' => 3
            , 'name' => '(Anggaran) Verifikator' 
            , 'guard_name' => 'web'
        ]);

        DB::table('roles')->insert([
            'id' => 7
            , 'name' => 'Monitoring' 
            , 'guard_name' => 'web'
        ]); 
        
    }
}