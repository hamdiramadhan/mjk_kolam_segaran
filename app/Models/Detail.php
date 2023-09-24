<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Detail extends Model
{
    use HasFactory;
    protected $table = "detail";
    protected $guarded = []; 

    public function rekening()
    {
        return $this->belongsTo(MasterRekening::class, 'kode_rekening', 'kode_rek');
    }

    public function rek()
    {
        return $this->belongsTo(RincianRekening::class, 'rekenings_id');
    }

    public function sub_kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'master_kegiatan_id'); // master_sub_kegiatan_id
    }

    public static function get_sub2($master_sub_kegiatan_id, $subtitle)
    { 
    	$details = Detail::select('master_sub_kegiatan_id', 'subtitle', 'subtitle2','flag')
            ->where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
            ->where('subtitle', $subtitle)
            ->distinct()
            ->orderBy('subtitle2')
            ->get(); 

        return $details;
    }

    public static function get_rekening($master_sub_kegiatan_id, $subtitle, $subtitle2)
    { 
    	$res = Detail::select('master_sub_kegiatan_id', 'subtitle', 'subtitle2', 'kode_rekening', 'rekenings_id')
            ->where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
            ->where('subtitle', $subtitle)
            ->where('subtitle2', $subtitle2)
            ->orderBy('kode_rekening')
            ->distinct('kode_rekening')
            ->with(['rekening'])
            ->get();
    return $res;

    }

    public static function get_komponen($master_sub_kegiatan_id, $subtitle, $subtitle2, $kode_rekening)
    { 
    	$res = Detail::where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
				->where('subtitle', $subtitle)
				->where('subtitle2', $subtitle2)
				->where('kode_rekening', $kode_rekening) 
				->orderBy('kode_rekening')
				->get();
        return $res;
    }

}