<?php

namespace App\Http\Controllers;

use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SumberDanaController extends Controller
{
    public function index()
    {
        $sumber_dana = SumberDana::all();
        $nama_header = 'Sumber Dana';
        return view('master_sumber_dana.index',['nama_header'=>$nama_header],compact('sumber_dana'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nama_header = 'Sumber Dana';
        return view('master_sumber_dana.create',['nama_header'=>$nama_header]);
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
            'nama' => 'unique:sumber_danas,nama',
        ], [
            'nama.unique:sumber_danas,nama' => 'Data Nama sudah ada',
        ]);
        if ($validator->fails()) {
            $msg = "";
            foreach ($validator->messages()->all() as $message) {
                $msg .= $message . ".
                ";
            }
            session()->put('statusT', 'Kesalahan pengisian form tambah: ' . $msg);
        } else {
            $user = new SumberDana();
            $user->nama= $request->nama;
            $user->keterangan= $request->keterangan;
            $user->save();
            // $user->assignRole($request->role);
            session()->put('status', 'Sumber Dana baru berhasil ditambahkan! ' );
        }
        return redirect()->route('sumber_dana.index');
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
        $sumber_dana = SumberDana::find($id);
        $nama_header = 'Sumber Dana';
        return view('master_sumber_dana.edit',['nama_header'=>$nama_header],compact('id','sumber_dana'));
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
        $sumber_dana = SumberDana::find($id);
        $sumber_dana->nama=$request->nama;
        $sumber_dana->keterangan=$request->keterangan;
        $sumber_dana->save();

        session()->put('status', 'Sumber Dana berhasil diubah! ' );
        return redirect()->route('sumber_dana.index');

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
        $data = SumberDana::find($id);
        session()->put('status', 'Data Sumber Dana dengan nama: ' . $data->nama . ', Berhasil dihapus!');
        $data->delete();
        return redirect()->back();
    }
}