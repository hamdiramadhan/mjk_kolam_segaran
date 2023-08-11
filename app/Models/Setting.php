<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    public static function get_tahun(){ 
        $setting = Setting::where('is_active', 1)->first();
        $tahun = array();
        for ($i=($setting->tahun_akhir ?? date('Y')); $i >= ($setting->tahun_awal ?? date('Y')); $i--) { 
            array_push($tahun, $i);
        }
        return $tahun;
    } 
}