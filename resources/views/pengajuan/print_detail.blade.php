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
@foreach ($pengajuan_detail as $subkeg)

    <head>
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
        </style>
        <title>Lampiran Pergeseran</title>
        <style>
            footer {
                position: fixed;
                bottom: -35px;
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
        </style>
    </head>

    <body style="font-size: 12pt">
        <footer>
            <table style="width: 100%;border-top: 1px solid gray" border="0">
                <tr>
                    <td>
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
                    <td style="width: 200px">Nomor </td>
                    <td style="width: 20px">&nbsp; : &nbsp;</td>
                    <td>
                        {{ $data->nomor_surat }}
                    </td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>&nbsp; : &nbsp;</td>
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
            Sub Kegiatan ({{ $subkeg->sub_kegiatan->kode_sub_kegiatan }}) {{ $subkeg->sub_kegiatan->nama_sub_kegiatan }}
            {{-- {{ strtoupper($uk->unit_name) }} --}}
            <br>
            Sumber Dana:
            @foreach ($subkeg->sumberdanas as $sb)
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
                        <th rowspan="2">Kode</th>
                        <th rowspan="2">Uraian</th>
                        <th colspan="5" style="text-align: center">Sebelum Perubahan</th>
                        <th colspan="5" style="text-align: center">Setelah Perubahan</th>
                        <th rowspan="2">Bertambah / Berkurang</th>
                    </tr>
                    <tr>
                        <th>Koefisien</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>PPN</th>
                        <th>Jumlah</th>
                        <th>Koefisien</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>PPN</th>
                        <th>Jumlah</th>
                    </tr>
                    <tr>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        <th>9</th>
                        <th>10</th>
                        <th>11</th>
                        <th>12</th>
                        <th>13 = 12 - 7</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($subkeg->rincians as $r)
                        @php
                            $no++;
                            $warnadiv = '';
                            $jumlah_sebelum_pergeseran = $r->detail->harga + $r->detail->harga * $r->detail->ppn;
                            $jumlah_setelah_pergeseran = $r->harga_pergeseran + $r->harga_pergeseran * $r->ppn_pergeseran;
                            $total = $jumlah_setelah_pergeseran - $jumlah_sebelum_pergeseran;
                            // if (empty(@$r->sub_kegiatan->nama_sub_kegiatan)) {
                            //     $warnadiv = 'danger';
                            // }
                        @endphp
                        <tr>
                            <span class="badge badge-primary">
                                {{ $r->detail->kode_rekening }}
                            </span>
                            </td>
                            <td><span class="cls_edit">{{ $r->detail->detail }}</span>
                            </td>
                            <td style="text-align: center"><span class="cls_edit">{{ $r->detail->koefisien }}</span>
                            </td>
                            <td style="text-align: center">
                                <span class="cls_edit">{{ $r->detail->satuan }}</span>
                            </td>
                            <td style="text-align: center">
                                {{ format_harga($r->detail->harga) }}
                            </td>

                            <td style="text-align: center">
                                {{ $r->detail->ppn }}
                            </td>
                            <td>
                                <span
                                    class="cls_edit div_mulai_setujui">{{ format_harga($jumlah_sebelum_pergeseran) }}</span>
                            </td>

                            <td style="text-align: center"><span class="cls_edit">{{ $r->koefisien_pergeseran }}</span>
                            </td>
                            <td style="text-align: center">
                                <span class="cls_edit">{{ $r->satuan_pergeseran }}</span>
                            </td>
                            <td style="text-align: center">
                                {{ format_harga($r->harga_pergeseran) }}
                            </td>

                            <td style="text-align: center">
                                {{ $r->ppn_pergeseran }}
                            </td>
                            <td style="text-align: center">
                                <span
                                    class="cls_edit div_mulai_setujui">{{ format_harga($jumlah_setelah_pergeseran) }}</span>
                            </td>
                            <td style="text-align: center">
                                <span class="cls_edit div_mulai_setujui">{{ format_harga($total) }}</span>
                            </td>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="width: 100%; text-align: right;">
            <br><br>
            <table style="width: 100%;" border="0">
                <tr>
                    <td colspan="5" style="width: 5%">
                    </td>
                    <td colspan="11" style="width: 60%">
                        Mengetahui
                        <br>
                        Kepala SKPD
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <b><u>{{ $opd->kepala_nama }}</u></b>
                        <br>
                        Pangkat. {{ $opd->kepala_jabatan }}
                        <br>
                        NIP. {{ $opd->kepala_nip }}
                    </td>
                    <td style="text-align: center;width: 30%">
                        Mengetahui
                        <br>
                        Kepala SKPD/KPA/PPATK
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <b><u>{{ $opd->kepala_nama }}</u></b>
                        <br>
                        Pangkat. {{ $opd->kepala_jabatan }}
                        <br>
                        NIP. {{ $opd->kepala_nip }}
                    </td>
                </tr>
            </table>
        </div>
    </body>
@endforeach

</html>
