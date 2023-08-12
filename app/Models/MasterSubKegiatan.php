<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterSubKegiatan extends Model
{
    protected $table = "master_sub_kegiatan";


    public function get_total_komponen($master_sub_kegiatan_id)
    { 
        $data = RincianRekening::where('master_sub_kegiatan_id', $master_sub_kegiatan_id)
            ->select(DB::raw("SUM(harga) as jumlah")) 
            ->first();
        return $data->jumlah;
    }

    public function kegiatan()
    {
        return $this->belongsTo(MasterKegiatan::class, 'master_kegiatan_id', 'id');
    }

    public static function get_prog_keg_subkeg($tahun, $opd_id = "")
    {
        $res = array();
        $data = MasterProgram::orderBy('kode_program')
            ->whereExists(function ($query) {
                $query->select("master_kegiatan.master_program_id")
                    ->from('master_kegiatan')
                    ->whereRaw('master_kegiatan.master_program_id = master_program.id');
            })
            ->where('tahun', $tahun)
            ->get();
        foreach ($data as $row) {
            $data = [
                'jenis' => 'program', 'id' => @$row->id, 'kode' => @$row->kode_program, 'nama' => @$row->nama_program
            ];
            if (!in_array($data, $res)) {
                array_push($res, $data);
            }
            $arr_kegiatan = array();
            $data_kegiatan = MasterKegiatan::orderBy('kode_kegiatan')
                ->whereExists(function ($query) {
                    $query->select("master_sub_kegiatan.master_kegiatan_id")
                        ->from('master_sub_kegiatan')
                        ->whereRaw('master_sub_kegiatan.master_kegiatan_id = master_kegiatan.id');
                })
                ->where('master_program_id', $row->id)
                ->where('tahun', $tahun)
                ->get();
            foreach ($data_kegiatan as $r_keg) {
                $arr_sub_kegiatan = array();

                $kegiatan = [
                    'jenis' => 'kegiatan', 'id' => @$r_keg->id, 'kode' => @$r_keg->kode_kegiatan, 'nama' => @$r_keg->nama_kegiatan
                ];
                if (!in_array($kegiatan, $res)) {
                    array_push($res, $kegiatan);
                }

                $data_sub_kegiatan = MasterSubKegiatan::orderBy('kode_sub_kegiatan')
                    ->where('master_kegiatan_id', $r_keg->id)
                    ->where('tahun', $tahun)
                    ->get();
                foreach ($data_sub_kegiatan as $r_sub_keg) {
                    $sub_kegiatan = [
                        'jenis' => 'sub_kegiatan', 'id' => @$r_sub_keg->id, 'kode' => @$r_sub_keg->kode_sub_kegiatan, 'nama' => @$r_sub_keg->nama_sub_kegiatan
                    ];
                    if (!in_array($sub_kegiatan, $res)) {
                        array_push($res, $sub_kegiatan);
                    }
                }
            }
        }

        return $res;
    }

    public static function get_prog($tahun, $opd_id = "", $id_rkbmd_map = "")
    { 
        $res = array();
        $data = MasterProgram::orderBy('kode_program')
            ->whereExists(function ($query) use ($opd_id, $id_rkbmd_map, $tahun) {
                $query->select("master_kegiatan.master_program_id")
                    ->from('master_kegiatan')
                    ->whereRaw('master_kegiatan.master_program_id = master_program.id')
                    ->whereExists(function ($query2) use ($opd_id, $id_rkbmd_map, $tahun) {
                        $query2->select("master_sub_kegiatan.master_kegiatan_id")
                            ->from('master_sub_kegiatan')
                            ->whereRaw('master_sub_kegiatan.master_kegiatan_id = master_kegiatan.id')
                            ->where('tahun', $tahun);
                        if (!empty($opd_id)) {
                            $query2->where('opd_id', $opd_id);
                        }
                    });
            }) 
            ->select('id', 'kode_program', 'nama_program')
            ->distinct()
            ->get();
        if (sizeof($data) <= 0) { 
            $data = MasterProgram::orderBy('kode_program')
                ->whereExists(function ($query) use ($tahun) {
                    $query->select("master_kegiatan.master_program_id")
                        ->from('master_kegiatan')
                        ->whereRaw('master_kegiatan.master_program_id = master_program.id')
                        ->whereExists(function ($query2) use ($tahun) {
                            $query2->select("master_sub_kegiatan.master_kegiatan_id")
                                ->from('master_sub_kegiatan')
                                ->whereRaw('master_sub_kegiatan.master_kegiatan_id = master_kegiatan.id')
                                ->whereRaw(" (opd_id = 0 or opd_id is null) ")
                                ->where('tahun', $tahun);
                        });
                })
                ->select('id', 'kode_program', 'nama_program')
                ->distinct()
                ->get(); 
        }

        return $data;
    }
    public static function get_prog_keg_by_id_program($id_program, $id_opd)
    {
        $program = MasterProgram::findOrFail($id_program);

        $data = MasterKegiatan::orderBy('kode_kegiatan')
            ->whereExists(function ($query) use ($id_program, $id_opd) {
                $query->select("master_sub_kegiatan.master_kegiatan_id")
                    ->from('master_sub_kegiatan')
                    ->whereRaw('master_sub_kegiatan.master_kegiatan_id = master_kegiatan.id');
                if (!empty($id_opd)) {
                    $query->where('opd_id', $id_opd);
                }
            })
            ->where('master_program_id', $program->id)
            ->where('tahun', $program->tahun)
            ->get();
        if (sizeof($data) <= 0) {
            $data = MasterKegiatan::orderBy('kode_kegiatan')
                ->whereExists(function ($query) use ($id_program, $id_opd) {
                    $query->select("master_sub_kegiatan.master_kegiatan_id")
                        ->from('master_sub_kegiatan')
                        ->whereRaw('master_sub_kegiatan.master_kegiatan_id = master_kegiatan.id');
                    if (!empty($id_opd)) {
                        $query->whereRaw('(opd_id is null or opd_id=0)');
                    }
                })
                ->where('master_program_id', $program->id)
                ->where('tahun', $program->tahun)
                ->get();
        }
        return $data;
    }
    public static function get_prog_sub_keg_by_id_kegiatan($id_kegiatan, $id_opd)
    {
        $kegiatan = MasterKegiatan::findOrFail($id_kegiatan);

        $data_sub_kegiatan = MasterSubKegiatan::orderBy('kode_sub_kegiatan')
            ->where('master_kegiatan_id', $kegiatan->id)
            ->where('tahun', $kegiatan->tahun);
        if (!empty($id_opd)) {
            $data_sub_kegiatan->where('opd_id', $id_opd);
        }
        $data_sub_kegiatan = $data_sub_kegiatan->get();

        if (sizeof($data_sub_kegiatan) <= 0) {
            $data_sub_kegiatan = MasterSubKegiatan::orderBy('kode_sub_kegiatan')
                ->where('master_kegiatan_id', $kegiatan->id)
                ->where('tahun', $kegiatan->tahun);
            if (!empty($id_opd)) {
                $data_sub_kegiatan->whereRaw('(opd_id is null or opd_id=0)');
            }
            $data_sub_kegiatan = $data_sub_kegiatan->get();
        }

        return $data_sub_kegiatan;
    }

    public static function get_prog_keg_subkeg_bertingkat($tahun, $opd_id = "", $id_rkbmd_map = "")
    {
        $res = array();
        $data = MasterProgram::orderBy('kode_program')
            ->whereExists(function ($query) use ($opd_id, $id_rkbmd_map) {
                $query->select("master_kegiatan.master_program_id")
                    ->from('master_kegiatan')
                    ->whereRaw('master_kegiatan.master_program_id = master_program.id')
                    ->whereExists(function ($query2) use ($opd_id, $id_rkbmd_map) {
                        $query2->select("master_sub_kegiatan.master_kegiatan_id")
                            ->from('master_sub_kegiatan')
                            ->whereRaw('master_sub_kegiatan.master_kegiatan_id = master_kegiatan.id');
                        if (!empty($opd_id)) {
                            $query2->where('opd_id', $opd_id);
                        }
                    });
            })
            ->where('tahun', $tahun)
            ->get();
        foreach ($data as $row) {
            $arr_kegiatan = array();
            $data_kegiatan = MasterKegiatan::orderBy('kode_kegiatan')
                ->whereExists(function ($query) use ($opd_id, $id_rkbmd_map) {
                    $query->select("master_sub_kegiatan.master_kegiatan_id")
                        ->from('master_sub_kegiatan')
                        ->whereRaw('master_sub_kegiatan.master_kegiatan_id = master_kegiatan.id');
                    if (!empty($opd_id)) {
                        $query->where('opd_id', $opd_id);
                    }
                })
                ->where('master_program_id', $row->id)
                ->where('tahun', $tahun)
                ->get();
            foreach ($data_kegiatan as $r_keg) {
                $arr_sub_kegiatan = array();

                $data_sub_kegiatan = MasterSubKegiatan::orderBy('kode_sub_kegiatan')
                    ->where('master_kegiatan_id', $r_keg->id)
                    ->where('tahun', $tahun);
                if (!empty($opd_id)) {
                    $data_sub_kegiatan->where('opd_id', $opd_id);
                }
                $data_sub_kegiatan = $data_sub_kegiatan->get();
                foreach ($data_sub_kegiatan as $r_sub_keg) {
                    $sub_kegiatan = [
                        'jenis' => 'sub_kegiatan', 'id' => $r_sub_keg->id, 'kode_sub_kegiatan' => @$r_sub_keg->kode_sub_kegiatan, 'nama_sub_kegiatan' => @$r_sub_keg->nama_sub_kegiatan
                    ];
                    if (!in_array($sub_kegiatan, $arr_sub_kegiatan)) {
                        array_push($arr_sub_kegiatan, $sub_kegiatan);
                    }
                }

                $kegiatan = [
                    'jenis' => 'kegiatan', 'kode_kegiatan' => @$r_keg->kode_kegiatan, 'nama_kegiatan' => @$r_keg->nama_kegiatan, 'data_sub_kegiatan' => $arr_sub_kegiatan
                ];
                if (!in_array($kegiatan, $arr_kegiatan)) {
                    array_push($arr_kegiatan, $kegiatan);
                }
            }
            $program = [
                'jenis' => 'program', 'kode_program' => @$row->kode_program, 'nama_program' => @$row->nama_program, 'data_kegiatan' => $arr_kegiatan
            ];
            if (!in_array($program, $res)) {
                array_push($res, $program);
            }
        }

        return $res;
    }

    public static function get_prog_keg_subkeg_rkbmd($tahun, $opd_id = "", $id_rkbmd_map = "")
    {
        $res = array();
        $data = MasterProgram::orderBy('kode_program')
            ->whereExists(function ($query) use ($opd_id, $id_rkbmd_map) {
                $query->select("master_kegiatan.master_program_id")
                    ->from('master_kegiatan')
                    ->whereRaw('master_kegiatan.master_program_id = master_program.id')
                    ->whereExists(function ($query2) use ($opd_id, $id_rkbmd_map) {
                        $query2->select("master_sub_kegiatan.master_kegiatan_id")
                            ->from('master_sub_kegiatan')
                            ->whereRaw('master_sub_kegiatan.master_kegiatan_id = master_kegiatan.id');
                        if (!empty($opd_id)) {
                            $query2->whereExists(function ($query3) use ($opd_id, $id_rkbmd_map) {
                                $query3->select("rkbmd.master_sub_kegiatan_id")
                                    ->from('rkbmd_detail as rkbmd')
                                    ->whereRaw('rkbmd.master_sub_kegiatan_id = master_sub_kegiatan.id')
                                    ->where('id_rkbmd_map', $id_rkbmd_map);
                            });
                        }
                    });
            })
            ->where('tahun', $tahun)
            ->get();
        foreach ($data as $row) {
            $arr_kegiatan = array();
            $data_kegiatan = MasterKegiatan::orderBy('kode_kegiatan')
                ->whereExists(function ($query) use ($opd_id, $id_rkbmd_map) {
                    $query->select("master_sub_kegiatan.master_kegiatan_id")
                        ->from('master_sub_kegiatan')
                        ->whereRaw('master_sub_kegiatan.master_kegiatan_id = master_kegiatan.id');
                    if (!empty($opd_id)) {
                        $query->whereExists(function ($query3) use ($opd_id, $id_rkbmd_map) {
                            $query3->select("rkbmd.master_sub_kegiatan_id")
                                ->from('rkbmd_detail as rkbmd')
                                ->join('rkbmd_map', 'rkbmd_map.id', 'rkbmd.id_rkbmd_map')
                                ->whereRaw('rkbmd.master_sub_kegiatan_id = master_sub_kegiatan.id')
                                ->where('rkbmd_map.opd_id', $opd_id)
                                ->where('rkbmd_map.id', $id_rkbmd_map);
                        });
                    }
                })
                ->where('master_program_id', $row->id)
                ->where('tahun', $tahun)
                ->get();
            foreach ($data_kegiatan as $r_keg) {
                $arr_sub_kegiatan = array();

                $data_sub_kegiatan = MasterSubKegiatan::orderBy('kode_sub_kegiatan')
                    ->where('master_kegiatan_id', $r_keg->id)
                    ->where('tahun', $tahun);
                if (!empty($opd_id)) {
                    $data_sub_kegiatan = $data_sub_kegiatan->whereExists(function ($query3) use ($opd_id, $id_rkbmd_map) {
                        $query3->select("rkbmd.master_sub_kegiatan_id")
                            ->from('rkbmd_detail as rkbmd')
                            ->join('rkbmd_map', 'rkbmd_map.id', 'rkbmd.id_rkbmd_map')
                            ->whereRaw('rkbmd.master_sub_kegiatan_id = master_sub_kegiatan.id')
                            ->where('rkbmd_map.opd_id', $opd_id)
                            ->where('rkbmd_map.id', $id_rkbmd_map);
                    });
                }
                $data_sub_kegiatan = $data_sub_kegiatan->get();
                foreach ($data_sub_kegiatan as $r_sub_keg) {
                    $sub_kegiatan = [
                        'jenis' => 'sub_kegiatan', 'id' => $r_sub_keg->id, 'kode_sub_kegiatan' => @$r_sub_keg->kode_sub_kegiatan, 'nama_sub_kegiatan' => @$r_sub_keg->nama_sub_kegiatan
                    ];
                    if (!in_array($sub_kegiatan, $arr_sub_kegiatan)) {
                        array_push($arr_sub_kegiatan, $sub_kegiatan);
                    }
                }

                $kegiatan = [
                    'jenis' => 'kegiatan', 'kode_kegiatan' => @$r_keg->kode_kegiatan, 'nama_kegiatan' => @$r_keg->nama_kegiatan, 'data_sub_kegiatan' => $arr_sub_kegiatan
                ];
                if (!in_array($kegiatan, $arr_kegiatan)) {
                    array_push($arr_kegiatan, $kegiatan);
                }
            }
            $program = [
                'jenis' => 'program', 'kode_program' => @$row->kode_program, 'nama_program' => @$row->nama_program, 'data_kegiatan' => $arr_kegiatan
            ];
            if (!in_array($program, $res)) {
                array_push($res, $program);
            }
        }

        return $res;
    }


    public static function get_prog_keg_subkeg_rkbmd_manual($tahun, $opd_id = "", $id_rkbmd_map = "")
    {
        $res = array();
        $data = RkbmdDetail::orderBy('program_kode')
            ->where('id_rkbmd_map', $id_rkbmd_map)
            ->select('program_kode', 'program_nama')
            ->distinct()
            ->get();
        foreach ($data as $row) {
            $arr_kegiatan = array();
            $data_kegiatan = RkbmdDetail::orderBy('kegiatan_kode')
                ->where('id_rkbmd_map', $id_rkbmd_map)
                ->where('program_kode', $row->program_kode)
                ->select('kegiatan_kode', 'kegiatan_nama')
                ->distinct()
                ->get();
            foreach ($data_kegiatan as $r_keg) {

                $arr_sub_kegiatan = array();
                $data_sub_kegiatan = RkbmdDetail::orderBy('sub_kegiatan_kode')
                    ->where('id_rkbmd_map', $id_rkbmd_map)
                    ->where('kegiatan_kode', $r_keg->kegiatan_kode)
                    ->select('sub_kegiatan_kode', 'sub_kegiatan_nama', DB::raw('1 as master_sub_kegiatan_id'))
                    ->distinct()
                    ->get();
                foreach ($data_sub_kegiatan as $r_sub_keg) {
                    $sub_kegiatan = [
                        'jenis' => 'sub_kegiatan', 'id' => $r_sub_keg->master_sub_kegiatan_id, 'kode_sub_kegiatan' => @$r_sub_keg->sub_kegiatan_kode, 'nama_sub_kegiatan' => @$r_sub_keg->sub_kegiatan_nama
                    ];
                    if (!in_array($sub_kegiatan, $arr_sub_kegiatan)) {
                        array_push($arr_sub_kegiatan, $sub_kegiatan);
                    }
                }

                $kegiatan = [
                    'jenis' => 'kegiatan', 'kode_kegiatan' => @$r_keg->kegiatan_kode, 'nama_kegiatan' => @$r_keg->kegiatan_nama, 'data_sub_kegiatan' => $arr_sub_kegiatan
                ];
                if (!in_array($kegiatan, $arr_kegiatan)) {
                    array_push($arr_kegiatan, $kegiatan);
                }
            }
            $program = [
                'jenis' => 'program', 'kode_program' => @$row->program_kode, 'nama_program' => @$row->program_nama, 'data_kegiatan' => $arr_kegiatan
            ];
            if (!in_array($program, $res)) {
                array_push($res, $program);
            }
        }

        return $res;
    }



    public static function get_prog_keg_subkeg_standar_kebutuhan($tahun, $opd_id = "", $analisa_kebutuhan_map_id = "")
    {
        $res = array();
        $data = AnalisaKebutuhan::orderBy('program_kode')
            ->where('analisa_kebutuhan_map_id', $analisa_kebutuhan_map_id)
            ->select('program_kode', 'program_nama')
            ->distinct()
            ->get();
        foreach ($data as $row) {
            $arr_kegiatan = array();
            $data_kegiatan = AnalisaKebutuhan::orderBy('kegiatan_kode')
                ->where('analisa_kebutuhan_map_id', $analisa_kebutuhan_map_id)
                ->where('program_kode', $row->program_kode)
                ->select('kegiatan_kode', 'kegiatan_nama')
                ->distinct()
                ->get();
            foreach ($data_kegiatan as $r_keg) {

                $arr_sub_kegiatan = array();
                $data_sub_kegiatan = AnalisaKebutuhan::orderBy('sub_kegiatan_kode')
                    ->where('analisa_kebutuhan_map_id', $analisa_kebutuhan_map_id)
                    ->where('kegiatan_kode', $r_keg->kegiatan_kode)
                    ->select('sub_kegiatan_kode', 'sub_kegiatan_nama', DB::raw('1 as master_sub_kegiatan_id'))
                    ->distinct()
                    ->get();
                foreach ($data_sub_kegiatan as $r_sub_keg) {
                    $sub_kegiatan = [
                        'jenis' => 'sub_kegiatan', 'id' => $r_sub_keg->master_sub_kegiatan_id, 'kode_sub_kegiatan' => @$r_sub_keg->sub_kegiatan_kode, 'nama_sub_kegiatan' => @$r_sub_keg->sub_kegiatan_nama
                    ];
                    if (!in_array($sub_kegiatan, $arr_sub_kegiatan)) {
                        array_push($arr_sub_kegiatan, $sub_kegiatan);
                    }
                }

                $kegiatan = [
                    'jenis' => 'kegiatan', 'kode_kegiatan' => @$r_keg->kegiatan_kode, 'nama_kegiatan' => @$r_keg->kegiatan_nama, 'data_sub_kegiatan' => $arr_sub_kegiatan
                ];
                if (!in_array($kegiatan, $arr_kegiatan)) {
                    array_push($arr_kegiatan, $kegiatan);
                }
            }
            $program = [
                'jenis' => 'program', 'kode_program' => @$row->program_kode, 'nama_program' => @$row->program_nama, 'data_kegiatan' => $arr_kegiatan
            ];
            if (!in_array($program, $res)) {
                array_push($res, $program);
            }
        }

        return $res;
    }
}
