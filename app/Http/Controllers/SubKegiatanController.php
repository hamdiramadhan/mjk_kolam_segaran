<?php

namespace App\Http\Controllers;

use App\Imports\ImportKegiatan;
use App\Imports\ImportKegiatan2;
use App\Models\MasterSubKegiatan;
use App\Models\MasterKegiatan;
use App\Models\Menu;
use App\Models\Opd;
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
        return view('pokja_sub_kegiatan.index', ['nama_header'=> 'Sub Kegiatan']);
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
        return view('pokja_sub_kegiatan.create', ['nama_header'=> 'Master Sub Kegiatan'],compact('kegiatan','satuan'));   
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
        return view('pokja_sub_kegiatan.edit',['nama_header'=> 'Master Sub Kegiatan'],compact('kegiatan','sub_keg'));
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
        return view('pokja_sub_kegiatan.edit',['nama_header'=> 'Master Sub Kegiatan'],compact('kegiatan','sub_keg','satuan'));
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
        $opds = Opd::all();

        foreach($opds as $o)
        {
            dd($o);
        }

    }
}