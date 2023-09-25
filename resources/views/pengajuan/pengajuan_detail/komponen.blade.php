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
                                    @foreach ($fases as $f)
                                        <th style="text-align: center;" colspan="6">{{ $f->nama }}</th>
                                    @endforeach
                                    <th style="text-align: center; " rowspan="2">Bertambah / <br>Berkurang</th>
                                    <th style="text-align: center; " rowspan="2">Act</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">Uraian</th>
                                    <th style="text-align: center;">Satuan</th>
                                    <th style="text-align: center;">Koefisien</th>
                                    <th style="text-align: center;">Harga</th>
                                    <th style="text-align: center;">PPN</th>
                                    <th style="text-align: center;">Jumlah</th>

                                    @foreach ($fases as $f)
                                        <th style="text-align: center;">Uraian</th>
                                        <th style="text-align: center;">Satuan</th>
                                        <th style="text-align: center;">Koefisien</th>
                                        <th style="text-align: center;">Harga</th>
                                        <th style="text-align: center;">PPN</th>
                                        <th style="text-align: center;">Jumlah</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody>
                                @php $subtotal = 0; @endphp
                                @foreach ($details as $r1)
                                    @php
                                        $detail_rincian_pergeseran = App\Models\DetailRincian::where('pengajuan_id', $pengajuan_detail->pengajuan_id)
                                            ->where('master_sub_kegiatan_id', $id_sub_kegiatan)
                                            ->distinct()
                                            ->orderBy('subtitle_pergeseran')
                                            ->first();
                                    @endphp
                                    @push('detail')
                                        <tr>
                                            @php
                                                $jmlcolspan = 6;
                                                foreach ($fases as $f) {
                                                    $jmlcolspan += 6;
                                                }
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
                                        
                                        $data_rekening = App\Models\Detail::get_rekening($r1->master_sub_kegiatan_id, $r1->subtitle, $r2->subtitle2);
                                        
                                        ?>
                                        @push('detail')
                                            <tr>
                                                @php
                                                    $jmlcolspan = 6;
                                                    foreach ($fases as $f) {
                                                        $jmlcolspan += 6;
                                                    }
                                                @endphp
                                                <td colspan="{{ $jmlcolspan }}">&nbsp;<b>{!! $r2->subtitle2 ?? '-' !!} </b></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endpush
                                        @foreach ($data_rekening as $r3)
                                            <?php
                                            $length = 0;
                                            $data_komponen = App\Models\Detail::get_komponen($r1->master_sub_kegiatan_id, $r1->subtitle, $r2->subtitle2, $r3->kode_rekening);
                                            $id_detail_murni = App\Models\Detail::where('kode_rekening', $r3->kode_rekening)
                                                ->where('subtitle', $r1->subtitle)
                                                ->where('subtitle2', $r2->subtitle2) 
                                                ->first();
                                            
                                            ?>
                                            @push('detail')
                                                <tr>
                                                    @if ($pengajuan_detail->pengajuan->usulan->id != 4)
                                                        @php
                                                            $jmlcolspan = 6;
                                                            foreach ($fases as $f) {
                                                                $jmlcolspan += 6;
                                                            }
                                                        @endphp
                                                        <td colspan="{{ $jmlcolspan }}">&nbsp;&nbsp;&nbsp;
                                                            <b>
                                                                {{ $r3->id }}
                                                                {!! $r3->kode_rekening !!}
                                                                {!! @$r3->rekening->nama_rek ?? '' !!}
                                                            </b>
                                                        </td>
                                                        <td></td>
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
                                                        @php
                                                            $jmlcolspan = 8;
                                                            foreach ($fases as $f) {
                                                                $jmlcolspan += 8;
                                                            }
                                                        @endphp
                                                        <td colspan="{{ $jmlcolspan }}">&nbsp;&nbsp;&nbsp;<b>
                                                                {!! $r3->kode_rekening !!}
                                                                {!! @$r3->rekening->nama_rek ?? '' !!}</b></td>
                                                        </td>
                                                    @endif

                                                </tr>
                                            @endpush
                                            @foreach ($data_komponen as $r4)
                                                @php
                                                    
                                                    $data_rekening_pergeseran = App\Models\DetailRincian::get_rekening($id_sub_kegiatan, @$detail_rincian_pergeseran->subtitle_pergeseran, @$data_ket_bl_teks_pergeseran->subtitle2_pergeseran, $pengajuan_detail->pengajuan_id, $r4->id, $r3->kode_rekening);
                                                    $harga_ppn = $r4->harga + ($r4->harga * $r4->ppn) / 100;
                                                    $total = $harga_ppn * $r4->volume;
                                                    $selisih = $total;
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
                                                            {!! number_format($total, 0, ',', '.') !!}
                                                        </td>

                                                        @foreach ($fases as $f)
                                                            @php
                                                                $rincian_geser = App\Models\DetailRincian::get_komponen_fase($pengajuan_detail->pengajuan_id, $r4->id, $f->id, $r3->kode_rekening);

                                                                $harga_ppn = @$rincian_geser->harga_pergeseran + (@$rincian_geser->harga_pergeseran * @$rincian_geser->ppn_pergeseran) / 100;
                                                                $total = $harga_ppn * @$rincian_geser->volume_pergeseran;
                                                                $selisih = $total - $selisih;
                                                            @endphp
                                                            <td>&nbsp;&nbsp;&nbsp;
                                                                {!! @$rincian_geser->detail_pergeseran !!} {{ @$rincian_geser->spek_pergeseran }}
                                                            </td>
                                                            <td>
                                                                {!! @$rincian_geser->satuan_pergeseran !!}
                                                            </td>
                                                            <td>
                                                                {!! @$rincian_geser->koefisien_pergeseran !!}
                                                            </td>
                                                            <td align="right">
                                                                {!! number_format(@$rincian_geser->harga_pergeseran, 0, ',', '.') !!}
                                                            </td>
                                                            <td align="right">
                                                                {!! number_format(@$rincian_geser->ppn_pergeseran, 0, ',', '.') !!}
                                                            </td>
                                                            <td align="right">
                                                                {!! number_format($total, 0, ',', '.') !!}
                                                            </td>
                                                        @endforeach
                                                        <td align="right">
                                                            {!! number_format(@$selisih*(-1), 0, ',', '.') !!}
                                                        </td>

                                                        <td style="text-align: center">
                                                            <button title="Pergeseran Rincian" data-toggle="tooltip"
                                                                onclick="update_detail_rincian('{{ csrf_token() }}', '{{ route('update_detail_rincian', $r4->id) }}','{{ encrypt($pengajuan_detail->id) }}', '#ModalBiruSm')"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i
                                                                    class="bx bx-message-check
                                                                me-0"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endpush
                                                @php
                                                    $subtotal += $harga_ppn;
                                                @endphp
                                            @endforeach
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
            </div>
        </div>
    </div>
@endsection
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
