<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        $nama_header ='Master User';
        return view('master_user.index',['nama_header'=>$nama_header],compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::All();   
        $nama_header ='Master User';
        $list_opd = Opd::whereNull('induk')->orderBy('unit_id')->get();
        if(Auth::user()->role_id == 2 && !empty(Auth::user()->opd_id)){
            $list_opd = Opd::orderBy('unit_id')->where('id',Auth::user()->opd_id)->get();
        }
        if(Auth::user()->role_id == 3)
        {
            $role = Role::where('id', 2)->get();
            $list_opd = Opd::orderBy('unit_id')->where('id',Auth::user()->opd_id)->get();
        }
        return view('master_user.create',['nama_header'=>$nama_header],compact('role','list_opd'));
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
            'username' => 'unique:users,username',
            'password' => 'required',
            'email' => 'unique:users,email',
            're_password' => 'required|same:password'
        ], [
            'username.unique:users,username' => 'Data username sudah ada',
            'email.unique:users,email' => 'Data email sudah ada',
            'password.required' => 'Password harus diisi',
            're_password.same:password' => 'Password harus sama'
        ]);
        if ($validator->fails()) {
            $msg = "";
            foreach ($validator->messages()->all() as $message) {
                $msg .= $message . ".
                ";
            }
            session()->put('statusT', 'Kesalahan pengisian form tambah: ' . $msg);
        } else {
            $user = new User();
            $user->name= $request->name;
            $user->username= $request->username;
            $user->email = $request->email;
            $user->no_hp = $request->no_hp;
            $user->password = Hash::make($request->password);
            $user->role_id = $request->role_id;
            $user->opd_id = $request->opd_id;
            $user->tahun = $request->tahun;
            $user->save();
            // $user->assignRole($request->role);
            session()->put('status', 'User baru berhasil ditambahkan! ' );
        }
        return redirect()->route('users.index');
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
        $user = User::find($id);
        $roles = Role::all();

        $userRole = null;
        if($user->roles){
            $userRole = @$user->roles->first();
        }
        $list_opd = Opd::whereNull('induk')->orderBy('unit_id')->get();
        if(Auth::user()->role_id == 2 && !empty(Auth::user()->opd_id)){
            $list_opd = Opd::orderBy('unit_id')->where('id',Auth::user()->opd_id)->get();
        }
        if(Auth::user()->role_id == 3)
        {
            $roles = Role::where('id', 2)->get();
            $list_opd = Opd::orderBy('unit_id')->where('id',Auth::user()->opd_id)->get();
        }
        return view('master_user.edit', ['nama_header'=> 'Master User'],compact('user','roles','userRole','list_opd'));

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
        $id = decrypt(($id));
        $user = User::find($id); 
        $user->name= $request->name;
        $user->username= $request->username;
        $user->no_hp= $request->no_hp;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->opd_id = $request->opd_id;
        $user->tahun = $request->tahun;
        $user->save();
        // FacadesDB::table('model_has_roles')->where('model_id',$id)->delete();
        // $user->assignRole($request->role);

        if(!empty($request->password)){
            if($request->password == $request->re_password)
            {
                $user->password = Hash::make($request->password);
                $user->save();
            } else { 
                session()->put('status', 'User '.$user->name.' berhasil diubah, password tidak sama! ' );
                return redirect()->route('users.index');
            }
        }
        session()->put('status', 'User '.$user->name.' berhasil diubah! ' );
        return redirect()->route('users.index');
        
    }

    public function insert_user()
    {
        $user = User::where('role_id',2)->delete();
        $opd = Opd::all();
        foreach($opd as $r){
            $user = new User();
            $user->name = $r->unit_name;
            $user->email = $r->unit_name.'@gmail.com';
            $user->username = $r->unit_id;
            $user->password = bcrypt($r->unit_id);
            $user->opd_id = $r->id;
            $user->role_id = 2;
            $user->save();
        }
        

        
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
        $data = User::find($id);
        session()->put('status', 'Data User dengan nama: ' . $data->nama . ', Berhasil dihapus!');
        $data->delete();
        return redirect()->back();
    }
}