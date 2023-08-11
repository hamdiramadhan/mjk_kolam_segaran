<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('username', 'admin')->first(); 
        if(!$user)
        {
            DB::table('users')->insert([
                'name' => 'Admin'
                , 'username' => 'admin'
                , 'email' => 'admin@mail.com'
                , 'password' => Hash::make('admin')
                , 'role_id' => 1
                , 'no_hp' => '6287853433170'
            ]);
        } else {
            $user->password = Hash::make('admin');
            $user->save();
        }
    }
}