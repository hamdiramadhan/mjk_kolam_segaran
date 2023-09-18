<?php

namespace App\Http\Controllers;

use App\Models\Fase;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opds = Fase::orderBy('id')
            ->get();  
        
        return view('fase.index', ['nama_header'=> 'Master Fase'],compact('opds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $nama_header = 'Tambah Data';
        return view('fase.create',['nama_header'=>$nama_header]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $new = new Fase();
        $new->kode = $request->kode;
        $new->nama = $request->nama;
        $new->tahun = $request->tahun;
        $new->mulai = $request->mulai;
        $new->selesai = $request->selesai;
        $new->save();
        session()->put('status', 'Data baru berhasil ditambahkan! ' );
        return redirect()->route('fase.index');
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
        $data = Fase::find($id);
        $nama_header = 'Ubah Data';
        return view('fase.edit',['nama_header'=>$nama_header], compact('data'));
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
        $new = Fase::find($id);
        $new->kode = $request->kode;
        $new->nama = $request->nama;
        $new->tahun = $request->tahun;
        $new->mulai = $request->mulai;
        $new->selesai = $request->selesai;
        $new->save();
        session()->put('status', 'Data berhasil diubah! ' );
        return redirect()->route('fase.index');
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
