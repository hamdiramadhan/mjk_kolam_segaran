<html>
@php
    $arrbulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $arr_huruf_besar = [];
    $arr_huruf_kecil = [];
    $chartambahan = ['', '', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    $char = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    for ($i = 1; $i <= 20; $i++) {
        foreach ($char as $c) {
            $isi_besar = $c;
            if ($i > 1) {
                $isi_besar = $chartambahan[$i] . $c;
            }
            $isi_besar = strtoupper($isi_besar);
            if (!in_array($isi_besar, $arr_huruf_besar)) {
                array_push($arr_huruf_besar, $isi_besar);
            }

            $isi_kecil = $c;
            if ($i > 1) {
                $isi_kecil = $chartambahan[$i] . $c;
            }
            if (!in_array($isi_kecil, $arr_huruf_kecil)) {
                array_push($arr_huruf_kecil, $isi_kecil);
            }
        }
    }
@endphp

<head>
    <title>Lampiran Pergeseran</title>
    <style>
        .table,
        .table td,
        .table th {
            border: 1px solid;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            /* color: white; */
            font-size: 7pt;
            font-family: Arial, Helvetica, sans-serif;
            justify-content: center;
        }

        .d-none {
            display: none;
            background-color: red;
        }
    </style>
</head>

@foreach ($pengajuan_details as $pengajuan_detail)

    <body style="font-size: 12pt">
        <footer>
            <table style="width: 100%; border-top: 1px solid gray;" border="0">
                <tr>
                    <td>
                        @if ($data->status != 2)
                            <b>{{ @$data->stat->nama }}</b> -
                        @endif
                        Dicetak pada {{ date('Y-m-d H:i') }} -
                        {{ str_replace('https://', '', str_replace('http://', '', url('/'))) }}
                        {{-- - * merupakan usulan SKPD lain. ** merupakan data manual --}}
                    </td>
                </tr>
            </table>
        </footer>
        <br>

        <div style="width: 100%; text-align: left;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 100px">Nomor </td>
                    <td style="width: 10px"> : </td>
                    <td>
                        {{ $data->nomor_surat }}
                    </td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td> : </td>
                    <td>
                        {{ format_tanggal($data->tanggal_surat) }}
                    </td>
                </tr>
            </table>
        </div>
        <div style="width: 100%; text-align: center;">
            {{ strtoupper($opd->unit_name) }}
            <br>
            TAHUN ANGGARAN {{ $tahun }}
            <br>
            Sub Kegiatan ({{ $pengajuan_detail->sub_kegiatan->kode_sub_kegiatan }})
            {{ $pengajuan_detail->sub_kegiatan->nama_sub_kegiatan }}
            {{-- {{ strtoupper($uk->unit_name) }} --}}
            <br>
            Sumber Dana:
            @foreach ($pengajuan_detail->sumberdanas as $sb)
                {{ $sb->sumber_dana->nama }}
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </div>
        <br>
        <div style="width: 100%;">
            <table class="table table-sm table-bordered table-hover datatable-not-sortable-paging"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th style="text-align: center;" rowspan="2">Kode</th>
                        <th style="text-align: center;" rowspan="2">Uraian</th>
                        @if (sizeof($fases) <= 1)
                            <th style="text-align: center;" colspan="5">Rincian Murni</th>
                        @endif
                        @foreach ($fases as $f)
                            <th style="text-align: center;" colspan="5">{{ $f->nama }}</th>
                        @endforeach
                        <th style="text-align: center; " rowspan="2">Bertambah / <br>Berkurang</th>
                    </tr>
                    <tr>

                        @if (sizeof($fases) <= 1)
                            <th style="text-align: center;">Satuan</th>
                            <th style="text-align: center;">Koefisien</th>
                            <th style="text-align: center;">Harga</th>
                            <th style="text-align: center;">PPN</th>
                            <th style="text-align: center;">Jumlah</th>
                        @endif

                        @foreach ($fases as $f)
                            {{-- <th style="text-align: center;">Uraian</th> --}}
                            <th style="text-align: center;">Satuan</th>
                            <th style="text-align: center;">Koefisien</th>
                            <th style="text-align: center;">Harga</th>
                            <th style="text-align: center;">PPN</th>
                            <th style="text-align: center;">Jumlah</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subtotal = 0;

                        $no = 0;
                        $details = App\Models\Detail::select('master_sub_kegiatan_id', 'subtitle')
                            ->where('master_sub_kegiatan_id', $pengajuan_detail->master_sub_kegiatan_id)
                            ->where('tahun', $data->tahun)
                            ->distinct()
                            ->orderBy('subtitle')
                            ->get();
                    @endphp
                    @foreach ($details as $r1)
                        @php
                            $detail_rincian_pergeseran = App\Models\DetailRincian::where('pengajuan_id', $pengajuan_detail->pengajuan_id)
                                ->where('master_sub_kegiatan_id', $r1->master_sub_kegiatan_id)
                                ->distinct()
                                ->orderBy('subtitle_pergeseran')
                                ->first();
                        @endphp
                        @push('detail')
                            <tr>
                                @php
                                    $jmlcolspan = 0;
                                    if (sizeof($fases) <= 1) {
                                        $jmlcolspan = 5;
                                    }
                                    foreach ($fases as $f) {
                                        $jmlcolspan += 5;
                                    }
                                    $jmlcolspan++;
                                @endphp
                                <td colspan="{{ $jmlcolspan }}"><b>{!! $r1->subtitle ?? '#' !!}</b></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endpush
                        <?php
                        $data_ket_bl_teks = App\Models\Detail::get_sub2($r1->master_sub_kegiatan_id, $r1->subtitle);
                        ?>
                        @foreach ($data_ket_bl_teks as $r2)
                            <?php
                            $data_ket_bl_teks_pergeseran = App\Models\DetailRincian::get_sub2(@$id_sub_kegiatan, @$detail_rincian_pergeseran->subtitle_pergeseran, @$pengajuan_detail->pengajuan_id);
                            
                            $data_rekening = App\Models\Detail::get_rekening($r1->master_sub_kegiatan_id, $r1->subtitle, $r2->subtitle2, $pengajuan_detail->id);
                            
                            ?>
                            @push('detail')
                                <tr>
                                    @php
                                        $jmlcolspan = 0;
                                        if (sizeof($fases) <= 1) {
                                            $jmlcolspan = 5;
                                        }
                                        foreach ($fases as $f) {
                                            $jmlcolspan += 5;
                                        }
                                        $jmlcolspan++;
                                    @endphp
                                    <td colspan="{{ $jmlcolspan }}">&nbsp;<b>{!! $r2->subtitle2 ?? '-' !!} </b></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endpush
                            @foreach ($data_rekening as $r3)
                                @php
                                    $length = 0;
                                    $data_komponen = App\Models\Detail::get_komponen($r1->master_sub_kegiatan_id, $r1->subtitle, $r2->subtitle2, $r3->kode_rekening);
                                    $id_detail_murni = App\Models\Detail::where('kode_rekening', $r3->kode_rekening)
                                        ->where('subtitle', $r1->subtitle)
                                        ->where('subtitle2', $r2->subtitle2)
                                        ->first();

                                    $jml_geser = 0;
                                    foreach ($data_komponen as $r4) {
                                        if ($r4->tipe == 'murni') {
                                            $harga_ppn = $r4->harga + ($r4->harga * $r4->ppn) / 100;
                                            $total = $harga_ppn * $r4->volume;
                                            $selisih = $total;
                                        } else {
                                            $harga_ppn = 0;
                                            $total = $harga_ppn * $r4->volume;
                                            $selisih = $total;
                                        }
                                        $no++;

                                        foreach ($fases as $f) {
                                            $rincian_geser = App\Models\DetailRincian::get_komponen_fase($pengajuan_detail->pengajuan_id, $r4->id, $f->id, $r3->kode_rekening);
                                            if ($r4->tipe == 'pergeseran' && $r4->fase_id == $f->id) {
                                                $rincian_geser = App\Models\DetailRincian::get_komponen_id($r4->id);
                                            }
                                            if ($rincian_geser || $rincian_geser == 'bedarekening') {
                                                $jml_geser++;
                                            }
                                        }
                                    }
                                @endphp
                                @if ($jml_geser > 0)
                                    @push('detail')
                                        <tr>
                                            @php
                                                $jmlcolspan = 0;
                                                if (sizeof($fases) <= 1) {
                                                    $jmlcolspan = 5;
                                                }
                                                foreach ($fases as $f) {
                                                    $jmlcolspan += 5;
                                                }
                                            @endphp
                                            <td><b>{!! $r3->kode_rekening !!}</b></td>
                                            <td colspan="{{ $jmlcolspan }}">
                                                <b>
                                                    {!! @$r3->rekening->nama_rek ?? '' !!}
                                                </b>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endpush
                                    @foreach ($data_komponen as $r4)
                                        @php
                                            if ($r4->tipe == 'murni') {
                                                $harga_ppn = $r4->harga + ($r4->harga * $r4->ppn) / 100;
                                                $total = $harga_ppn * $r4->volume;
                                                $selisih = $total;
                                            } else {
                                                $harga_ppn = 0;
                                                $total = $harga_ppn * $r4->volume;
                                                $selisih = $total;
                                            }
                                            $jml_geser = 0;
                                            $no++;

                                            foreach ($fases as $f) {
                                                $rincian_geser = App\Models\DetailRincian::get_komponen_fase($pengajuan_detail->pengajuan_id, $r4->id, $f->id, $r3->kode_rekening);
                                                if ($r4->tipe == 'pergeseran' && $r4->fase_id == $f->id) {
                                                    $rincian_geser = App\Models\DetailRincian::get_komponen_id($r4->id);
                                                }
                                                if ($rincian_geser || $rincian_geser == 'bedarekening') {
                                                    $jml_geser++;
                                                }
                                            }
                                        @endphp
                                        @push('detail')
                                            @if ($jml_geser > 0)
                                                <tr class="dt_{{ $no }}">
                                                    <td></td>
                                                    <td>
                                                        {{-- @if ($r4->tipe == 'murni') --}}
                                                        {!! $r4->detail !!} {{ $r4->spek }}
                                                        {{-- @endif --}}
                                                    </td>
                                                    @if (sizeof($fases) <= 1)
                                                        <td>
                                                            @if ($r4->tipe == 'murni')
                                                                {!! $r4->satuan !!}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($r4->tipe == 'murni')
                                                                {!! $r4->koefisien !!}
                                                            @endif
                                                        </td>
                                                        <td align="right">
                                                            @if ($r4->tipe == 'murni')
                                                                {!! number_format($r4->harga, 0, ',', '.') !!}
                                                            @else
                                                                0
                                                            @endif
                                                        </td>
                                                        <td align="right">
                                                            @if ($r4->tipe == 'murni')
                                                                {!! number_format($r4->ppn, 0, ',', '.') !!}
                                                            @else
                                                                0
                                                            @endif
                                                        </td>
                                                        <td align="right">
                                                            {{-- @if ($r4->tipe == 'murni') --}}
                                                            {!! number_format($total, 0, ',', '.') !!}
                                                            {{-- @endif --}}
                                                        </td>
                                                    @endif

                                                    @foreach ($fases as $f)
                                                        @php
                                                            $rincian_geser = App\Models\DetailRincian::get_komponen_fase($pengajuan_detail->pengajuan_id, $r4->id, $f->id, $r3->kode_rekening);
                                                            if ($r4->tipe == 'pergeseran' && $r4->fase_id == $f->id) {
                                                                $rincian_geser = App\Models\DetailRincian::get_komponen_id($r4->id);
                                                            }
                                                            if ($rincian_geser || $rincian_geser == 'bedarekening') {
                                                                $jml_geser++;
                                                            }

                                                            $harga_ppn = @$rincian_geser->harga_pergeseran + (@$rincian_geser->harga_pergeseran * @$rincian_geser->ppn_pergeseran) / 100;
                                                            $total = $harga_ppn * @$rincian_geser->volume_pergeseran;
                                                            $selisih = $total - $selisih;
                                                        @endphp
                                                        {{-- <td>&nbsp;&nbsp;&nbsp;
                                                            {!! @$rincian_geser->detail_pergeseran !!} {{ @$rincian_geser->spek_pergeseran }}
                                                        </td> --}}
                                                        <td>
                                                            {!! @$rincian_geser->satuan_pergeseran !!}
                                                        </td>
                                                        <td>
                                                            {!! @$rincian_geser->koefisien_pergeseran !!}
                                                        </td>
                                                        <td align="right">
                                                            @if ($rincian_geser || $rincian_geser == 'bedarekening')
                                                                {!! number_format(@$rincian_geser->harga_pergeseran, 0, ',', '.') !!}
                                                            @endif
                                                        </td>
                                                        <td align="right">
                                                            @if ($rincian_geser || $rincian_geser == 'bedarekening')
                                                                {!! number_format(@$rincian_geser->ppn_pergeseran, 0, ',', '.') !!}
                                                            @endif
                                                        </td>
                                                        <td align="right">
                                                            @if ($rincian_geser || $rincian_geser == 'bedarekening')
                                                                {!! number_format($total, 0, ',', '.') !!}
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    <td align="right">
                                                        @if ($jml_geser > 0)
                                                            {!! number_format(@$selisih, 0, ',', '.') !!}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endpush
                                        @php
                                            $subtotal += $harga_ppn;
                                        @endphp
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach

                    @push('subtotal')
                        {{-- <tr>
                            <td colspan="5" style="text-align: right"><b>Total</b></td>
                            <td align="right">
                                <b>
                                    {!! number_format($subtotal, 0, ',', '.') !!}
                                </b>
                            </td>
                            <td></td>
                        </tr> --}}
                    @endpush
                    @stack('subtotal')
                    @stack('detail')
                </tbody>
            </table>
        </div>
        </div>


        <div style="width: 100%; text-align: right;">
            <br><br>
            <table style="width: 100%;">
                <tr>
                    @if ($data->usulan->id == 4)
                        <td colspan="5" style="width: 5%">
                        </td>
                        <td colspan="11" style="width: 60%">
                            Mengetahui
                            <br>
                            {{ $nama_skpd_kiri }}
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <b><u>{{ $opd->kepala_nama }}</u></b>
                            <br>
                            Pangkat. {{ $opd->kepala_pangkat }}
                            <br>
                            NIP. {{ $opd->kepala_nip }}
                        </td>
                        <td style="text-align: center;width: 30%">
                            Mengetahui
                            <br>
                            {{ $data->pptk_jabatan }}
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <b><u>{{ $data->pptk_nama }}</u></b>
                            <br>
                            {{ $data->pptk_pangkat }}
                            <br>
                            NIP. {{ $data->pptk_nip }}
                        </td>
                    @elseif($data->usulan->id == 1 || $data->usulan->id == 2 || $data->usulan->id == 3)
                        <td width="75%">
                        </td>

                        </td>
                        <td style="width: 25%">
                            Mengetahui
                            <br>
                            {{ $nama_skpd_kiri }}
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <b><u>{{ $opd->kepala_nama }}</u></b>
                            <br>
                            {{ $opd->kepala_pangkat }}
                            <br>
                            NIP. {{ $opd->kepala_nip }}
                        </td>
                    @endif
                </tr>
            </table>
    </body>
@endforeach
@stack('scripts')

</html>
