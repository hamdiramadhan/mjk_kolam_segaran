<?php

namespace App\Http\Controllers;

use App\Models\JenisInstansi;
use App\Models\Opd;
use DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OpdController extends Controller
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
        $opds = Opd::whereNull('induk')->orderBy('unit_id')->get(); 
        if(Auth::user()->role_id == 2){
            $opds = Opd::where('id',Auth::user()->opd_id)->get(); 
        }
        
        return view('master_opd.index', ['nama_header'=> 'Master SKPD'],compact('opds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis_instansis = JenisInstansi::all();
        return view('master_opd.create', ['nama_header'=> 'Master SKPD'], compact('jenis_instansis'));
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
            $opd->jenis_instansi_id  = $request->jenis_instansi_id;
            $opd->unit_id  = $request->unit_id;
            $opd->unit_id_sidirga  = $request->unit_id_sidirga;
            $opd->unit_name  = $request->unit_name;
            $opd->kepala_nama  = $request->kepala_nama;
            $opd->kepala_nip  = $request->kepala_nip;
            $opd->kepala_pangkat  = $request->kepala_pangkat;
            $opd->kepala_jabatan  = $request->kepala_jabatan;
            $opd->max_operator  = $request->max_operator;
            $opd->alamat  = $request->alamat;
            $opd->telp  = $request->telp;
            $opd->fax  = $request->fax;
            $opd->save();
            session()->put('status', 'SKPD baru berhasil ditambahkan! ' );
        }

        return redirect()->route('master_opd');
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
        $key = urldecode($key);
        $zz = $this->hamdi_decrypt($key, 'progstylysbyhamdi');
        $arr = explode("##", $zz);
        $id = $arr[1]; 
        $opd = Opd::find($id); 
        $jenis_instansis = JenisInstansi::all();
        return view('master_opd.edit',['nama_header'=> 'Master SKPD'],compact('opd','jenis_instansis'));
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
        $opd->jenis_instansi_id  = $request->jenis_instansi_id;
        $opd->unit_id  = $request->unit_id;
        $opd->unit_id_sidirga  = $request->unit_id_sidirga;
        $opd->unit_name  = $request->unit_name;
        $opd->kepala_nama  = $request->kepala_nama;
        $opd->kepala_nip  = $request->kepala_nip;
        $opd->kepala_pangkat  = $request->kepala_pangkat;
        $opd->kepala_jabatan  = $request->kepala_jabatan;
        $opd->max_operator  = $request->max_operator;
        $opd->alamat  = $request->alamat;
        $opd->telp  = $request->telp;
        $opd->fax  = $request->fax;
        $opd->save();
        session()->put('status', 'SKPD baru berhasil diubah! ' );
        return redirect()->route('master_opd');
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
        session()->put('status', 'Data SKPD dengan nama: ' . $data->nama . ', Berhasil dihapus!');
        $data->delete();
        return redirect()->back();
    }
    public function opd_aktif_usul(Request $request)
    {
        $tipe = $request->tipe;
        $id = $request->id; 
        $val = $request->val; 

        $data = Opd::whereRaw(" id in ({$id}) ")->get();
        foreach ($data as $r) {
            $update = Opd::where('id', $r->id)->update(['aktif_usul'=>$val]);
        } 
        return response()->json(array(
            'status'=>'success',
            'msg'=>"Data berhasil Disimpan",
            'id'=>$id
        ),200); 
    }
    public function aktif_usulan(Request $request)
    {  
        $tipe = $request->tipe;
        $id = $request->id; 
        $val = $request->val; 

        $data = Opd::whereRaw(" id in ({$id}) ")->get();
        foreach ($data as $r) {
            $update = Opd::where('id', $r->id)->update(['aktif_usul'=>$val]);
        } 

        return 'success';
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