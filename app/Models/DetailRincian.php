<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRincian extends Model
{
    use HasFactory;
    protected $guarded = []; 


    public function rekening()
    {
        return $this->belongsTo(MasterRekening::class, 'kode_rekening_pergeseran', 'kode_rek');
    }

    public function rek()
    {
        return $this->belongsTo(RincianRekening::class, 'rekenings_id');
    }

    public function sub_kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'master_kegiatan_id'); // master_sub_kegiatan_id
    }

    public function detail()
    {
        return $this->belongsTo(Detail::class, 'detail_id'); // detail
    }

    public static function get_sub2($master_sub_kegiatan_id, $subtitle,$pengajuan_id)
    { 
    	$details = DetailRincian::select('master_sub_kegiatan_id', 'subtitle_pergeseran', 'subtitle2_pergeseran')
            ->where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
            ->where('subtitle_pergeseran', $subtitle)
            ->where('pengajuan_id',$pengajuan_id)
            ->distinct()
            ->orderBy('subtitle2_pergeseran')
            ->first(); 

        $details = DetailRincian::select('detail_rincians.master_sub_kegiatan_id', 'detail_rincians.subtitle_pergeseran', 'detail_rincians.subtitle2_pergeseran')
            ->join('detail', 'detail.id', '=', 'detail_rincians.detail_id')
            ->where('detail_rincians.master_sub_kegiatan_id',$master_sub_kegiatan_id)
            ->where('detail_rincians.subtitle_pergeseran',$subtitle)
            ->where('pengajuan_id', $pengajuan_id)
            ->distinct()
            ->orderBy('subtitle2_pergeseran')
            ->first();

        return $details;
    }

    public static function get_rekening($master_sub_kegiatan_id, $subtitle, $subtitle2,$pengajuan_id,$detail_id,$kode_detail_rekening)
    { 
        $koderek = MasterRekening::where('kode_rek',$kode_detail_rekening)->first();
        $pengajuan = Pengajuan::find($pengajuan_id);
    	$res = DetailRincian::select('detail_rincians.master_sub_kegiatan_id', 'detail_rincians.subtitle_pergeseran','detail_rincians.nama_rekening_pergeseran', 'detail_rincians.subtitle2_pergeseran', 'detail_rincians.kode_rekening_pergeseran','detail_rincians.rekenings_id','detail_rincians.flag')
        ->join('detail', 'detail.id', '=', 'detail_rincians.detail_id')
        ->where('detail_rincians.master_sub_kegiatan_id', $master_sub_kegiatan_id)
        ->where('detail_rincians.subtitle_pergeseran', $subtitle)
        ->where('detail_rincians.subtitle2_pergeseran', $subtitle2)
        ->where('pengajuan_id', $pengajuan_id);
        if($pengajuan->usulan->id == 4){
            $res = $res->where('detail_rincians.detail_id',$detail_id);
        }else{
            $res = $res->where('detail_rincians.rekening_detail_id',$koderek->id);
        }
        $res = $res->distinct()
        ->orderBy('kode_rekening_pergeseran')
        ->with(['rek'])
        ->first(); 
        return $res;
    }

    public static function get_komponen($master_sub_kegiatan_id, $subtitle, $subtitle2, $kode_rekening,$pengajuan_id,$detail_id)
    { 
    	$res = DetailRincian::where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
				->where('subtitle_pergeseran', $subtitle)
				->where('subtitle2_pergeseran', $subtitle2)
				->where('kode_rekening_pergeseran', $kode_rekening) 
                ->where('pengajuan_id',$pengajuan_id)
                ->where('detail_id',$detail_id)
				->orderBy('kode_rekening_pergeseran')
				->first();
        return $res;
    }
}