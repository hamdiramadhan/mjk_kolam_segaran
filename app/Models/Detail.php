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

    public function geser()
    {
        return $this->belongsTo(DetailRincian::class, 'kode_rekening', 'kode_rek');
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
    	$query1 = Detail::select('master_sub_kegiatan_id', 'subtitle', 'subtitle2', 'kode_rekening')
            ->where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
            ->where('subtitle', $subtitle)
            ->where('subtitle2', $subtitle2)
            ->orderBy('kode_rekening')
            ->distinct('kode_rekening');

        $query2 = DetailRincian::select('master_sub_kegiatan_id', 'subtitle_pergeseran as subtitle', 'subtitle2_pergeseran as subtitle2', 'kode_rekening_pergeseran as kode_rekening')
            ->where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
            ->where('subtitle_pergeseran', $subtitle)
            ->where('subtitle2_pergeseran', $subtitle2)
            ->orderBy('kode_rekening_pergeseran')
            ->distinct('kode_rekening_pergeseran');

        $result = $query1->union($query2)->with(['rekening'])->get();

        return $result;

    }

    public static function get_komponen($master_sub_kegiatan_id, $subtitle, $subtitle2, $kode_rekening)
    { 
    	$res = Detail::where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
				->where('subtitle', $subtitle)
				->where('subtitle2', $subtitle2)
				->where('kode_rekening', $kode_rekening) 
				->orderBy('kode_rekening')
                ->select('harga','ppn','volume','detail','spek','satuan','koefisien','id',DB::raw("'murni' as tipe"))
				->get();
        $res = DetailRincian::where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
                ->where('subtitle_pergeseran', $subtitle)
                ->where('subtitle2_pergeseran', $subtitle2)
                ->where('kode_rekening_pergeseran', $kode_rekening) 
                ->orderBy('kode_rekening_pergeseran')
                ->select('harga_pergeseran','ppn_pergeseran','volume_pergeseran','detail_pergeseran','spek_pergeseran','satuan_pergeseran','koefisien_pergeseran','id',DB::raw("'pergeseran' as tipe"))
                ->get();

        $query1 = Detail::where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
        ->where('subtitle', $subtitle)
        ->where('subtitle2', $subtitle2)
        ->where('kode_rekening', $kode_rekening) 
        ->orderBy('kode_rekening')
        ->select('harga', 'ppn', 'volume', 'detail', 'spek', 'satuan', 'koefisien', 'id', DB::raw("'murni' as tipe"), DB::raw("null as fase_id"));
        
        $query2 = DetailRincian::where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
            ->where('subtitle_pergeseran', $subtitle)
            ->where('subtitle2_pergeseran', $subtitle2)
            ->where('kode_rekening_pergeseran', $kode_rekening)
            ->orderBy('kode_rekening_pergeseran')
            ->select(
                'harga_pergeseran as harga', 
                'ppn_pergeseran as ppn', 
                'volume_pergeseran as volume',
                'detail_pergeseran as detail',
                'spek_pergeseran as spek',
                'satuan_pergeseran as satuan',
                'koefisien_pergeseran as koefisien',
                'id', 
                DB::raw("'pergeseran' as tipe")
                , 'fase_id'
            ); 
        $result = $query1->union($query2)->get();
            
        return $result;
    }

}