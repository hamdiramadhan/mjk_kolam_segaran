<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;
    
    public function skpd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    public function usulan()
    {
        return $this->belongsTo(PengajuanUsulan::class, 'usulan_id');
    }
    
    public function stat()
    {
        return $this->belongsTo('App\Models\MasterStatus', 'status', 'kode');
    }
}