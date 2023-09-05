<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDetailSumberdana extends Model
{
    use HasFactory;
    
    public function pengajuan_detail()
    {
        return $this->hasMany(PengajuanDetail::class, 'pengajuan_detail_id');
    }
    
    public function sumber_dana()
    {
        return $this->belongsTo('App\Models\SumberDana', 'sumber_dana_id', 'id');
    }
}