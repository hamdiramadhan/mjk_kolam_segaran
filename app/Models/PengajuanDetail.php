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
        return $this->belongsTo('App\Models\Pengajuan', 'pengajuan_id', 'id');
    }
}