<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\DetailRincian;
use App\Models\MasterRekening;
use App\Models\MasterSubKegiatan;
use App\Models\Opd;
use App\Models\PengajuanDetail;
use App\Models\PengajuanDetailKomponen;
use App\Models\PengajuanDetailSumberdana;
use App\Models\Satuan;
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
         
        $data_sub_kegiatan = MasterSubKegiatan::where('tahun', $tahun);
        if(!empty($id_dinas) && $id_dinas != 'null' ) { 
            $data_sub_kegiatan = $data_sub_kegiatan->where('opd_id', $id_dinas);
        }   
        $data_sub_kegiatan = $data_sub_kegiatan->get();

        if(empty(sizeof($data_sub_kegiatan))){ 
            $data_sub_kegiatan = MasterSubKegiatan::where('tahun', $tahun)->where('opd_id', 0)->get();
        } 

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


    public function komponen($id)
    {
        $id = decrypt($id);
        // page sendiri 
        $pengajuan_detail = PengajuanDetail::find($id);
        $id_sub_kegiatan = $pengajuan_detail->sub_kegiatan->id;
        $sub_keg = MasterSubKegiatan::find($id_sub_kegiatan);
        $kode_sub_kegiatan = $sub_keg->kode_sub_kegiatan;
        $unit_id = $sub_keg->opd->unit_id;
        $data_rekening = MasterRekening::orderBy('kode_rek')->get();

    	$details = Detail::select('master_sub_kegiatan_id', 'subtitle')
                    ->where('master_sub_kegiatan_id', $id_sub_kegiatan)
                    ->distinct()
                    ->orderBy('subtitle')
                    ->get();
        $data = PengajuanDetailKomponen::where('pengajuan_detail_id',$id)->get();
        return view('pengajuan.pengajuan_detail.komponen', ['nama_header'=>'Detail Komponen'], compact('id_sub_kegiatan', 'sub_keg', 'kode_sub_kegiatan', 'unit_id','details','data_rekening','pengajuan_detail','data'));  
    } 

    public function geser_komponen(Request $request,$id)
    {
        $pengajuan_detail_id = decrypt($request->pengajuan_detail_id);
        $pengajuan_detail  = PengajuanDetail::find($pengajuan_detail_id);
        $data_satuan = Satuan::orderBy('satuan')->get();
        $data_rekening = MasterRekening::where('kode_rek', 'like', '5.%')->get();
        $data = Detail::findOrFail($id);
        return view('pengajuan.pengajuan_detail.edit_komponen', compact('data','data_rekening','data_satuan','pengajuan_detail'));
    }

    public function store_geser_komponen(Request $request)
    {
        // dd($request->all());
        if (!empty($request->opd_id)) {
            $koderek = MasterRekening::where('kode_rek',$request->kode_rekening)->first();
            $pengajuan_detail = PengajuanDetail::find($request->pengajuan_detail_id);
            if(empty($request->ppn))
            {
                $ppn=0;
            } else {
                $ppn = $request->ppn;
            }
            PengajuanDetailKomponen::create([
                'pengajuan_id' => $pengajuan_detail->pengajuan_id,
                'pengajuan_detail_id' => $request->pengajuan_detail_id,
                'master_sub_kegiatan_id' => $pengajuan_detail->master_sub_kegiatan_id,
                'opd_id' => $request->opd_id,
                'rekenings_id' => $koderek->id,
                'kode_rekening' => $request->kode_rekening,
                'detail' => $request->detail,
                'satuan' => $request->satuan, 
                'volume' => $request->volume,
                'harga' => $request->harga, 
                'spek' => $request->spek, 
                'koefisien' => $request->volume . ' ' . $request->satuan,
                'ppn' => $ppn ?? 0, 
                
                'rekenings_id_pergeseran' => $koderek->id_pergeseran,
                'kode_rekening_pergeseran' => $request->kode_rekening_pergeseran,
                'detail_pergeseran' => $request->detail_pergeseran,
                'satuan_pergeseran' => $request->satuan_pergeseran, 
                'volume_pergeseran' => $request->volume_pergeseran,
                'harga_pergeseran' => $request->harga_pergeseran, 
                'spek_pergeseran' => $request->spek_pergeseran, 
                'koefisien_pergeseran' => $request->volume_pergeseran . ' ' . $request->satuan_pergeseran,
                'ppn_pergeseran' => $ppn ?? 0,
                'created_by'=>Auth::user()->id
            ]);
            Detail::where('id', $request->id)->update([
                'flag'=>1
            ]);

            session()->put('status', 'Data berhasil ditambah');
        } else {
            session()->put('statusT', 'Data Gagal ditambah');
        }
        return back();
    }

    public function update_detail_rincian(Request $request,$id)
    {
        $pengajuan_detail_id = decrypt($request->pengajuan_detail_id);
        $pengajuan_detail  = PengajuanDetail::find($pengajuan_detail_id);
        $data_satuan = Satuan::orderBy('satuan')->get();
        $data_rekening = MasterRekening::where('kode_rek', 'like', '5.%')->get();
        $data = Detail::findOrFail($id);
        return view('pengajuan.pengajuan_detail.edit_rincian', compact('data','data_rekening','data_satuan','pengajuan_detail','id'));
    }

    public function update_rincian(Request $request)
    {
        // dd($request->all());
        if (!empty($request->opd_id)) {
            $koderek = MasterRekening::where('kode_rek',$request->kode_rekening_pergeseran)->first();
            $pengajuan_detail = PengajuanDetail::find($request->pengajuan_detail_id);
            if(empty($request->ppn_pergeseran))
            {
                $ppn=0;
            } else {
                $ppn = $request->ppn_pergeseran;
            }
            DetailRincian::create([
                'pengajuan_detail_id' => $pengajuan_detail->id,
                'pengajuan_id' => $pengajuan_detail->pengajuan_id,
                'detail_id' => $request->detail_id,
                'master_sub_kegiatan_id' => $pengajuan_detail->master_sub_kegiatan_id,
                'opd_id' => $request->opd_id,
                'unit_id' => $pengajuan_detail->pengajuan->unit_id,
                'kode_sub_kegiatan' => $pengajuan_detail->sub_kegiatan->kode_sub_kegiatan,
                'rekenings_id' => $koderek->id,
                'kode_rekening_pergeseran' => $request->kode_rekening_pergeseran,
                'nama_rekening_pergeseran' => $koderek->nama_rek,
                'kode_detail_pergeseran' => $request->kode_rekening_pergeseran,
                'detail_pergeseran' => $request->detail_pergeseran,
                'satuan_pergeseran' => $request->satuan_pergeseran, 
                'volume_pergeseran' => $request->volume_pergeseran,
                'harga_pergeseran' => $request->harga_pergeseran, 
                'spek_pergeseran' => $request->spek_pergeseran, 
                'koefisien_pergeseran' => $request->volume_pergeseran . ' ' . $request->satuan_pergeseran,
                'ppn_pergeseran' => $ppn ?? 0,
                'tahun_pergeseran' => Auth::user()->tahun,
                'created_by'=>Auth::user()->id
            ]);
            Detail::where('id', $request->id)->update([
                'flag'=>1
            ]);

            session()->put('status', 'Data berhasil ditambah');
        } else {
            session()->put('statusT', 'Data Gagal ditambah');
        }
        return back();
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