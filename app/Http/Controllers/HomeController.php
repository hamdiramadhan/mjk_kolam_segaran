<?php

namespace App\Http\Controllers;

use App\Models\Fase;
use App\Models\Opd;
use App\Models\Pengajuan;
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
        $pengajuan = Pengajuan::all();
        $fases = Fase::All();
        $opd= Opd::all();
        
        return view('home',compact('pengajuan','fases','opd'));
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
    public function calendar_dashboard() 
    {

        $pengajuan = Pengajuan::where('tahun',Auth::user()->tahun)->where('opd_id',Auth::user()->opd_id)->get();
        $events = [];
        foreach ($pengajuan as $data) {
            $event = [
                'id' => encrypt($data->id),
                'title' => $data->nomor_surat,
                'start' => $data->tanggal_surat,
                'end' => $data->tanggal_surat,
            ];
    
            switch ($data->status) {
                case 0:
                    $event['backgroundColor'] = 'blue';
                    break;
                case 1:
                    $event['backgroundColor'] = 'orange';
                    break;
                case 2:
                    $event['backgroundColor'] = 'green';
                    break;
                default:
                    $event['backgroundColor'] = 'red';
                    break;
            }
            $events[] = $event;
        }
    
        // dd($events);
        return response()->json($events);
    }
    public function generateDocx()
    {
//         $phpWord = new \PhpOffice\PhpWord\PhpWord();


//         $section = $phpWord->addSection();


//         $description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
// tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
// quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
// consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
// cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
// proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
//         $view = view('home.word',compact('description'))->render();

//         // $section->addImage("https://supertuntas.egovsuperapp.id/sampang_logo.png");
//         $section->addText($view);
        

//         $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
//         try {
//             $objWriter->save(storage_path('helloWorld.docx'));
//         } catch (Exception $e) {
//         }


//         return response()->download(storage_path('helloWorld.docx'));

        $headers = array(
            'Content-type'=>'text/html',
            'Content-Disposition'=>'attatchement;Filename=mydoc.doc',
        );

        return \Response::make(view('home.word'),200,$headers);
    }
}