<?php

namespace App\Http\Controllers;

use App\Models\MasterSubKegiatan;
use App\Models\Opd;
use App\Models\PengajuanDetail;
use App\Models\PengajuanDetailSumberdana;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = decrypt($request->id);
        $tahun = Auth::user()->tahun;
        $opd_id = Auth::user()->opd_id;
        
        $opd = Opd::find($opd_id);
         
        $data_sub_kegiatan = MasterSubKegiatan::where('opd_id', $opd_id)
            ->where('tahun', $tahun) 
            ->orderBy('kode_sub_kegiatan')
            ->get(); 
        $sumber_dana = SumberDana::all();
        
        $data_opd = Opd::orderBy('unit_id')->get();
        return view('pengajuan.pengajuan_detail.create',['nama_header'=>'Tambah Pengajuan'],compact('data_sub_kegiatan','opd_id', 'opd', 'tahun','data_opd','sumber_dana','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    { 
        $id = decrypt($id);
        $sub_kegiatan = $request->sub_kegiatan;
        for ($i = 0; $i < sizeof($sub_kegiatan); $i++) { 
            $data_sub_kegiatan = MasterSubKegiatan::find($sub_kegiatan[$i]); 
            $pengajuan_detail = new PengajuanDetail();
            $pengajuan_detail->master_sub_kegiatan_id = $data_sub_kegiatan->id;
            $pengajuan_detail->pengajuan_id = $id;
            $pengajuan_detail->save();
            
            $arr_sumber_dana = $request->{'sumber_dana_'.$sub_kegiatan[$i]};
            if(!empty($arr_sumber_dana))
            {
                foreach($arr_sumber_dana as $sumber_dana)
                { 
                    $sumberdana = new PengajuanDetailSumberdana();
                    $sumberdana->sumber_dana_id=$sumber_dana; 
                    $sumberdana->pengajuan_detail_id=$pengajuan_detail->id;
                    $sumberdana->save();
                }
            }
        }
       
        session()->put('status', 'Data berhasil ditambahkan! ' );
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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