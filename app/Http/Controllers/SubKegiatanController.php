<?php

namespace App\Http\Controllers;

use App\Imports\ImportKegiatan;
use App\Imports\ImportKegiatan2;
use App\Models\Detail;
use App\Models\MasterSubKegiatan;
use App\Models\MasterKegiatan;
use App\Models\MasterProgram;
use App\Models\Menu;
use App\Models\Opd;
use App\Models\RincianRekening;
use App\Models\Satuan;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;

class SubKegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        return view('sub_kegiatan.index', ['nama_header'=> 'Sub Kegiatan']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = Satuan::orderBy('satuan')->get();
        $kegiatan = MasterKegiatan::orderBy('kode_kegiatan')->where('tahun', Auth::user()->tahun)->get(); 
        return view('sub_kegiatan.create', ['nama_header'=> 'Master Sub Kegiatan'],compact('kegiatan','satuan'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $master_sub_kegiatan = new MasterSubKegiatan();
        $master_sub_kegiatan->master_kegiatan_id  = $request->master_kegiatan_id;
        $master_sub_kegiatan->kode_sub_kegiatan  = $request->kode_sub_kegiatan;
        $master_sub_kegiatan->nama_sub_kegiatan  = $request->nama_sub_kegiatan;
        $master_sub_kegiatan->kinerja  = $request->kinerja;
        $master_sub_kegiatan->indikator  = $request->indikator;
        $master_sub_kegiatan->satuan  = $request->satuan;
        $master_sub_kegiatan->tahun  = $request->tahun; 
        $master_sub_kegiatan->opd_id  = Auth::user()->opd_id; 
        $master_sub_kegiatan->save();
        session()->put('status', 'Sub Kegiatan baru berhasil ditambahkan! ' );
        return redirect()->route('sub_kegiatan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {
        $key = urldecode($key);
        $zz = $this->hamdi_decrypt($key, 'progstylysbyhamdi');
        $arr = explode("##", $zz);
        $id = $arr[1]; 
        $kegiatan = MasterKegiatan::all();
        $sub_keg = MasterSubKegiatan::find($id);
        return view('sub_kegiatan.edit',['nama_header'=> 'Master Sub Kegiatan'],compact('kegiatan','sub_keg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($key)
    { 
        $id = \Illuminate\Support\Facades\Crypt::decrypt($key);
        $kegiatan = MasterKegiatan::all();
        $sub_keg = MasterSubKegiatan::find($id); 
        $satuan = Satuan::orderBy('satuan')->get();
        return view('sub_kegiatan.edit',['nama_header'=> 'Master Sub Kegiatan'],compact('kegiatan','sub_keg','satuan'));
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
        $master_sub_kegiatan = MasterSubKegiatan::find($id);
        $master_sub_kegiatan->master_kegiatan_id  = $request->master_kegiatan_id;
        $master_sub_kegiatan->kode_sub_kegiatan  = $request->kode_sub_kegiatan;
        $master_sub_kegiatan->nama_sub_kegiatan  = $request->nama_sub_kegiatan;
        $master_sub_kegiatan->kinerja  = $request->kinerja;
        $master_sub_kegiatan->indikator  = $request->indikator;
        $master_sub_kegiatan->satuan  = $request->satuan;
        // $master_sub_kegiatan->tahun  = $request->tahun; 
        $master_sub_kegiatan->save();
        session()->put('status', 'Sub Kegiatan baru berhasil dirubah! ' );
        return redirect()->route('sub_kegiatan');
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

    
    public function import(Request $request)
    { 
        $excel = $request->file('file_upload_excel'); 
        $tahun = Auth::user()->tahun ?? date('Y'); 
        $format = $request->format;
        $konsep = $request->konsep;
        $opd_id = Auth::user()->opd_id; 
        $jenis_upload = $request->jenis_upload;
         
        $tgl = new DateTime(); 
        $new_name = 'excel_import_kegiatan_' . $tgl->format('YmdHis') . "_" . $excel->getClientOriginalName();  

        $ext = explode(".", $new_name);
        $extension = $ext[sizeof($ext)-1];
        if ($extension == 'xlsx') { 
            $excel->move(('file_upload/excel'), $new_name);
            $path = 'file_upload/excel/' . $new_name; 

            if($format == 1)
            {
                Excel::import(new ImportKegiatan($tahun, $jenis_upload, $konsep, $opd_id), public_path($path));   
            } else {
                Excel::import(new ImportKegiatan2($tahun, $jenis_upload, $konsep, $opd_id), public_path($path));   
            }
            
            
            if($jenis_upload != 2){
                session()->put('status', 'Data Berhasil diimport');
                return back();
            }
        } else {
            session()->put('statusT', 'File harus .xlsx');
            return back();
        }
    }
    function hamdi_encrypt($string, $key = '%key&')
	{
	    $result = '';
	    for ($i = 0; $i < strlen($string); $i++) {
	        $char = substr($string, $i, 1);
	        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
	        $ordChar = ord($char);
	        $ordKeychar = ord($keychar);
	        $sum = $ordChar + $ordKeychar;
	        $char = chr($sum);
	        $result .= $char;
	    }
	    $temp = base64_encode($result);
	    $temp = str_replace("+", "$$@$$", $temp);
	    return $temp;
	}
    public function ajax(Request $request)
    {  
        $tahun = Auth::user()->tahun ?? date('Y'); 
        $id_dinas = Auth::user()->opd_id;
        $data_kegiatan = MasterSubKegiatan::where('tahun', $tahun);
        if(!empty($id_dinas) && $id_dinas != 'null' ) { 
            $data_kegiatan = $data_kegiatan->where('opd_id', $id_dinas);
        }   
        $data_kegiatan = $data_kegiatan->get();

        if(empty(sizeof($data_kegiatan))){ 
            $data_kegiatan = MasterSubKegiatan::where('tahun', $tahun)->where('opd_id', 0)->get();
        }

        $data = DataTables::of($data_kegiatan)
                ->addIndexColumn() 
                ->addColumn('data', function($row){ 
                    $res = "<p style='width: 300px'><b>Program</b> = ".@$row->kegiatan->program->nama_program.
                    "<br><b>Kegiatan</b> = ".@$row->kegiatan->nama_kegiatan.
                    "<br><b>Sub Kegiatan</b> = ".@$row->nama_sub_kegiatan.
                    "</p>";
                    return $res;
                })
                ->addColumn('action', function($row){  
                    $res = "Program = ".@$row->kegiatan->program->nama_program.
                    " <button>asd</button> Kegiatan = ".@$row->kegiatan->nama_kegiatan."
                    ";
                    return $res;
                })  
                ->addColumn('aksi', function($row){ 
                $key = \Illuminate\Support\Facades\Crypt::encrypt($row->id);
                    $res = '';
                    if(Auth::user()->role_id == 1){
                        $res = " <a href='".route('edit_sub_kegiatan',$key)."' title='Ubah Data'  class='btn btn-icon btn-sm  btn-success'><i class='fa fa-edit'></i> ";
                    }
                    return $res;
                })
                ->rawColumns(['data', 'action','aksi']) 
                ->make(true); 
        return $data; 
    } 
    
    public function dataawal_progkeg()
    {
        /* mecahin kode yang nyampur */
        $datas = DB::table('dataawal_progkeg')->orderBy('id')->get();
        foreach($datas as $d)
        { 
            $urusan = explode(' ', $d->nama_urusan);
            $kode_urusan = $urusan[0];
            $nama_urusan = str_replace($kode_urusan.' ', '', $d->nama_urusan); 

            $opd = explode(' ', $d->nama_opd);
            $kode_opd = $opd[0];
            $nama_opd = str_replace($kode_opd.' ', '', $d->nama_opd); 
            
            $sub_opd = explode(' ', $d->nama_sub_opd);
            $kode_sub_opd = $sub_opd[0];
            $nama_sub_opd = str_replace($kode_sub_opd.' ', '', $d->nama_sub_opd); 
            
            $program = explode(' ', $d->nama_program);
            $kode_program = $program[0];
            $nama_program = str_replace($kode_program.' ', '', $d->nama_program); 
            
            $kegiatan = explode(' ', $d->nama_kegiatan);
            $kode_kegiatan = $kegiatan[0];
            $nama_kegiatan = str_replace($kode_kegiatan.' ', '', $d->nama_kegiatan); 
            
            $sub_kegiatan = explode(' ', $d->nama_sub_kegiatan);
            $kode_sub_kegiatan = $sub_kegiatan[0];
            $nama_sub_kegiatan = str_replace($kode_sub_kegiatan.' ', '', $d->nama_sub_kegiatan); 
            
            $rekening = explode(' ', $d->nama_rekening);
            $kode_rekening = $rekening[0];
            $nama_rekening = str_replace($kode_rekening.' ', '', $d->nama_rekening); 

            $update = DB::table('dataawal_progkeg')->where('id', $d->id)->update([
                'kode_urusan' => $kode_urusan,
                'nama_urusan' => $nama_urusan,
                'kode_opd' => $kode_opd,
                'nama_opd' => $nama_opd,
                'kode_sub_opd' => $kode_sub_opd,
                'nama_sub_opd' => $nama_sub_opd,
                'kode_program' => $kode_program,
                'nama_program' => $nama_program,
                'kode_kegiatan' => $kode_kegiatan,
                'nama_kegiatan' => $nama_kegiatan,
                'kode_sub_kegiatan' => $kode_sub_kegiatan,
                'nama_sub_kegiatan' => $nama_sub_kegiatan,
                'kode_rekening' => $kode_rekening,
                'nama_rekening' => $nama_rekening 
            ]);  
        }

        $datas = DB::table('dataawal_progkeg')->orderBy('id')->first();
        
        dd($datas);
    }
    
    public function dataawal_progkeg_syncopd()
    {
        /* insert opd */

        $del = Opd::where('id','<>',0)->delete();

        DB::statement("
            INSERT INTO opds (unit_id, unit_name, unit_id_sidirga)
            select distinct kode_sub_opd, nama_sub_opd, kode_opd
            from dataawal_progkeg
            order by kode_sub_opd
        ");
        DB::statement("
            UPDATE opds o 
            SET induk = (SELECT id FROM opds WHERE unit_id=o.unit_id_sidirga)
            where unit_id <> unit_id_sidirga
        ");

    }
    
    public function dataawal_progkeg_programkegiatan()
    {
        /* insert program s/d sub kegiatan */
        $sync_kode = date('YmdHis') . '_' . rand(1000,9999);
        $opds = Opd::all();

        foreach($opds as $o)
        {
            $jmlsub=0;
            $programs = DB::table("dataawal_progkeg")
            ->where('kode_sub_opd', $o->unit_id)
            ->select('kode_urusan', 'nama_urusan', 'kode_program','nama_program')
            ->distinct()
            ->get();
            foreach($programs as $p)
            {
                $np = new MasterProgram();
                $np->opd_id = $o->id;
                $np->kode_urusan = $p->kode_urusan;
                $np->kode_program = $p->kode_program;
                $np->nama_program = $p->nama_program;
                $np->sync_kode = $sync_kode;
                $np->tahun = 2023;
                $np->save();

                $kegiatans = DB::table("dataawal_progkeg")
                ->where('kode_sub_opd', $o->unit_id)
                ->where('kode_program', $p->kode_program)
                ->select('kode_urusan', 'nama_urusan', 'kode_program','nama_program', 'kode_kegiatan','nama_kegiatan')
                ->distinct()
                ->get();
                foreach($kegiatans as $k)
                {
                    $nk = new MasterKegiatan();
                    $nk->opd_id = $o->id;
                    $nk->master_program_id = $np->id; 
                    $nk->kode_kegiatan = $k->kode_kegiatan;
                    $nk->nama_kegiatan = $k->nama_kegiatan;
                    $nk->sync_kode = $sync_kode;
                    $nk->tahun = 2023;
                    $nk->save(); 

                    $subkegiatans = DB::table("dataawal_progkeg")
                    ->where('kode_sub_opd', $o->unit_id)
                    ->where('kode_program', $p->kode_program)
                    ->where('kode_kegiatan', $k->kode_kegiatan)
                    ->select('kode_urusan', 'nama_urusan', 'kode_program','nama_program', 'kode_kegiatan','nama_kegiatan', 'kode_sub_kegiatan','nama_sub_kegiatan')
                    ->distinct()
                    ->get();
                    foreach($subkegiatans as $k)
                    {
                        $ns = new MasterSubKegiatan();
                        $ns->opd_id = $o->id;
                        $ns->master_kegiatan_id = $nk->id;  
                        $ns->kode_sub_kegiatan = $k->kode_sub_kegiatan;
                        $ns->nama_sub_kegiatan = $k->nama_sub_kegiatan; 
                        $ns->sync_kode = $sync_kode;
                        $ns->tahun = 2023;
                        $ns->save();
                        $jmlsub++;

                        $rekenings = DB::table("dataawal_progkeg")
                        ->where('kode_sub_opd', $o->unit_id)
                        ->where('kode_program', $p->kode_program)
                        ->where('kode_kegiatan', $k->kode_kegiatan)
                        ->where('kode_sub_kegiatan', $k->kode_sub_kegiatan) 
                        ->get();
                        foreach($rekenings as $r)
                        {
                            if(!empty($r->kode_rekening))
                            {
                                $nr = new RincianRekening();
                                $nr->opd_id = $o->id;
                                $nr->unit_id = $o->unit_id;
                                $nr->master_sub_kegiatan_id = $ns->id;  
                                $nr->kode_sub_kegiatan = $k->kode_sub_kegiatan;
                                $nr->kode_rekening = $r->kode_rekening;
                                $nr->nama_rekening = $r->nama_rekening; 
                                $nr->harga = $r->total; 
                                $nr->sync_kode = $sync_kode;
                                $nr->tahun = 2023;
                                $nr->save(); 


                                // $nd = new Detail();
                                // $nd->opd_id = $o->id;
                                // $nd->unit_id = $o->unit_id;
                                // $nd->master_sub_kegiatan_id = $ns->id;  
                                // $nd->kode_sub_kegiatan = $k->kode_sub_kegiatan;
                                // $nd->rekenings_id = $nr->id;
                                // $nr->kode_rekening = $r->kode_rekening;
                                // $nd->nama_rekening = $r->nama_rekening; 
                                // $nr->kode_detail = $r->kode_rekening;
                                // $nd->detail = $r->nama_rekening; 
                                // $nd->volume = 1; 
                                // $nr->harga = $r->total;
                                // $nr->koefisien = '1 Data Awal';
                                // $nd->sync_kode = $sync_kode;
                                // $nd->tahun = 2023;
                                // $nd->save(); 
                            }
                        }
                    }
                }
            }
            echo $o->unit_name . ' -- ' . $jmlsub . '<br>'; 

            $q="INSERT INTO detail (opd_id, unit_id, master_sub_kegiatan_id, kode_sub_kegiatan, rekenings_id, kode_rekening, nama_rekening,kode_detail, detail, volume, harga, koefisien, sync_kode, tahun) 
            SELECT opd_id, unit_id, master_sub_kegiatan_id, kode_sub_kegiatan, id, kode_rekening, nama_rekening,kode_rekening, nama_rekening, 1, harga, '1 Data Awal', sync_kode, tahun 
            FROM rekenings
            ";
        }

    }



    public function sub_kegiatan_rincian(Request $request)
    {
        $tahun = Auth::user()->tahun;
        $opd_id = Auth::user()->opd_id;
        
        $opd = Opd::find($opd_id);
         
        $data_sub_kegiatan = MasterSubKegiatan::where('opd_id', $opd_id)
            ->where('tahun', $tahun) 
            ->orderBy('kode_sub_kegiatan')
            ->get(); 
        
        $data_opd = Opd::orderBy('unit_id')->get();
        return view('sub_kegiatan.rincian',['nama_header'=>'Rincian Sub kegiatan'],
            compact('data_sub_kegiatan', 'opd_id', 'opd', 'tahun','data_opd')
        );

        // return response($fusion);
    }

    public function pindah_sub_kegiatan(Request $request)
    {
        if (!empty($request->id_sub_kegiatan)) {
            $list_kegiatan = explode(', ', $request->id_sub_kegiatan);
            $kegiatan = MasterSubKegiatan::whereIn('id', $list_kegiatan)->update([
                'opd_id' => $request->opd_id,
            ]);
            return back()->with('status', 'Data berhasil dipindah');
        } else {
            return back()->with('statusGagal', 'Data Gagal dipindah, Pastikan sudah mencentang pada kolom sub kegiatan !!');
        }
    } 

    public function sub_kegiatan_rincian_detail(Request $request)
    {
        $id_sub_kegiatan = $request->id_sub_kegiatan; 
        $sub_keg = MasterSubKegiatan::find($id_sub_kegiatan);
        $kode_sub_kegiatan = $sub_keg->kode_sub_kegiatan;
        $unit_id = $sub_keg->opd->unit_id;

    	$details = Detail::select('master_sub_kegiatan_id', 'subtitle')
                    ->where('master_sub_kegiatan_id', $id_sub_kegiatan)
                    ->distinct()
                    ->orderBy('subtitle')
                    ->get(); 
        return view('sub_kegiatan.detail', compact('id_sub_kegiatan', 'sub_keg', 'kode_sub_kegiatan', 'unit_id','details') );
        

    }
}