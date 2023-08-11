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

class ImportKegiatan implements ToCollection, WithMultipleSheets
{
    protected $tahun;
    protected $jenis;
    protected $konsep, $unit_kerja_id;
    public function sheets(): array
    {
        return [
            0 => $this, 
        ];
    }

    function __construct($tahun, $jenis, $konsep, $unit_kerja_id) {
        $this->tahun = $tahun;
        $this->jenis = $jenis;
        $this->konsep = $konsep;
        $this->unit_kerja_id = $unit_kerja_id;
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
        $unit_kerja_id = $this->unit_kerja_id; 
        $unit_kerja_id = $unit_kerja_id == '0' ? 0 : $unit_kerja_id;

        date_default_timezone_set("Asia/Jakarta"); 
    	$insert=0;
        if($this->jenis == 1){
            $insert=1;
        }
        $kode_insert = 'kegiatan_read_excel_'.date('Y-m-d H:i:s'); 
        $kode_unik = 'kegiatan_read_excel_'.date('Y-m-d H:i:s'); 
    	?>
<style>
.table_view_upload_file_pegawai,
.table_view_upload_file_pegawai td {
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
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
            height="117" align="center" valign=middle bgcolor="#C5E0B4"><b>
                <font color="#000000">
                    NO
                </font>
            </b>
        </td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
            height="117" align="center" valign=middle bgcolor="#C5E0B4"><b>
                <font color="#000000">
                    Urusan
                </font>
            </b>
        </td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
            height="117" align="center" valign=middle bgcolor="#C5E0B4"><b>
                <font color="#000000">
                    Bidang
                </font>
            </b>
        </td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
            height="117" align="center" valign=middle bgcolor="#C5E0B4"><b>
                <font color="#000000">
                    Program
                </font>
            </b>
        </td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
            height="117" align="center" valign=middle bgcolor="#C5E0B4"><b>
                <font color="#000000">
                    Kegiatan
                </font>
            </b>
        </td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
            height="117" align="center" valign=middle bgcolor="#C5E0B4"><b>
                <font color="#000000">
                    Sub Kegiatan
                </font>
            </b>
        </td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
            height="117" align="center" valign=middle bgcolor="#C5E0B4"><b>
                <font color="#000000">
                    Nomenklatur
                </font>
            </b>
        </td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
            height="117" align="center" valign=middle bgcolor="#C5E0B4"><b>
                <font color="#000000">
                    Kinerja
                </font>
            </b>
        </td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
            height="117" align="center" valign=middle bgcolor="#C5E0B4"><b>
                <font color="#000000">
                    Indikator
                </font>
            </b>
        </td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
            height="117" align="center" valign=middle bgcolor="#C5E0B4"><b>
                <font color="#000000">
                    Satuan
                </font>
            </b>
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
            $row[0] = str_replace(" ", "", $row[0]);
            $row[1] = str_replace(" ", "", $row[1]);
            $row[2] = str_replace(" ", "", $row[2]);
            $row[3] = str_replace(" ", "", $row[3]);
            $row[4] = str_replace(" ", "", $row[4]);
            
            $no++; 
            $bg = "";
            $spasidouble = 1;
            while ($spasidouble > 0) {
                $row[5] = str_replace("  ", " ", $row[5]);
                $spasidouble = strpos($row[5],"  ");
            }
            $spasidouble = 1;
            while ($spasidouble > 0) {
                $row[6] = str_replace("  ", " ", $row[6]);
                $spasidouble = strpos($row[6],"  ");
            }
            $spasidouble = 1;
            while ($spasidouble > 0) {
                $row[7] = str_replace("  ", " ", $row[7]);
                $spasidouble = strpos($row[7],"  ");
            }
            $spasidouble = 1;
            while ($spasidouble > 0) {
                $row[8] = str_replace("  ", " ", $row[8]);
                $spasidouble = strpos($row[8],"  ");
            }
            if(!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && empty($row[3]) && empty($row[4]) && !empty($row[5])) {
                $bg = "#9ADCFF"; /** PROGRAM warna biru */
                $data_program = [
                    'sync_kode' => $kode_unik 
                    , 'tahun' => $tahun 
                    , 'kode_urusan' => $row[0] . '.' . $row[1]
                    , 'kode_program' => $row[0] . '.' . $row[1] . '.' . $row[2]
                    , 'nama_program' => $row[5] 
                ];
                array_push($arr_program, $data_program);
            }
            if(!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && empty($row[4]) && !empty($row[5])) {
                $bg = "#E7FBBE"; /** KEGIATAN warna hijau */
                $data_kegiatan = [
                    'sync_kode' => $kode_unik  
                    , 'tahun' => $tahun 
                    , 'kode_program' => $row[0] . '.' . $row[1] . '.' . $row[2]
                    , 'kode_kegiatan' => $row[0] . '.' . $row[1] . '.' . $row[2] . '.' . $row[3] 
                    , 'nama_kegiatan' => $row[5] 
                ];
                array_push($arr_kegiatan, $data_kegiatan);
            }
            if(!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4]) && !empty($row[5]) ) {
                $bg = "#FFBCD1"; /** SUB KEGIATAN warna hijau */
                $data_subkegiatan = [
                    'sync_kode' => $kode_unik  
                    , 'tahun' => $tahun 
                    , 'kode_program' => $row[0] . '.' . $row[1] . '.' . $row[2]
                    , 'kode_kegiatan' => $row[0] . '.' . $row[1] . '.' . $row[2] . '.' . $row[3] 
                    , 'kode_sub_kegiatan' => $row[0] . '.' . $row[1] . '.' . $row[2] . '.' . $row[3] . '.' . $row[4] 
                    , 'nama_sub_kegiatan' => $row[5] 
                    , 'kinerja' => $row[6] 
                    , 'indikator' => $row[7] 
                    , 'satuan' => $row[8]
                ];
                array_push($arr_subkegiatan, $data_subkegiatan);
            }
            ?>
    <tr style="background-color: <?= $bg;?> ">
        <td><?php echo $no; ?></td>
        <td><?php echo ($row[0]); ?></td>
        <td><?php echo ($row[1]); ?></td>
        <td><?php echo ($row[2]); ?></td>
        <td align="right"><?php echo ($row[3]); ?></td>
        <td><?php echo ($row[4]); ?></td>
        <td align="right"><?php echo ($row[5]); ?></td>
        <td align="right"><?php echo ($row[6]); ?></td>
        <td><?php echo ($row[7]); ?></td>
        <td><?php echo ($row[8]); ?></td>
    </tr>
    <?php   
        }

        if($jenis == 1) {
            if($konsep == 2) {
                $delete = MasterProgram::where('tahun', $tahun)->where('opd_id', $unit_kerja_id)->delete();
                $delete = MasterKegiatan::where('tahun', $tahun)->where('opd_id', $unit_kerja_id)->delete();
                $delete = MasterSubKegiatan::where('tahun', $tahun)->where('opd_id', $unit_kerja_id)->delete();
            }
            for ($i=0; $i < sizeof($arr_program) ; $i++) {  
                $new = new MasterProgram();
                $new->sync_kode = $arr_program[$i]['sync_kode'];
                $new->tahun = $arr_program[$i]['tahun']; 
                $new->kode_urusan = $arr_program[$i]['kode_urusan'];
                $new->kode_program = $arr_program[$i]['kode_program'];
                $new->nama_program = $arr_program[$i]['nama_program'];
                $new->opd_id = $unit_kerja_id;
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
                $new->opd_id = $unit_kerja_id;
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
                $new->opd_id = $unit_kerja_id;
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
