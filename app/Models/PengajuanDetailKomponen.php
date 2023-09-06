<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDetailKomponen extends Model
{
    use HasFactory;
    protected $guarded = []; 

    public function rekening()
    {
        return $this->belongsTo(MasterRekening::class, 'kode_rekening', 'kode_rek');
    }
}