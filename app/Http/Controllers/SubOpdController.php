<?php

namespace App\Http\Controllers;

use App\Models\JenisInstansi;
use App\Models\Opd;
use DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubOpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function index()
    { 
        $opds = Opd::whereNotNull('induk')->orderBy('induk')->orderBy('unit_id')->get(); 
        if(Auth::user()->role_id == 2){
            $opds = Opd::where('id',Auth::user()->opd_id)->get(); 
        }
        
        return view('master_sub_opd.index', ['nama_header'=> 'Master Sub OPD'],compact('opds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $opdinduks = Opd::whereNull('induk')->orderBy('unit_id')->get(); 
        $jenis_instansis = JenisInstansi::all();
        return view('master_sub_opd.create', ['nama_header'=> 'Master Sub OPD'], compact('jenis_instansis','opdinduks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required|unique:opds,unit_id',
            'unit_name' => 'required'
        ]); 
        if ($validator->fails()) {
            $msg = "";
            foreach ($validator->messages()->all() as $message) {
                $msg .= $message . ".
                ";
            }
            session()->put('statusT', '' . $msg);
        } else {
            $opd = new Opd();
            $opd->induk  = $request->induk;
            $opd->jenis_instansi_id  = $request->jenis_instansi_id;
            $opd->unit_id  = $request->unit_id;
            $opd->unit_id_sidirga  = $request->unit_id_sidirga;
            $opd->unit_name  = $request->unit_name;
            $opd->kepala_nama  = $request->kepala_nama;
            $opd->kepala_nip  = $request->kepala_nip;
            $opd->kepala_pangkat  = $request->kepala_pangkat;
            $opd->kepala_jabatan  = $request->kepala_jabatan; 
            $opd->alamat  = $request->alamat;
            $opd->telp  = $request->telp;
            $opd->fax  = $request->fax;
            $opd->save();
            session()->put('status', 'OPD baru berhasil ditambahkan! ' );
        }

        return redirect()->route('master_sub_opd');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Opd  $unitKerja
     * @return \Illuminate\Http\Response
     */
    public function show(Opd $unitKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Opd  $unitKerja
     * @return \Illuminate\Http\Response
     */
    
    public function edit($key)
    {
        $jenis_instansis = JenisInstansi::all();
        $key = urldecode($key);
        $zz = $this->hamdi_decrypt($key, 'progstylysbyhamdi');
        $arr = explode("##", $zz);
        $id = $arr[1]; 
        $opd = Opd::find($id); 
        $opdinduks = Opd::whereNull('induk')->orderBy('unit_id')->get(); 
        return view('master_sub_opd.edit',['nama_header'=> 'Master Sub OPD'],compact('opd','jenis_instansis','opdinduks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Opd  $unitKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $opd = Opd::find($id);
        $opd->induk  = $request->induk;
        $opd->jenis_instansi_id  = $request->jenis_instansi_id;
        $opd->unit_id  = $request->unit_id;
        $opd->unit_id_sidirga  = $request->unit_id_sidirga;
        $opd->unit_name  = $request->unit_name;
        $opd->kepala_nama  = $request->kepala_nama;
        $opd->kepala_nip  = $request->kepala_nip;
        $opd->kepala_pangkat  = $request->kepala_pangkat;
        $opd->kepala_jabatan  = $request->kepala_jabatan; 
        $opd->alamat  = $request->alamat;
        $opd->telp  = $request->telp;
        $opd->fax  = $request->fax;
        $opd->save();
        session()->put('status', 'OPD baru berhasil diubah! ' );
        return redirect()->route('master_sub_opd');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Opd  $unitKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Opd::find($id);
        session()->put('status', 'Data Sub OPD dengan nama: ' . $data->nama . ', Berhasil dihapus!');
        $data->delete();
        return redirect()->back();
    }

    public function hamdi_decrypt($string, $key = '%key&')
    {
        $result = '';
        $string = str_replace("$$@$$", "+", $string);
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $ordChar = ord($char);
            $ordKeychar = ord($keychar);
            $sum = $ordChar - $ordKeychar;
            $char = chr($sum);
            $result .= $char;
        }
        return $result;
    }
}