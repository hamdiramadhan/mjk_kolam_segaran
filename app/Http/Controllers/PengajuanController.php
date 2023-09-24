<?php

namespace App\Http\Controllers;

use App\Models\Fase;
use App\Models\Detail;
use App\Models\DetailRincian;
use App\Models\MasterStatus;
use App\Models\MasterSubKegiatan;
use App\Models\Opd;
use App\Models\Pengajuan;
use App\Models\PengajuanAlasan;
use App\Models\PengajuanDetail;
use App\Models\PengajuanDetailKomponen;
use App\Models\PengajuanDetailSumberdana;
use App\Models\PengajuanUsulan;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opd = Opd::findOrFail(Auth::user()->opd_id);
        $pengajuan = Pengajuan::with('fase')->where('status',0)->where('opd_id',$opd->id)->where('tahun',Auth::user()->tahun)->get();
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3){
            $pengajuan = Pengajuan::with('fase')->where('status',0)->get();
        } 
        $pengajuan_alasan = PengajuanAlasan::All();
        $count_pengajuan = Pengajuan::with('fase')->whereIn('status',[0,1,2])->where('opd_id',$opd->id)->where('tahun',Auth::user()->tahun)->count();
        $status = MasterStatus::whereNotIn('kode',[0,1])->get();
        $nama_header = 'Pengajuan Perubahan '.$opd->unit_name .' '. Auth::user()->tahun;
        return view('pengajuan.index',['nama_header'=>$nama_header],compact('pengajuan','pengajuan_alasan','count_pengajuan','status'));
    }


    public function proses()
    {
        $opd = Opd::find(Auth::user()->opd_id);
        $pengajuan = Pengajuan::where('status',1)->where('opd_id',$opd->id)->where('tahun',Auth::user()->tahun)->get();
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3){
            $pengajuan = Pengajuan::where('status',1)->get();
        }
        $pengajuan_alasan = PengajuanAlasan::All();
        $count_pengajuan = Pengajuan::whereIn('status',[0,1,2])->where('opd_id',$opd->id)->where('tahun',Auth::user()->tahun)->count();
        $status = MasterStatus::whereNotIn('kode',[0,1])->get();
        $nama_header = 'Pengajuan Perubahan';
        return view('pengajuan.index',['nama_header'=>$nama_header],compact('pengajuan','pengajuan_alasan','count_pengajuan','status'));
    }


    public function selesai()
    {
        $opd = Opd::find(Auth::user()->opd_id);
        $pengajuan = Pengajuan::where('status',2)->where('opd_id',$opd->id)->where('tahun',Auth::user()->tahun)->get();
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3){
            $pengajuan = Pengajuan::where('status',2)->get();
        }
        $pengajuan_alasan = PengajuanAlasan::All();
        $count_pengajuan = Pengajuan::whereIn('status',[0,1,2])->where('opd_id',$opd->id)->count();
        $status = MasterStatus::whereNotIn('kode',[0,1])->get();
        $nama_header = 'Pengajuan Perubahan';
        return view('pengajuan.index',['nama_header'=>$nama_header],compact('pengajuan','pengajuan_alasan','count_pengajuan','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fases = Fase::where('mulai', '<=', date('Y-m-d H:i'))
            ->where('selesai', '>=', date('Y-m-d H:i')) 
            ->orderBy('kode')
            ->get();  

        $opd = Opd::find(Auth::user()->opd_id);
        $usulan = PengajuanUsulan::all();
        $nama_header = 'Pengajuan Perubahan '.$opd->unit_name;
        return view('pengajuan.create',['nama_header'=>$nama_header],compact('opd','usulan','fases'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $alasan = $request->alasan;
        $fase_id = $request->fase_id;
        $opd_id = Auth::user()->opd_id;
        $tahun = Auth::user()->tahun;
        $opd = Opd::find($opd_id);
        $pengajuan = new Pengajuan();
        $pengajuan->fase_id = $fase_id;
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
        if($alasan!= null){
            for($i=0; $i<sizeof($alasan); $i++){
                $pengajuanAlasan = new PengajuanAlasan();
                $pengajuanAlasan->pengajuan_id = $pengajuan->id;
                $pengajuanAlasan->alasan = $alasan[$i];
                $pengajuanAlasan->save();
            }
        }
        

        session()->put('status', 'Pengajuan baru berhasil ditambahkan! ' );
        return redirect()->route('pengajuan.index');
    }
    public function print_pengajuan(Request $request,$id)
    {
        $id = decrypt(($id));
        $data = Pengajuan::find($id);
        $tahun = Auth::user()->tahun;
        $opd_id = Auth::user()->opd_id;
        
        $opd =Opd::find($opd_id);
        $pengajuan_alasan = PengajuanAlasan::where('pengajuan_id',$id)->get();
        $usulan = PengajuanUsulan::all();
    
        $judul = 'Usulan Pergeseran Anggaran Dalam APBD TA '.$tahun;
        $url = env('APP_URL'); 

        $pdf = PDF::loadView('pengajuan.print_pengajuan', compact('opd','url','usulan','pengajuan_alasan','data', 'tahun', 'id','judul'));
        $customPaper = array(0,0,595.35,935.55);
        $pdf->setPaper($customPaper);
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $height = $canvas->get_height();
        $width = $canvas->get_width();
        if($data->status != 2) { 
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->set_opacity(0.2,"Multiply"); 
            $canvas->page_text($width/5.5, $height/2.5, @$data->stat->nama, null, 40, array(1,0,0),2,2,0);
        }
        return $pdf->stream('Pengajuan_'.$tahun.'_'.date('Ymd-His').'.pdf');

    }

    public function send(Request $request,$id)
    {
        $id = decrypt($id);
        $data = Pengajuan::find($id);
        $data->status = 1;
        $data->save();
        session()->put('status', 'Pengajuan berhasil dikirim! ' );
        return redirect()->route('pengajuan.index');
    }

    public function verif(Request $request,$id)
    {
        $id = decrypt($id);
        $data = Pengajuan::find($id);
        $data->status = $request->status_id;
        $data->keterangan_status = $request->keterangan_status;
        $data->save();
        session()->put('status', 'Pergeserah berhasil di Verifikasi' );
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

        $id = decrypt($id);
        $opd = Opd::find(Auth::user()->opd_id);
        $usulan = PengajuanUsulan::all();
        $pengajuan = Pengajuan::find($id);
        $pengajuan_alasan = PengajuanAlasan::where('pengajuan_id',$id)->get();

        $fases = Fase::where('mulai', '<=', date('Y-m-d H:i'))
            ->where('selesai', '>=', date('Y-m-d H:i')) 
            ->orWhere('id', $pengajuan->fase_id)
            ->orderBy('kode')
            ->get();  

        $nama_header = 'Pengajuan Perubahan '.$opd->unit_name;
        return view('pengajuan.edit',['nama_header'=>$nama_header],compact('opd','usulan','pengajuan','pengajuan_alasan','fases'));
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
        $id = decrypt($id);
        $pengajuan_alasan = PengajuanAlasan::where('pengajuan_id',$id)->pluck('id');
        $pengajuan = PengajuanAlasan::whereIn('id', $pengajuan_alasan)->delete();

        $alasan = $request->alasan;
        $fase_id = $request->fase_id;
        $opd_id = Auth::user()->opd_id;
        $tahun = Auth::user()->tahun;
        $opd = Opd::find($opd_id);
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->fase_id = $fase_id;
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
        $alasandel = PengajuanAlasan::where('pengajuan_id', $pengajuan->id)->delete();
        if($alasan!= null){
            for($i=0; $i<sizeof($alasan); $i++){
                $pengajuanAlasan = new PengajuanAlasan();
                $pengajuanAlasan->pengajuan_id = $pengajuan->id;
                $pengajuanAlasan->alasan = $alasan[$i];
                $pengajuanAlasan->save();
            }
        }
        

        session()->put('status', 'Pengajuan berhasil diubah! ' );
        return redirect()->route('pengajuan.index');
    }
    
    public function detail(Request $request,$id)
    {
        $id = decrypt($id);
        $tahun = Auth::user()->tahun;
        $opd_id = Auth::user()->opd_id;
        
        $opd = Opd::find($opd_id); 

        $data_opd = Opd::orderBy('unit_id')->get();
        $pengajuan = Pengajuan::find($id);
        $sumber_dana = SumberDana::all();
        $pengajuan_detail = PengajuanDetail::with('sub_kegiatan')->where('pengajuan_id',$id)->get();
        $detail_sumberdana = PengajuanDetailSumberdana::all();
        return view('pengajuan.detail',['nama_header'=>'Rincian Sub kegiatan'],
            compact('pengajuan','opd_id', 'opd', 'tahun','data_opd','sumber_dana','id','pengajuan_detail','detail_sumberdana')
        );
    }

    public function print_detail(Request $request,$id)
    {
        $id = decrypt($id);
        $data = Pengajuan::findOrFail($id);
        $tahun = Auth::user()->tahun;
        $opd_id = Auth::user()->opd_id;
        $opd =Opd::findOrFail($opd_id);
        $pengajuan_alasan = PengajuanAlasan::where('pengajuan_id',$id)->get();
        $usulan = PengajuanUsulan::all();
        $pengajuan_detail = PengajuanDetail::with(['rincians'])->where('pengajuan_id',$id)->get(); 
        $detail_sumberdana = PengajuanDetailSumberdana::all();
        $detail_rekening = DetailRincian::where('pengajuan_id',$id)->get();
        
        $judul = 'Usulan Pergeseran Anggaran Dalam APBD TA '.$tahun;
        $url = env('APP_URL'); 
        
        $pdf = PDF::loadView('pengajuan.print_detail', compact('opd','url','usulan','pengajuan_alasan','data', 'pengajuan_detail','tahun', 'id','judul','detail_sumberdana','detail_rekening'));
        // $customPaper = array(0,0,595.35,935.55);
        $customPaper = array(0, 0, 935.55, 595.35); // Swap width and height for landscape
        
        $pdf->setPaper($customPaper);
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $height = $canvas->get_height();
        $width = $canvas->get_width();
        if($data->status != 2) { 
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->set_opacity(0.2,"Multiply"); 
            // $canvas->page_text($width/5.5, $height/2.5, @$data->stat->nama, null, 40, array(1,0,0),2,2,0);
            // dd($pengajuan_detail);
        }
        return $pdf->stream('Pengajuan_'.$tahun.'_'.date('Ymd-His').'.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
         $id = decrypt($id);
         $pengajuan_alasan = PengajuanAlasan::where('pengajuan_id',$id)->delete();
         $data = Pengajuan::find($id);
         session()->put('status', 'Data User dengan nama: ' . $data->nama . ', Berhasil dihapus!');
         $data->delete();
         return redirect()->back(); 
     }
}