<?php

namespace App\Exports;

use App\Models\Opd;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class ReportPengajuan implements FromView 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable; 
    protected $pengajuandetail;

    function __construct($pengajuandetail) { 
        $this->pengajuandetail = $pengajuandetail;
    }

    public function view(): View 
    {   
        $pengajuandetail = $this->pengajuandetail;
        $opd_id = Auth::user()->opd_id;
        $opd = Opd::find($opd_id);
       
        return view('report.export', compact('pengajuandetail','opd'));
    }    
}