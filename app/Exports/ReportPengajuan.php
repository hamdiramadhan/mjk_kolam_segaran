<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
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
       
        return view('report.export', compact('pengajuandetail'));
    }    
}