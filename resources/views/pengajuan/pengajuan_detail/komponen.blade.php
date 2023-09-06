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
            <button onclick="closeTabs()" type="button" class="btn btn-sm btn-danger">
                <b><i class="fa fa-arrow-left"></i></b> Kembali
            </button>
            {{-- <button type="button" id="simpan" class="btn btn-sm waves-effect btn-primary btn-md"
                onclick="$('.modalAddKomponen').modal('show')">
                <i class=" fas fa-plus"></i> Tambah
            </button> --}}
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
            <b>
                {{ @Auth::user()->skpd->unit_name ?? 'Data Global' }} TAHUN {{ Auth::user()->tahun }}
            </b>
            <br>
            Program : <b>{{ $sub_keg->kegiatan->program->kode_program }}
                {{ $sub_keg->kegiatan->program->nama_program }}</b><br>
            Kegiatan : <b>{{ $sub_keg->kegiatan->kode_kegiatan }} {{ $sub_keg->kegiatan->nama_kegiatan }}</b><br>
            Sub Kegiatan : <b>{{ $sub_keg->kode_sub_kegiatan }} {{ $sub_keg->nama_sub_kegiatan }}</b><br>
            Jenis Pergeseran : <b>{{ $pengajuan_detail->pengajuan->usulan->usulan }}</b><br>
        </div>
    </div>


    <div class="card">
        <div class="card-body overflow-hidden p-relative z-index-1">

            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center; " rowspan="2">Uraian</th>
                                    <th style="text-align: center; width: 47%;" colspan="4">Rincian Perhitungan</th>
                                    <th style="text-align: center; width: 14%;" rowspan="2">Jumlah</th>
                                    <th style="text-align: center; " rowspan="2">Act</th>
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
                                            <td></td>
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
                                                <td></td>
                                            </tr>
                                        @endpush
                                        @foreach ($data_rekening as $r3)
                                            <?php
                                            $data_komponen = App\Models\Detail::get_komponen($r1->master_sub_kegiatan_id, $r1->subtitle, $r2->subtitle2, $r3->kode_rekening);
                                            ?>
                                            @push('detail')
                                                <tr>
                                                    <td colspan="6">&nbsp;&nbsp;&nbsp;<b>{!! $r3->kode_rekening !!}
                                                            {!! $r3->rek->nama_rekening ?? '' !!}</b></td>
                                                    <td></td>

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
                                                        <td>
                                                            <div class="d-flex p-2">
                                                                @if ($r4->flag != 1)
                                                                    <button title="Pergeseran" data-toggle="tooltip"
                                                                        onclick="update_detail_komponen('{{ csrf_token() }}', '{{ route('update_detail_komponen', $r4->id) }}','{{ encrypt($pengajuan_detail->id) }}', '#ModalBiruSm')"
                                                                        class="btn btn-sm btn-outline-primary">
                                                                        <i
                                                                            class="bx bx-message-check
                                                                    me-0"></i>
                                                                    </button>
                                                                @endif
                                                                {{-- <button type="button"
                                                                    onclick="delete_detail_komponen('{{ csrf_token() }}', '{{ $r4->id }}')"
                                                                    title="Hapus" class="btn btn-sm btn-outline-danger">
                                                                    <i class="bx bx-trash me-0"></i>
                                                                </button> --}}
                                                            </div>
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


        function update_detail_komponen(token, url, pengajuan_detail_id, modal) {
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
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
