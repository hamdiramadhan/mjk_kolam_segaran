<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function change_tahun_app_login(Request $request)
    {
        if (!empty($request->id_skpd)) {

            if ($request->id_skpd != 'global') {
                $opd = Opd::find($request->id_skpd);
            }
            $user = User::findOrFail(Auth::user()->id);
            $user->opd_id = $opd->id ?? 0;
            $user->tahun = $request->tahun;
            $user->save();

            session()->put('status', 'Setting berhasil disimpan!');
        }
        return back();
    }
}
