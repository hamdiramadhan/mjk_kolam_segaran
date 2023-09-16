<?php 
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Http\Controllers\AsbController;
use App\Models\MasterKegiatan;
use App\Models\MasterProgram;
use App\Models\MasterSubKegiatan;
use App\Models\MasterSubKegiatanImport;
use App\Models\Opd;
use Illuminate\Support\Facades\DB;

class ImportKegiatan3 implements ToCollection, WithMultipleSheets
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
        $tahun = $this->tahun;
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
					Kode 1
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					Kode 2
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					Kode 3
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					Kode 4
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					Kode 5
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
                    URUSAN / BIDANG URUSAN PEMDA / PROGRAM / KEGIATAN / SUBKEGIATAN
				</font></b>
				</td> 
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					Kode Dinas
				</font></b>
				</td> 
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					Nama Dinas
				</font></b>
				</td>
			</tr> 
		<?php  
		$no=0;
		$no_asb=0;
		$no_komponen=0;
		$jml_insert=0;
		$in_a=0; 
		$arr_import=array();
		$output=array();
        foreach ($rows as $row) 
        {     
            $row[0] = str_replace(" ", "", $row[0]); 
            $row[1] = str_replace(" ", "", $row[1]); 
            $row[2] = str_replace(" ", "", $row[2]); 
            $row[3] = str_replace(" ", "", $row[3]); 
            $row[4] = str_replace(" ", "", $row[4]); 

            $kode1 = $row[0];
            $kode2 = $row[1];
            $kode3 = $row[2];
            $kode4 = $row[3];
            $kode5 = $row[4];
            $uraian = $row[5];
            $kodedinas = $row[8];
            $namadinas = $row[9]; 
            
            $no++; 
            $bg = "";  
            if(!empty($kode1) && is_numeric($kode1) && !empty($kodedinas)) { 
                $bg = "#C5E0B4"; /** SUB KEGIATAN warna hijau */
                $dataimport = [
                    'sync_kode' => $kode_unik  
                    , 'tahun' => $tahun 
                    , 'opd_id' => $opd_id 
                    , 'kode1' => $kode1 
                    , 'kode2' => $kode2 
                    , 'kode3' => $kode3 
                    , 'kode4' => $kode4 
                    , 'kode5' => $kode5 
                    , 'uraian' => $uraian 
                    , 'kodedinas' => $kodedinas 
                    , 'namadinas' => $namadinas
                ]; 
                array_push($arr_import, $dataimport);
            }
            ?>
            <tr style="background-color: <?= $bg;?> ">
                <td><?php echo $no; ?></td> 
                <td><?php echo ($kode1); ?></td>
                <td><?php echo ($kode2); ?></td>
                <td><?php echo ($kode3); ?></td>
                <td><?php echo ($kode4); ?></td>
                <td><?php echo ($kode5); ?></td>
                <td><?php echo ($uraian); ?></td>
                <td><?php echo ($kodedinas); ?></td>
                <td><?php echo ($namadinas); ?></td> 
            </tr>
            <?php   
        }

        if($jenis == 1) {
            if($konsep == 2) {
                $delete = MasterProgram::where('tahun', $tahun)->delete();
                $delete = MasterKegiatan::where('tahun', $tahun)->delete();
                $delete = MasterSubKegiatan::where('tahun', $tahun)->delete();
                $delete = MasterSubKegiatanImport::where('tahun', $tahun)->delete();
            }
            for ($i=0; $i < sizeof($arr_import) ; $i++) {  
                $new = new MasterSubKegiatanImport();
                $new->sync_kode = $arr_import[$i]['sync_kode'];
                $new->tahun = $arr_import[$i]['tahun']; 
                $new->opd_id = $arr_import[$i]['opd_id']; 
                $new->kode1 = $arr_import[$i]['kode1']; 
                $new->kode2 = $arr_import[$i]['kode2']; 
                $new->kode3 = $arr_import[$i]['kode3']; 
                $new->kode4 = $arr_import[$i]['kode4']; 
                $new->kode5 = $arr_import[$i]['kode5']; 
                $new->uraian = $arr_import[$i]['uraian']; 
                $new->kodedinas = $arr_import[$i]['kodedinas']; 
                $new->namadinas = $arr_import[$i]['namadinas']; 
                $new->save();

                $opd = Opd::where('unit_id',$new->kodedinas)->first();
                $opd_id = @$opd->id;

                if($opd_id && !empty($new->kode3) && empty($new->kode4))
                {
                    $new_prog = new MasterProgram();
                    $new_prog->sync_kode = $arr_import[$i]['sync_kode'];
                    $new_prog->tahun = $arr_import[$i]['tahun']; 
                    $new_prog->kode_urusan = $arr_import[$i]['kode1'].'.'.$arr_import[$i]['kode2'];
                    $new_prog->kode_program = $arr_import[$i]['kode1'].'.'.$arr_import[$i]['kode2'].'.'.$arr_import[$i]['kode3']; 
                    $new_prog->nama_program = $arr_import[$i]['uraian'];
                    $new_prog->opd_id = $opd_id;
                    $new_prog->save();
                }

                if($opd_id && isset($new_prog) && !empty($new) && !empty($new->kode4) && empty($new->kode5))
                {
                    $new_keg = new MasterKegiatan();
                    $new_keg->master_program_id = @$new_prog->id;
                    $new_keg->sync_kode = $arr_import[$i]['sync_kode'];
                    $new_keg->tahun = $arr_import[$i]['tahun'];  
                    $new_keg->kode_kegiatan = $arr_import[$i]['kode1'].'.'.$arr_import[$i]['kode2'].'.'.$arr_import[$i]['kode3'].'.'.$arr_import[$i]['kode4'];
                    $new_keg->nama_kegiatan = $arr_import[$i]['uraian'];
                    $new_keg->opd_id = $opd_id;
                    $new_keg->save();
                }

                if($opd_id && isset($new_keg) && !empty($new) && !empty($new->kode5))
                {
                    $new_subkeg = new MasterSubKegiatan();
                    $new_subkeg->master_kegiatan_id = @$new_keg->id;
                    $new_subkeg->sync_kode = $arr_import[$i]['sync_kode'];
                    $new_subkeg->tahun = $arr_import[$i]['tahun'];  
                    $new_subkeg->kode_sub_kegiatan = $arr_import[$i]['kode1'].'.'.$arr_import[$i]['kode2'].'.'.$arr_import[$i]['kode3'].'.'.$arr_import[$i]['kode4'].'.'.$arr_import[$i]['kode5'];
                    $new_subkeg->nama_sub_kegiatan = $arr_import[$i]['uraian']; 
                    $new_subkeg->opd_id = $opd_id;
                    $new_subkeg->save();
                }
            } 
            $updateuraian = DB::select("UPDATE master_sub_kegiatan_import SET uraian=replace(uraian, '
            ', ' ');             
            ");
        } 
        ?>
	    </table>
        <?php
    }
}
?>