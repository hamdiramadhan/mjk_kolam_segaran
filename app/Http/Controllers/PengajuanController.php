<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Pengajuan;
use App\Models\PengajuanAlasan;
use App\Models\PengajuanUsulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengajuan = Pengajuan::all();
        $pengajuan_id = Pengajuan::pluck('id');
        $pengajuan_alasan = PengajuanAlasan::All();
        $nama_header = 'Pengajuan Perubahan';
        return view('pengajuan.index',['nama_header'=>$nama_header],compact('pengajuan','pengajuan_alasan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $opd = Opd::find(Auth::user()->opd_id);
        $usulan = PengajuanUsulan::all();
        $nama_header = 'Pengajuan Perubahan '.$opd->unit_name;
        return view('pengajuan.create',['nama_header'=>$nama_header],compact('opd','usulan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alasan = $request->alasan;
        $opd_id = Auth::user()->opd_id;
        $tahun = Auth::user()->tahun;
        $opd = Opd::find($opd_id);
        $pengajuan = new Pengajuan();
        $pengajuan->opd_id = $opd_id;
        $pengajuan->unit_id = $opd->unit_id;
        $pengajuan->nomor_surat = $request->nomor_surat;
        $pengajuan->tanggal_surat = $request->tanggal_surat;
        $pengajuan->sifat_surat = $request->sifat_surat;
        $pengajuan->lampiran = $request->lampiran;
        $pengajuan->tahun = $tahun;
        $pengajuan->usulan_id = $request->usulan_id;
        $pengajuan->status = 0;
        $pengajuan->save();
        for($i=0; $i<sizeof($alasan); $i++){
            $pengajuanAlasan = new PengajuanAlasan();
            $pengajuanAlasan->pengajuan_id = $pengajuan->id;
            $pengajuanAlasan->alasan = $alasan[$i];
            $pengajuanAlasan->save();
        }

        session()->put('status', 'Pengajuan baru berhasil ditambahkan! ' );
        return redirect()->route('pengajuan.index');
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