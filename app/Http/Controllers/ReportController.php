<?php

namespace App\Http\Controllers;

use App\Exports\ReportPengajuan;
use App\Models\Fase;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengajuandetail= PengajuanDetail::all();
        $fase = Fase::all();
        $nama_header= 'Report Pengajuan Pergeseran Anggaran';
        return view('report.index',['nama_header'=>$nama_header],compact('pengajuandetail','fase'));
    }

    public function export_excel($fase_id)
    {
        $pengajuandetail = PengajuanDetail::with(['pengajuan.fase'])
        ->whereHas('pengajuan', function ($query) use ($fase_id) {
            $query->where('fase_id', $fase_id)->where('opd_id',Auth::user()->opd_id);
        })
        ->get();
        $date_now = date('Y-m-d');
        $nama_file = 'Rekap Pengajuan '.$date_now.'.xlsx';
        return Excel::download(new ReportPengajuan($pengajuandetail),$nama_file);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $fase_id = $request->fase_id;

        $pengajuandetail = PengajuanDetail::with(['pengajuan.fase'])
        ->whereHas('pengajuan', function ($query) use ($fase_id) {
            $query->where('fase_id', $fase_id)->where('opd_id',Auth::user()->opd_id);
        })
        ->get();
        $fase = Fase::where('id',$fase_id)->first();
        $nama_header= 'Report Pengajuan '.Auth::user()->skpd->unit_name.' Fase <b>'.$fase->nama.'</b>';
        return view('report.show',['nama_header'=>$nama_header],compact('pengajuandetail','fase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}