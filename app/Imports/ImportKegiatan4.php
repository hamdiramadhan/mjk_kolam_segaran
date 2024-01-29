<?php 
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Http\Controllers\AsbController;
use App\Models\DataAwalImportKegiatan4;
use App\Models\MasterKegiatan;
use App\Models\MasterProgram;
use App\Models\MasterSubKegiatan;
use App\Models\MasterSubKegiatanImport;
use App\Models\Opd;
use Illuminate\Support\Facades\DB;

class ImportKegiatan4 implements ToCollection, WithMultipleSheets
{
    protected $tahun;
    protected $jenis; 
    protected $konsep, $opd_id;
    public function sheets(): array
    {
        return [
            0 => $this, 
        ];
    }

    function __construct($tahun, $jenis, $konsep, $opd_id) {
        $this->tahun = $tahun;
        $this->jenis = $jenis;
        $this->konsep = $konsep;
        $this->opd_id = $opd_id;
        // Jenis = 1 langsung insert
        // Jenis = 2 lihat hasilnya dulu
        // Konsep = 1 Menambah Data, tanpa menghapus data <span class="txt_tahun_asb"></span> yang sudah ada</option>
        // Konsep = 2 Hapus data <span class="txt_tahun_asb"></span>, lalu simpan dari hasil import</option>
    }
    public function collection(Collection $rows)
    {
        $paramtahun = $this->tahun;
        $jenis = $this->jenis;
        $konsep = $this->konsep;
        $opd_id = $this->opd_id; 
        $opd_id = $opd_id == 'global' ? null : $opd_id;

        date_default_timezone_set(env('APP_TIMEZONE', 'Asia/Makassar')); 
    	$insert=0;
        if($this->jenis == 1){
            $insert=1;
        }
        $kode_insert = 'kegiatan_read_excel_'.date('Y-m-d H:i:s'); 
        $kode_unik = 'kegiatan_read_excel_'.date('Y-m-d H:i:s'); 
    	?>
		<style>
			.table_view_upload_file_pegawai, .table_view_upload_file_pegawai td {
				border: 1px solid #000;
				border-collapse: collapse;
				padding: 2px 4px;
			}
		</style>
        <h3>
            Tunggu hingga loading aplikasi selesai, maka proses telah selesai dan dapat kembali ke menu sebelumnya.
        </h3>
		<table class="table_view_upload_file_pegawai">
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					NO
				</font></b>
				</td>   
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					NO
				</font></b>
				</td>   
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					Tahun
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					Kode Urusan
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
                    NAMA URUSAN	
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
                KODE SKPD	
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
                NAMA SKPD	
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
                KODE SUB UNIT	
				</font></b>
				</td> 
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">NAMA SUB UNIT	
				</font></b>
				</td> 
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
                KODE BIDANG URUSAN	
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">NAMA BIDANG URUSAN	
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">KODE PROGRAM	
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">NAMA PROGRAM	
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">KODE KEGIATAN	
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">NAMA KEGIATAN	
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">KODE SUB KEGIATAN	
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">NAMA SUB KEGIATAN	
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">KODE SUMBER DANA
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">NAMA SUMBER DANA
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">	KODE REKENING	
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">	NAMA REKENING		
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">	KODE STANDAR HARGA	
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">	NAMA STANDAR HARGA	 
				</font></b>
				</td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">	PAGU
				</font></b>
				</td>
			</tr> 
		<?php  
		$no=0; 
		$arr_import=array();
		$output=array();
        foreach ($rows as $row) 
        {
            $nom = $row[0];
            $tahun = $row[1];
            $kode_urusan = $row[2];
            $nama_urusan = $row[3];
            $kode_skpd = $row[4];
            $nama_skpd = $row[5];
            $kode_sub_unit = $row[6];
            $nama_sub_unit = $row[7]; 
            $kode_bidang_urusan = $row[8]; 
            $nama_bidang_urusan = $row[9]; 
            $kode_program = $row[10]; 
            $nama_program = $row[11]; 
            $kode_kegiatan = $row[12]; 
            $nama_kegiatan = $row[13]; 
            $kode_sub_giat = $row[14]; 
            $nama_sub_giat = $row[15]; 
            $kode_sumber_dana = $row[16]; 
            $nama_sumber_dana = $row[17]; 
            $kode_rekening = $row[18]; 
            $nama_rekening = $row[19]; 
            $kode_ssh = $row[20]; 
            $nama_ssh = $row[21]; 
            $pagu = $row[22]; 
            
            $no++; 
            $bg = "";  
            if(
                !empty($tahun) && $tahun == $paramtahun 
                && 
                !empty($pagu) && is_numeric($pagu) 
            ) 
            { 
                $bg = "#C5E0B4"; /** SUB KEGIATAN warna hijau */
                $dataimport = [
                    'sync_kode' => $kode_unik   
                    , 'nom' => $nom
                    , 'tahun' => $tahun
                    , 'kode_urusan' => $kode_urusan
                    , 'nama_urusan' => $nama_urusan
                    , 'kode_skpd' => $kode_skpd
                    , 'nama_skpd' => $nama_skpd
                    , 'kode_sub_unit' => $kode_sub_unit
                    , 'nama_sub_unit' => $nama_sub_unit
                    , 'kode_bidang_urusan' => $kode_bidang_urusan
                    , 'nama_bidang_urusan' => $nama_bidang_urusan
                    , 'kode_program' => $kode_program
                    , 'nama_program' => $nama_program
                    , 'kode_kegiatan' => $kode_kegiatan
                    , 'nama_kegiatan' => $nama_kegiatan
                    , 'kode_sub_giat' => $kode_sub_giat
                    , 'nama_sub_giat' => $nama_sub_giat
                    , 'kode_sumber_dana' => $kode_sumber_dana
                    , 'nama_sumber_dana' => $nama_sumber_dana
                    , 'kode_rekening' => $kode_rekening
                    , 'nama_rekening' => $nama_rekening
                    , 'kode_ssh' => $kode_ssh
                    , 'nama_ssh' => $nama_ssh
                    , 'pagu' => $pagu 
                ]; 
                array_push($arr_import, $dataimport);
            }
            if($jenis != 1) {
            ?>
            <tr style="background-color: <?= $bg;?> ">
                <td><?php echo $no; ?></td>  
                <td><?php echo ($nom); ?></td> 
                <td><?php echo ($tahun); ?></td> 
                <td><?php echo ($kode_urusan); ?></td> 
                <td><?php echo ($nama_urusan); ?></td> 
                <td><?php echo ($kode_skpd); ?></td> 
                <td><?php echo ($nama_skpd); ?></td> 
                <td><?php echo ($kode_sub_unit); ?></td> 
                <td><?php echo ($nama_sub_unit); ?></td> 
                <td><?php echo ($kode_bidang_urusan); ?></td> 
                <td><?php echo ($nama_bidang_urusan); ?></td> 
                <td><?php echo ($kode_program); ?></td> 
                <td><?php echo ($nama_program); ?></td> 
                <td><?php echo ($kode_kegiatan); ?></td> 
                <td><?php echo ($nama_kegiatan); ?></td> 
                <td><?php echo ($kode_sub_giat); ?></td> 
                <td><?php echo ($nama_sub_giat); ?></td> 
                <td><?php echo ($kode_sumber_dana); ?></td> 
                <td><?php echo ($nama_sumber_dana); ?></td> 
                <td><?php echo ($kode_rekening); ?></td> 
                <td><?php echo ($nama_rekening); ?></td> 
                <td><?php echo ($kode_ssh); ?></td> 
                <td><?php echo ($nama_ssh); ?></td> 
                <td><?php echo ($pagu); ?></td>  
            </tr>
            <?php   
            }
        }

        if($jenis == 1) { 
            if($konsep == 2) {
                $delete = MasterProgram::where('tahun', $tahun)->delete();
                $delete = MasterKegiatan::where('tahun', $tahun)->delete();
                $delete = MasterSubKegiatan::where('tahun', $tahun)->delete(); 
            }
            for ($i=0; $i < sizeof($arr_import) ; $i++) {   
                $new = new DataAwalImportKegiatan4();
                $new->sync_kode = $arr_import[$i]['sync_kode']; 
                $new->nom = $arr_import[$i]['nom']; 
                $new->tahun = $arr_import[$i]['tahun']; 
                $new->kode_urusan = $arr_import[$i]['kode_urusan']; 
                $new->nama_urusan = $arr_import[$i]['nama_urusan']; 
                $new->kode_skpd = $arr_import[$i]['kode_skpd']; 
                $new->nama_skpd = $arr_import[$i]['nama_skpd']; 
                $new->kode_sub_unit = $arr_import[$i]['kode_sub_unit']; 
                $new->nama_sub_unit = $arr_import[$i]['nama_sub_unit']; 
                $new->kode_bidang_urusan = $arr_import[$i]['kode_bidang_urusan']; 
                $new->nama_bidang_urusan = $arr_import[$i]['nama_bidang_urusan']; 
                $new->kode_program = $arr_import[$i]['kode_program']; 
                $new->nama_program = $arr_import[$i]['nama_program']; 
                $new->kode_kegiatan = $arr_import[$i]['kode_kegiatan']; 
                $new->nama_kegiatan = $arr_import[$i]['nama_kegiatan']; 
                $new->kode_sub_giat = $arr_import[$i]['kode_sub_giat']; 
                $new->nama_sub_giat = $arr_import[$i]['nama_sub_giat']; 
                $new->kode_sumber_dana = $arr_import[$i]['kode_sumber_dana']; 
                $new->nama_sumber_dana = $arr_import[$i]['nama_sumber_dana']; 
                $new->kode_rekening = $arr_import[$i]['kode_rekening']; 
                $new->nama_rekening = $arr_import[$i]['nama_rekening']; 
                $new->kode_ssh = $arr_import[$i]['kode_ssh']; 
                $new->nama_ssh = $arr_import[$i]['nama_ssh']; 
                $new->pagu = $arr_import[$i]['pagu'];  
                $new->save(); 
            } 
            
            /* START INSERT PROGRAM */
            try {
                $insertprogramglobal = DB::statement("INSERT INTO master_program (opd_id, kode_urusan, kode_program, nama_program, tahun, sync_kode)
                    select distinct 0 opd_id, kode_urusan, kode_program, nama_program, {$tahun}, sync_kode
                    from data_awal_import_kegiatan4s d
                    where sync_kode='{$kode_unik}'
                    order by opd_id, kode_program 
                ");
            } catch (\Throwable $th) {
                echo 'program global ' . $th->getMessage();exit();
                //throw $th;
            }
            try {
                $insertprogram = DB::statement("INSERT INTO master_program (opd_id, kode_urusan, kode_program, nama_program, tahun, sync_kode)
                    select distinct (select id from opds where unit_id=d.kode_sub_unit) opd_id, kode_urusan, kode_program, nama_program, {$tahun}, sync_kode
                    from data_awal_import_kegiatan4s d
                    where sync_kode='{$kode_unik}'
                    order by opd_id, kode_program 
                ");
            } catch (\Throwable $th) {
                echo 'program opd ' . $th->getMessage();exit();
                //throw $th;
            }
            /* END INSERT PROGRAM */ 

            /* START INSERT KEGIATAN */
            try {
                $insertprogramglobal = DB::statement("INSERT INTO master_kegiatan (opd_id, master_program_id, kode_kegiatan, nama_kegiatan, tahun, sync_kode)
                    select distinct 0 opd_id, 
                        (select id from master_program where opd_id=0
                            and tahun=d.tahun::integer
                            and kode_program=d.kode_program
                        ) program_id,
                        kode_kegiatan, 
                        nama_kegiatan, 
                        tahun::integer, 
                        sync_kode
                    from data_awal_import_kegiatan4s d 
                    where sync_kode='{$kode_unik}'
                    order by opd_id, kode_kegiatan 
                ");
            } catch (\Throwable $th) {
                echo 'kegiatan global ' . $th->getMessage();exit();
                //throw $th;
            }
            try {
                $insertprogramglobal = DB::statement("INSERT INTO master_kegiatan (opd_id, master_program_id,kode_kegiatan, nama_kegiatan, tahun, sync_kode)
                    select distinct (select id from opds where unit_id=d.kode_sub_unit) opd_id, 
                        (select id from master_program where opd_id=(select id from opds where unit_id=d.kode_sub_unit)
                            and tahun=d.tahun::integer
                            and kode_program=d.kode_program
                        ) program_id,
                        kode_kegiatan, 
                        nama_kegiatan, 
                        tahun::integer, 
                        sync_kode
                    from data_awal_import_kegiatan4s d 
                    where sync_kode='{$kode_unik}'
                    order by opd_id, kode_kegiatan 
                ");
            } catch (\Throwable $th) {
                echo 'kegiatan opd ' . $th->getMessage();exit();
                //throw $th;
            }
            /* END INSERT KEGIATAN */ 

            /* START INSERT SUBKEGIATAN */
            try {
                $insertprogramglobal = DB::statement("INSERT INTO master_sub_kegiatan (opd_id, master_kegiatan_id, kode_sub_kegiatan, nama_sub_kegiatan, tahun, sync_kode)
                    select distinct 0 opd_id, 
                        (select id from master_kegiatan where opd_id=0
                            and tahun=d.tahun::integer
                            and master_program_id=((select id from master_program where opd_id=0
                                    and tahun=d.tahun::integer
                                    and kode_program=d.kode_program
                                ))
                            and kode_kegiatan = d.kode_kegiatan
                        ) kegiatan_id,
                        kode_sub_giat, 
                        nama_sub_giat, 
                        tahun::integer, 
                        sync_kode
                    from data_awal_import_kegiatan4s d 
                    where sync_kode='{$kode_unik}'
                    order by opd_id, kode_sub_giat  
                ");
            } catch (\Throwable $th) {
                echo 'subkegiatan global ' . $th->getMessage();exit();
                //throw $th;
            }
            try {
                $insertprogramglobal = DB::statement("INSERT INTO master_sub_kegiatan (opd_id, master_kegiatan_id, kode_sub_kegiatan, nama_sub_kegiatan, tahun, sync_kode)
                    select distinct (select id from opds where unit_id=d.kode_sub_unit) opd_id, 
                        (select id from master_kegiatan where opd_id=(select id from opds where unit_id=d.kode_sub_unit)
                            and tahun=d.tahun::integer
                            and master_program_id=((select id from master_program where opd_id=(select id from opds where unit_id=d.kode_sub_unit)
                                    and tahun=d.tahun::integer
                                    and kode_program=d.kode_program
                                ))
                            and kode_kegiatan = d.kode_kegiatan
                        ) kegiatan_id,
                        kode_sub_giat, 
                        nama_sub_giat, 
                        tahun::integer, 
                        sync_kode
                    from data_awal_import_kegiatan4s d 
                    where sync_kode='{$kode_unik}'
                    order by opd_id, kode_sub_giat  
                ");
            } catch (\Throwable $th) {
                echo 'subkegiatan opd ' . $th->getMessage();exit();
                //throw $th;
            }
            /* END INSERT SUBKEGIATAN */ 
            
        } 
        ?>
	    </table>
        <?php
    }
}
?>