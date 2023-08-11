<?php 
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Http\Controllers\AsbController;
use App\Models\MasterKegiatan;
use App\Models\MasterProgram;
use App\Models\MasterSubKegiatan;
use DB;

class ImportKegiatan2 implements ToCollection, WithMultipleSheets
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
					Kode
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					 Nomenklatur
				</font></b>
				</td> 
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					Kinerja
				</font></b>
				</td> 
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					Indikator
				</font></b>
				</td>  
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="117" align="center" valign=middle bgcolor="#C5E0B4"><b><font color="#000000">
					Satuan
				</font></b>
				</td>
			</tr> 
		<?php  
		$no=0;
		$no_asb=0;
		$no_komponen=0;
		$jml_insert=0;
		$in_a=0;
		$arr_program=array();
		$arr_kegiatan=array();
		$arr_subkegiatan=array();
		$output=array();
        foreach ($rows as $row) 
        {    
            $row[1] = str_replace(" ", "", $row[1]); 
            $kode = $row[1];
            $nama = $row[2];
            $kinerja = $row[3];
            $indikator = $row[4];
            $satuan = $row[5]; 
            
            $no++; 
            $bg = ""; 
            if(!empty($kode) && strlen($kode) == 7) {
                // X.XX.01
                $bg = "#9ADCFF"; /** PROGRAM warna biru */
                $data_program = [
                    'sync_kode' => $kode_unik 
                    , 'tahun' => $tahun 
                    , 'kode_urusan' => substr($kode, 0, 4)
                    , 'kode_program' => $kode
                    , 'nama_program' => $nama
                ];
                array_push($arr_program, $data_program);
            }
            if(!empty($kode) && strlen($kode) == 12) {
                // X.XX.01.2.01
                $bg = "#E7FBBE"; /** KEGIATAN warna hijau */
                $data_kegiatan = [
                    'sync_kode' => $kode_unik  
                    , 'tahun' => $tahun 
                    , 'kode_program' => substr($kode, 0, 7)
                    , 'kode_kegiatan' => $kode
                    , 'nama_kegiatan' => $nama
                ];
                array_push($arr_kegiatan, $data_kegiatan);
            }
            if(!empty($kode) && strlen($kode) == 17) {
                // X.XX.01.2.01.0001
                $bg = "#FFBCD1"; /** SUB KEGIATAN warna hijau */
                $data_subkegiatan = [
                    'sync_kode' => $kode_unik  
                    , 'tahun' => $tahun 
                    , 'kode_program' => substr($kode, 0, 7)
                    , 'kode_kegiatan' => substr($kode, 0, 12)
                    , 'kode_sub_kegiatan' => $kode 
                    , 'nama_sub_kegiatan' => $nama
                    , 'kinerja' => $kinerja
                    , 'indikator' => $indikator
                    , 'satuan' => $satuan
                ]; 
                array_push($arr_subkegiatan, $data_subkegiatan);
            }
            ?>
            <tr style="background-color: <?= $bg;?> ">
                <td><?php echo $no; ?></td> 
                <td><?php echo ($kode); ?></td>
                <td><?php echo ($nama); ?></td>
                <td><?php echo ($kinerja); ?></td>
                <td><?php echo ($indikator); ?></td>
                <td><?php echo ($satuan); ?></td>
                <td><?php echo ($row[2]); ?></td> 
            </tr>
            <?php   
        }

        if($jenis == 1) {
            if($konsep == 2) {
                $delete = MasterProgram::where('tahun', $tahun)->where('opd_id', $opd_id)->delete();
                $delete = MasterKegiatan::where('tahun', $tahun)->where('opd_id', $opd_id)->delete();
                $delete = MasterSubKegiatan::where('tahun', $tahun)->where('opd_id', $opd_id)->delete();
            }
            for ($i=0; $i < sizeof($arr_program) ; $i++) {  
                $new = new MasterProgram();
                $new->sync_kode = $arr_program[$i]['sync_kode'];
                $new->tahun = $arr_program[$i]['tahun']; 
                $new->kode_urusan = $arr_program[$i]['kode_urusan'];
                $new->kode_program = $arr_program[$i]['kode_program'];
                $new->nama_program = $arr_program[$i]['nama_program'];
                $new->opd_id = $opd_id;
                $new->save();
            }
            for ($i=0; $i < sizeof($arr_kegiatan) ; $i++) {  
                $dataprogram = MasterProgram::where('tahun', $tahun)->where('kode_program', $arr_kegiatan[$i]['kode_program'])->orderBy('id','desc')->first();

                $new = new MasterKegiatan();
                $new->master_program_id = @$dataprogram->id;
                $new->sync_kode = $arr_kegiatan[$i]['sync_kode'];
                $new->tahun = $arr_kegiatan[$i]['tahun'];  
                $new->kode_kegiatan = $arr_kegiatan[$i]['kode_kegiatan'];
                $new->nama_kegiatan = $arr_kegiatan[$i]['nama_kegiatan'];
                $new->opd_id = $opd_id;
                $new->save();
            }
            for ($i=0; $i < sizeof($arr_subkegiatan) ; $i++) {  
                $datakegiatan = MasterKegiatan::where('tahun', $tahun)->where('kode_kegiatan', $arr_subkegiatan[$i]['kode_kegiatan'])->orderBy('id','desc')->first();

                $new = new MasterSubKegiatan();
                $new->master_kegiatan_id = @$datakegiatan->id;
                $new->sync_kode = $arr_subkegiatan[$i]['sync_kode'];
                $new->tahun = $arr_subkegiatan[$i]['tahun'];  
                $new->kode_sub_kegiatan = $arr_subkegiatan[$i]['kode_sub_kegiatan'];
                $new->nama_sub_kegiatan = $arr_subkegiatan[$i]['nama_sub_kegiatan'];
                $new->kinerja = $arr_subkegiatan[$i]['kinerja'];  
                $new->indikator = $arr_subkegiatan[$i]['indikator'];
                $new->satuan = $arr_subkegiatan[$i]['satuan'];
                $new->opd_id = $opd_id;
                $new->save();
            }

            $update = DB::select("UPDATE master_program SET nama_program=replace(nama_program, '
            ', ' ');             
            ");
            $update = DB::select("
            UPDATE master_kegiatan SET nama_kegiatan=replace(nama_kegiatan, '
            ', ' ');             
            ");
            $update = DB::select("
            UPDATE master_sub_kegiatan SET nama_sub_kegiatan=replace(nama_sub_kegiatan, '
            ', ' ');             
            ");
        } 
        ?>
	    </table>
        <?php
    }
}
?>