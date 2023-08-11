<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKegiatan extends Model
{
    protected $table = "master_kegiatan"; 

    public function program()
    {
        return $this->belongsTo(MasterProgram::class, 'master_program_id');
    }
}
