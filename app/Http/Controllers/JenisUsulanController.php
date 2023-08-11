<?php

namespace App\Http\Controllers;

use App\Models\PengajuanUsulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisUsulanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisUsulan = PengajuanUsulan::all();
        $nama_header = 'Jenis Usulan';
        return view('master_usulan.index',['nama_header'=>$nama_header],compact('jenisUsulan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nama_header = 'Jenis Usulan';
        return view('master_usulan.create',['nama_header'=>$nama_header]);
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
            'usulan' => 'unique:pengajuan_usulans,usulan',
        ], [
            'usulan.unique:pengajuan_usulans,usulan' => 'Data Pengajuan sudah ada',
        ]);
        if ($validator->fails()) {
            $msg = "";
            foreach ($validator->messages()->all() as $message) {
                $msg .= $message . ".
                ";
            }
            session()->put('statusT', 'Kesalahan pengisian form tambah: ' . $msg);
        } else {
            $user = new PengajuanUsulan();
            $user->usulan= $request->usulan;
            $user->save();
            // $user->assignRole($request->role);
            session()->put('status', 'Jenis Usulan baru berhasil ditambahkan! ' );
        }
        return redirect()->route('jenis_usulan.index');
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
        $usulan = PengajuanUsulan::find($id);
        $nama_header = 'Jenis Usulan';
        return view('master_usulan.edit',['nama_header'=>$nama_header],compact('id','usulan'));
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
        $usulan = PengajuanUsulan::find($id);
        $usulan->usulan=$request->usulan;
        $usulan->save();

        session()->put('status', 'Jenis Usulan berhasil diubah! ' );
        return redirect()->route('jenis_usulan.index');

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
        $data = PengajuanUsulan::find($id);
        session()->put('status', 'Data Usulan dengan nama: ' . $data->nama . ', Berhasil dihapus!');
        $data->delete();
        return redirect()->back();
    }
}