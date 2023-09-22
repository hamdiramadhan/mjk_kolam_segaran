<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDetail extends Model
{
    use HasFactory;
    
    public function sub_kegiatan()
    {
        return $this->belongsTo('App\Models\MasterSubKegiatan', 'master_sub_kegiatan_id', 'id');
    }
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'id');
    }

    public function komponens()
    {
        return $this->hasMany(PengajuanDetailKomponen::class, 'pengajuan_detail_id');
    }

    public function rincians()
    {
        return $this->hasMany(DetailRincian::class, 'pengajuan_detail_id');
    }

    public function sumberdanas()
    {
        return $this->hasMany(PengajuanDetailSumberdana::class, 'pengajuan_detail_id');
    }
}