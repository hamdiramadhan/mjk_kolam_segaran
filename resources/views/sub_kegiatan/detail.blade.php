<style type="text/css">
    .table-hamdi tbody tr td {
        word-break: break-word !important;
        white-space: pre-line !important;
        overflow-wrap: break-word !important;
        -ms-word-break: break-word !important;
        -ms-hyphens: auto !important;
        -moz-hyphens: auto !important;
        -webkit-hyphens: auto !important;
        hyphens: auto !important;
        vertical-align: top !important;

    }

    .table-group {
        background-color: #ccf6c8
    }
</style>
<a href="{{ route('sub_kegiatan_rincian_komponen', encrypt($id_sub_kegiatan)) }}" target="_blank"
    class="btn btn-success btn-sm " data-popup="tooltip" title="Aksi Komponen" style="margin-bottom:20px">
    <i class="fas fa-plus"></i> Aksi Komponen
</a>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center; " rowspan="2">Uraian</th>
            <th style="text-align: center; width: 47%;" colspan="4">Rincian Perhitungan</th>
            <th style="text-align: center; width: 14%;" rowspan="2">Jumlah</th>
        </tr>
        <tr>
            <th style="text-align: center;">Satuan</th>
            <th style="text-align: center;">Koefisien</th>
            <th style="text-align: center;">Harga</th>
            <th style="text-align: center;">PPN</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach ($details as $r1)
            @push('detail')
                <tr>
                    <td colspan="6"><b>{!! $r1->subtitle !!}</b></td>
                </tr>
            @endpush
            <?php
            $data_ket_bl_teks = App\Models\Detail::get_sub2($r1->master_sub_kegiatan_id, $r1->subtitle);
            ?>
            @foreach ($data_ket_bl_teks as $r2)
                <?php
                $data_rekening = App\Models\Detail::get_rekening($r1->master_sub_kegiatan_id, $r1->subtitle, $r2->subtitle2);
                ?>
                @push('detail')
                    <tr>
                        <td colspan="6">&nbsp;<b>{!! $r2->subtitle2 !!}</b></td>
                    </tr>
                @endpush
                @foreach ($data_rekening as $r3)
                    <?php
                    $data_komponen = App\Models\Detail::get_komponen($r1->master_sub_kegiatan_id, $r1->subtitle, $r2->subtitle2, $r3->kode_rekening);
                    ?>
                    @push('detail')
                        <tr>
                            <td colspan="6">&nbsp;&nbsp;&nbsp;<b>{!! $r3->kode_rekening !!} {!! $r3->rekening->nama_rek ?? '' !!}</b></td>
                        </tr>
                    @endpush
                    @foreach ($data_komponen as $r4)
                        @push('detail')
                            <tr>
                                <td>&nbsp;&nbsp;&nbsp;
                                    {!! $r4->detail !!} - {{ $r4->spek }}
                                </td>
                                <td>
                                    {!! $r4->satuan !!}
                                </td>
                                <td>
                                    {!! $r4->koefisien !!}
                                </td>
                                <td align="right">
                                    {!! number_format($r4->harga, 0, ',', '.') !!}
                                </td>
                                <td align="right">
                                    {!! number_format($r4->ppn, 0, ',', '.') !!}
                                </td>
                                <td align="right">
                                    <?php
                                    $harga_ppn = $r4->harga + ($r4->harga * $r4->ppn) / 100;
                                    ?>
                                    {!! number_format($harga_ppn * $r4->volume, 0, ',', '.') !!}
                                </td>
                            </tr>
                        @endpush
                        @php
                            $total += $harga_ppn;
                        @endphp
                    @endforeach
                @endforeach
            @endforeach
        @endforeach

        @push('subtotal')
            <tr>
                <td colspan="5" style="text-align: right"><b>Total</b></td>
                <td align="right">
                    <b>
                        {!! number_format($total, 0, ',', '.') !!}
                    </b>
                </td>
            </tr>
        @endpush
        @stack('subtotal')
        @stack('detail')
    </tbody>
</table>
<script type="text/javascript">
    // START SCRIPT TABEL 
    // $(document).ready(function() {
    //     var table = $('.datatable-basic-komponen').DataTable({
    //         "ordering": false,
    //         "paginate": false,
    //         "autoWidth": true,
    //         "columnDefs": [{
    //             "visible": false,
    //             "targets": [0, 1, 2]
    //         }],
    //         "order": false,
    //         rowGroup: {
    //             dataSrc: [0, 1, 2],
    //             className: 'table-group'
    //         },
    //         "order": false,
    //     });
    // });
    // END SCRIPT TABEL 
</script>
