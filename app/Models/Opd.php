<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;
    
    public function atasan()
    {
        return $this->belongsTo(Opd::class, 'induk'); 
    }

    public function jenis_instansi()
    {
        return $this->belongsTo(JenisInstansi::class, 'jenis_instansi_id'); 
    }

    public function subOpd()
    {
        return $this->hasMany(Opd::class, 'induk', 'id'); 
    }
}
