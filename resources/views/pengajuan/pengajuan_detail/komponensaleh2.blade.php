@extends('layouts.app')
@section('nama_header', 'Detail Komponen')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Data</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="lni lni-bookmark-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ @$nama_header }}</li>
                </ol>
            </nav>
        </div>

        <div class="ms-auto">
            <a href="{{ URL::previous() }}" onclick="closeTabs()" type="button" class="btn btn-sm btn-danger">
                <b><i class="fa fa-arrow-left"></i></b> Kembali
            </a>
            <a target="_blank" href="{{ route('sub_kegiatan_rincian_komponen', encrypt($sub_keg->id)) }}" type="button"
                id="simpan" class="btn btn-sm waves-effect btn-warning btn-md">
                <i class=" bx bx-command"></i> Sesuaikan Rincian Murni
            </a>
        </div>
    </div>
    <!--end breadcrumb-->

    @if (session()->has('status'))
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><i class='bx bxs-check-circle'></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Berhasil</h6>
                    <div class="text-white">
                        <p>{{ session()->get('status') }}
                            {{ session()->forget('status') }}</p>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('statusT'))
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Gagal</h6>
                    <div class="text-white">
                        <p>{{ session()->get('statusT') }}
                            {{ session()->forget('statusT') }}</p>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body overflow-hidden p-relative z-index-1">
            <div class="row">
                <div class="col-sm-5">
                    <b>Status </b> : <span class="badge badge-{{ $pengajuan->stat->color_div }}">
                        <b>{{ @$pengajuan->stat->nama }}</b>
                    </span>
                    <br>
                    <b>Pengusul</b> : {{ @$pengajuan->skpd->unit_name }}
                    <br>
                    <b>SKPD</b> : {{ $pengajuan->unit_id }}
                    <br>
                    <b>Fase</b> : {{ @$pengajuan->fase->nama }}
                    <br>
                    <b>Tanggal Surat</b> : {{ $pengajuan->tanggal_surat }}
                    <br>
                    <b>Nomor Surat</b> : {{ $pengajuan->nomor_surat }}
                    <br>
                    <b>Usulan</b> : {{ @$pengajuan->usulan->usulan }}
                    <br>
                    <b>Tahun </b> : <b style="color: red">{{ @$pengajuan->tahun }}</b>
                </div>
                <div class="col-sm-7">
                    Program : <b>{{ $sub_keg->kegiatan->program->kode_program }}
                        {{ $sub_keg->kegiatan->program->nama_program }}</b><br>
                    Kegiatan : <b>{{ $sub_keg->kegiatan->kode_kegiatan }} {{ $sub_keg->kegiatan->nama_kegiatan }}</b><br>
                    Sub Kegiatan : <b>{{ $sub_keg->kode_sub_kegiatan }} {{ $sub_keg->nama_sub_kegiatan }}</b><br>
                    Jenis Pergeseran : <b>{{ $pengajuan_detail->pengajuan->usulan->usulan }}</b><br>
                    Jenis Pergeseran : <b>{{ $pengajuan_detail->id }}</b><br>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body overflow-hidden p-relative z-index-1">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <table class="table table-bordered table-hover" border="1">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" colspan="6">Rincian Murni</th>
                                    {{-- <th style="text-align: center; width: 47%;" colspan="6">Rincian Perubahan</th> --}}
                                    <th style="text-align: center; " rowspan="2">Act</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">Uraian</th>
                                    <th style="text-align: center;">Satuan</th>
                                    <th style="text-align: center;">Koefisien</th>
                                    <th style="text-align: center;">Harga</th>
                                    <th style="text-align: center;">PPN</th>
                                    <th style="text-align: center;">Jumlah</th>


                                    {{-- <th style="text-align: center; ">Uraian</th>
                                    <th style="text-align: center;">Satuan</th>
                                    <th style="text-align: center;">Koefisien</th>
                                    <th style="text-align: center;">Harga</th>
                                    <th style="text-align: center;">PPN</th> 
                                    <th style="text-align: center;">Jumlah</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($details as $r1)
                                    @php
                                        $detail_id = App\Models\Detail::where('subtitle', $r1->subtitle)
                                            ->where('master_sub_kegiatan_id', $r1->master_sub_kegiatan_id)
                                            ->first();
                                        $detail_rincian_pergeseran = App\Models\DetailRincian::where('pengajuan_id', $pengajuan_detail->pengajuan_id)->where('master_sub_kegiatan_id', $id_sub_kegiatan);
                                        if ($pengajuan_detail->pengajuan->usulan->id == 4) {
                                            $detail_rincian_pergeseran = $detail_rincian_pergeseran->where('detail_id', $detail_id->id);
                                        }
                                        $detail_rincian_pergeseran = $detail_rincian_pergeseran
                                            ->distinct()
                                            ->orderBy('subtitle_pergeseran')
                                            ->first();
                                    @endphp
                                    @push('detail')
                                        <tr>
                                            <td colspan="7"><b>{!! $r1->subtitle ?? '#' !!}</b></td>
                                        </tr>
                                    @endpush
                                    <?php
                                    $data_ket_bl_teks = App\Models\Detail::get_sub2($r1->master_sub_kegiatan_id, $r1->subtitle);
                                    ?>
                                    @foreach ($data_ket_bl_teks as $r2)
                                        <?php
                                        $data_ket_bl_teks_pergeseran = App\Models\DetailRincian::get_sub2(@$id_sub_kegiatan, @$detail_rincian_pergeseran->subtitle_pergeseran, @$pengajuan_detail->pengajuan_id);
                                        
                                        $data_rekening = App\Models\Detail::get_rekening($r1->master_sub_kegiatan_id, $r1->subtitle, $r2->subtitle2);
                                        
                                        ?>
                                        @push('detail')
                                            <tr>
                                                <td colspan="7">&nbsp;<b>{!! $r2->subtitle2 ?? '-' !!} </b>
                                                </td>
                                            </tr>
                                        @endpush
                                        @foreach ($data_rekening as $r3)
                                            <?php
                                            $length = 0;
                                            $data_komponen = App\Models\Detail::get_komponen($r1->master_sub_kegiatan_id, $r1->subtitle, $r2->subtitle2, $r3->kode_rekening);
                                            
                                            // $data_komponen_pergeseran = App\Models\DetailRincian::get_komponen(@$detail_rincian_pergeseran->master_sub_kegiatan_id, @$detail_rincian_pergeseran->subtitle, @$data_ket_bl_teks_pergeseran->subtitle2, @$data_rekening_pergesran->kode_rekening, @$pengajuan_detail->pengajuan_id);
                                            $id_detail_murni = App\Models\Detail::where('kode_rekening', $r3->kode_rekening)
                                                ->where('subtitle', $r1->subtitle)
                                                ->where('subtitle2', $r2->subtitle2)
                                                ->where('rekenings_id', $r3->rekenings_id)
                                                ->first();
                                            
                                            $data_rekening_pergeseran = App\Models\DetailRincian::get_rekening($id_sub_kegiatan, @$detail_rincian_pergeseran->subtitle_pergeseran, @$data_ket_bl_teks_pergeseran->subtitle2_pergeseran, $pengajuan_detail->pengajuan_id, $id_detail_murni->id, $r3->kode_rekening);
                                            ?>
                                            @push('detail')
                                                <tr>
                                                    @if ($pengajuan_detail->pengajuan->usulan->id != 4)
                                                        <td colspan="6">&nbsp;&nbsp;&nbsp;
                                                            <b>
                                                                {!! $r3->kode_rekening !!}
                                                                {!! @$r3->rekening->nama_rek ?? '' !!}
                                                            </b>
                                                        </td>
                                                        <td style="text-align: center">
                                                            @if ($pengajuan_detail->pengajuan->usulan->id == 1)
                                                                @php $length = 6; @endphp
                                                            @elseif($pengajuan_detail->pengajuan->usulan->id == 2)
                                                                @php $length = 9; @endphp
                                                            @elseif($pengajuan_detail->pengajuan->usulan->id == 3)
                                                                @php $length = 12; @endphp
                                                            @endif
                                                            @php
                                                                $kode_rekening = substr($r3->kode_rekening, 0, $length);
                                                            @endphp
                                                            @if (@$data_rekening_pergeseran->flag == 0)
                                                                <button title="Pergeseran Rekening" data-toggle="tooltip"
                                                                    onclick="update_kode_rekening('{{ csrf_token() }}', '{{ route('update_kode_rekening', $id_detail_murni->id) }}','{{ encrypt($pengajuan_detail->id) }}','{{ $kode_rekening }}','#ModalKuningSm')"
                                                                    class="btn btn-sm btn-outline-warning">
                                                                    <i
                                                                        class="bx bx-message-check
                                                                    me-0"></i>
                                                                </button>
                                                            @endif

                                                        </td>
                                                    @else
                                                        <td colspan="7">&nbsp;&nbsp;&nbsp;<b>
                                                                {{ $detail_id->id }}
                                                                {!! $r3->kode_rekening !!}
                                                                {!! @$r3->rekening->nama_rek ?? '' !!}</b></td>
                                                        </td>
                                                    @endif

                                                </tr>
                                            @endpush
                                            @foreach ($data_komponen as $r4)
                                                @php
                                                    $data_komponen_pergeseran = App\Models\DetailRincian::get_komponen($id_sub_kegiatan, @$detail_rincian_pergeseran->subtitle_pergeseran, @$data_ket_bl_teks_pergeseran->subtitle2_pergeseran, @$data_rekening_pergeseran->kode_rekening_pergeseran, $pengajuan_detail->pengajuan_id, $id_detail_murni->id);
                                                @endphp
                                                @push('detail')
                                                    <tr>
                                                        <td>&nbsp;&nbsp;&nbsp;
                                                            {!! $r4->detail !!} {{ $r4->spek }}
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
                                        <td></td>
                                    </tr>
                                @endpush
                                @stack('subtotal')
                                @stack('detail')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



{{-- <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Data</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="lni lni-bookmark-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Pergeseran</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body overflow-hidden p-relative z-index-1">

            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-body">

                        <div style="width: 100%; overflow: auto">
                            <table class="table table-sm table-bordered table-hover datatable-not-sortable-paging"
                                tyle="border-collapse: collapse; border-spacing: 0; width: 100%; ">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2" style="width: 1%">
                                            <input type="checkbox" name=""
                                                style="transform: scale(1.5)  !important"
                                                onchange="
                      chk_all(this.checked);
                      chk_data_usulan();">
                                        </th>
                                        <th rowspan="2">Kode</th>
                                        <th rowspan="2">Uraian</th>
                                        <th colspan="5" style="text-align: center">Sebelum Perubahan</th>
                                        <th colspan="5" style="text-align: center">Setelah Perubahan</th>
                                        <th rowspan="2">Bertambah / Berkurang</th>
                                        <th rowspan="2">Ket</th>
                                        <th rowspan="2">Act</th>
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
                                        <th>13</th>
                                        <th>14</th>
                                        <th>15 = 14 - 9</th>
                                        <th>16</th>
                                        <th>17</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 0;
                                    @endphp
                                    @foreach ($data as $r)
                                        @php
                                            $no++;
                                            $warnadiv = '';
                                            $jumlah_sebelum_pergeseran = $r->harga + $r->harga * $r->ppn;
                                            $jumlah_setelah_pergeseran = $r->harga_pergeseran + $r->harga_pergeseran * $r->ppn_pergeseran;
                                            $total = $jumlah_setelah_pergeseran - $jumlah_sebelum_pergeseran;
                                            // if (empty(@$r->sub_kegiatan->nama_sub_kegiatan)) {
                                            //     $warnadiv = 'danger';
                                            // }
                                        @endphp
                                        <tr>
                                            <td align="center">asd</td>
                                            <td>
                                                <input name="chk_data" type="checkbox" value="id"
                                                    style="transform: scale(1.5)  !important"
                                                    onchange="chk_data_usulan()">
                                                <input type="hidden" value="id" name="list_detail[]">
                                                <input type="hidden" value="id" name="ids[]">
                                            </td>
                                            <td>
                                                <span class="badge badge-primary">
                                                    {{ $r->kode_rekening }}
                                                </span>
                                            </td>
                                            <td><span class="cls_edit">{{ $r->detail }}</span>
                                            </td>
                                            <td><span class="cls_edit">{{ $r->koefisien }}</span>
                                            </td>
                                            <td>
                                                <span class="cls_edit">{{ $r->satuan }}</span>
                                            </td>
                                            <td style="text-align: right">
                                                {{ format_harga($r->harga) }}
                                            </td>

                                            <td style="text-align: right">
                                                {{ $r->ppn }}
                                            </td>
                                            <td>
                                                <span
                                                    class="cls_edit div_mulai_setujui">{{ format_harga($jumlah_sebelum_pergeseran) }}</span>
                                            </td>

                                            <td><span class="cls_edit">{{ $r->koefisien_pergeseran }}</span>
                                            </td>
                                            <td>
                                                <span class="cls_edit">{{ $r->satuan_pergeseran }}</span>
                                            </td>
                                            <td style="text-align: right">
                                                {{ format_harga($r->harga_pergeseran) }}
                                            </td>

                                            <td style="text-align: right">
                                                {{ $r->ppn_pergeseran }}
                                            </td>
                                            <td>
                                                <span
                                                    class="cls_edit div_mulai_setujui">{{ format_harga($jumlah_setelah_pergeseran) }}</span>
                                            </td>
                                            </td>
                                            <td>
                                                <span class="cls_edit div_mulai_setujui">{{ format_harga($total) }}</span>
                                            </td>
                                            <td>{{ @$r->keterangan ?? '-' }}</td>
                                            <td> <button title="Pergeseran" data-toggle="tooltip"
                                                    onclick="update_detail_komponen('{{ csrf_token() }}', '{{ route('update_detail_komponen', $r4->id) }}','{{ encrypt($pengajuan_detail->id) }}', '#ModalBiruSm')"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-trash me-0"></i>
                                                </button></td>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
--}}
@push('scripts')
    <script !src="">
        var loading = '-- Sedang Memuat Data --';

        var div_default = ` 
                <div class="alert bg-info text-white alert-styled-left alert-dismissible">
                    <span class="font-weight-semibold"> -- Silahkan Mengisi Form Diatas Terlebih Dahulu Kemudian Klik Tombol Tampilkan --</span>
                </div>
            `;
        //select option
        $('.select22').select2();

        function closeTabs() {
            window.close();
        }

        // START SCRIPT TABEL 
        $(document).ready(function() {
            var table = $('.datatable-basic-komponen').DataTable({
                "ordering": false,
                "paginate": false,
                "autoWidth": true,
                "columnDefs": [],
                "order": false,
            });
        });
        // END SCRIPT TABEL 


        // function update_detail_komponen(token, url, pengajuan_detail_id, modal) {
        //     $(modal).modal("show");
        //     $(modal + "Label").html("Geser Komponen");
        //     $(modal + "Isi").html(loading);
        //     var act = url;
        //     $.post(
        //         act, {
        //             _token: token,
        //             pengajuan_detail_id: pengajuan_detail_id
        //         },
        //         function(data) {
        //             $(modal + "Isi").html(data);
        //         }
        //     );
        // }

        function update_detail_rincian(token, url, pengajuan_detail_id, modal) {
            $(modal).modal("show");
            $(modal + "Label").html("Geser Komponen");
            $(modal + "Isi").html(loading);
            var act = url;
            $.post(
                act, {
                    _token: token,
                    pengajuan_detail_id: pengajuan_detail_id
                },
                function(data) {
                    $(modal + "Isi").html(data);
                }
            );
        }

        function update_kode_rekening(token, url, pengajuan_detail_id, kode_rekening, modal) {
            $(modal).modal("show");
            $(modal + "Label").html("Geser Komponen Rekening");
            $(modal + "Isi").html(loading);
            var act = url;
            $.post(
                act, {
                    _token: token,
                    pengajuan_detail_id: pengajuan_detail_id,
                    kode_rekening: kode_rekening
                },
                function(data) {
                    $(modal + "Isi").html(data);
                }
            );
        }
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
