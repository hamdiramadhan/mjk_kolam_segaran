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
            <button type="button" id="simpan" class="btn btn-sm waves-effect btn-primary btn-md"
                onclick="$('.modalAddKomponen').modal('show')">
                <i class=" fas fa-plus"></i> Tambah
            </button>
        </div>
    </div>
    <!--end breadcrumb-->
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
                                @php
                                    $total = 0;
                                $test = 0; @endphp
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
                                            @php $test++;@endphp

                                            <?php
                                            $data_komponen = App\Models\Detail::get_komponen($r1->master_sub_kegiatan_id, $r1->subtitle, $r2->subtitle2, $r3->kode_rekening);
                                            ?>
                                            @push('detail')
                                                <tr>
                                                    <td colspan="6">&nbsp;&nbsp;&nbsp;
                                                        <b>
                                                            {!! $r3->kode_rekening !!} {!! @$r3->rekening->nama_rek ?? '' !!}
                                                        </b>
                                                    </td>
                                                    <td>
                                                        <button title="Ubah" class="btn btn-sm btn-outline-success"
                                                            onclick="$('.modalAddKomponen').modal('show');
                                                                $('#tmb_subtitle').val('{!! $r1->subtitle !!}');
                                                                $('#tmb_subtitle2').val('{!! $r2->subtitle2 !!}');
                                                                $('#tmb_kode_rekening').val('{!! $r3->kode_rekening !!}');
                                                                $('#tmb_kode_rekening').trigger('change');
                                                                ">
                                                            <i class="bx bx-plus me-0"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endpush
                                            @foreach ($data_komponen as $r4)
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
                                                        <td>
                                                            <div class="d-flex p-2">
                                                                <button title="Ubah"
                                                                    onclick="update_detail_komponen('{{ csrf_token() }}', '{{ route('edit_komponen', $r4->id) }}', '#ModalBiruSm')"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="bx bx-edit me-0"></i>
                                                                </button>
                                                                <button type="button"
                                                                    onclick="delete_detail_komponen('{{ csrf_token() }}', '{{ $r4->id }}')"
                                                                    title="Hapus" class="btn btn-sm btn-outline-danger">
                                                                    <i class="bx bx-trash me-0"></i>
                                                                </button>
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
            <div class="modal fade modalAddKomponen" id="modalAddKomponen">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h6 class="modal-title" style="color:white">
                                Tambah
                            </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('add_komponen') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" class="form-control" id="opd_id" name="opd_id"
                                value="{{ $sub_keg->opd_id }}">
                            <input type="hidden" class="form-control" id="id_kegiatan" name="id_kegiatan"
                                value="{{ $sub_keg->id }}">
                            <input type="hidden" class="form-control" id="tahun" name="tahun"
                                value="{{ date('Y') }}">
                            <div class="modal-body row">
                                <p style="font-weight:bold"><i>Yang bertanda <span class="text-danger">*</span> wajib
                                        diisi/dipilih.</i></p>
                                <div class="col-md-2">Kelompok Belanja <span style="color:red">*</span></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="[#]....."
                                            id="tmb_subtitle" name="subtitle" value="[#]" required>
                                    </div>
                                </div>
                                <div class="col-md-2">Keterangan<span style="color:red">*</span></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="[-]....."
                                            id="tmb_subtitle2" name="subtitle2" value="[-]" required>
                                    </div>
                                </div>

                                <div class="col-md-2">Kode Rekening<span style="color:red">*</span></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select class="select2onmodal" name="kode_rekening" id="tmb_kode_rekening"
                                            style="width: 100%">
                                            @foreach ($data_rekenings as $dt)
                                                <option value="{{ $dt->kode_rek }}"
                                                    {{ strlen($dt->kode_rek) <= 12 ? 'disabled' : '' }}>
                                                    {{ $dt->kode_rek }} - {{ $dt->nama_rek }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">Uraian<span style="color:red">*</span></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Masukkan Uraian"
                                            id="detail" name="detail" required>
                                    </div>
                                </div>
                                <div class="col-md-2">Satuan<span style="color:red">*</span></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select class="select2onmodal" name="satuan" id="satuan" style="width:100%"
                                            required>
                                            @foreach ($data_satuan as $dt)
                                                <option value="{{ $dt->satuan }}">{{ $dt->satuan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">Spek</div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Masukkan Spek"
                                            id="spek" name="spek">
                                    </div>
                                </div>
                                <div class="col-md-2">Koefisien<span style="color:red">*</span></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="number" step="any" class="form-control"
                                            placeholder="Masukkan Koefisien" id="volume" name="volume" required>
                                    </div>
                                </div>
                                <div class="col-md-2">Harga<span style="color:red">*</span></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="number" step="any" class="form-control"
                                            placeholder="Masukkan Harga" id="harga" name="harga"
                                            oninput="$('.txt_harga').html(addCommas(this.value));" required>
                                        Rp. <span class="help-text txt_harga">0</span>
                                    </div>
                                </div>
                                <div class="col-md-2">PPN</div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="number" step="any" class="form-control"
                                            placeholder="Masukkan PPN" id="ppn" name="ppn" value="0">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-success"><i class="icon-check"></i>
                                        Simpan</button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="$('.modal').modal('hide')"><i class="icon-cancel-circle2"></i>
                                        Batal</button>
                                </div>
                        </form>
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

        function closeTabs() {
            window.close();
        }

        // START SCRIPT TABEL 
        $(document).ready(function() {
            $('.select22').select2();
            $('.select2onmodal').select2({
                dropdownParent: $('#modalAddKomponen')
            });
            var table = $('.datatable-basic-komponen').DataTable({
                "ordering": false,
                "paginate": false,
                "autoWidth": true,
                "columnDefs": [],
                "order": false,
            });
        });
        // END SCRIPT TABEL 


        function update_detail_komponen(token, url, modal) {
            $(modal).modal("show");
            $(modal + "Label").html("Ubah Data");
            $(modal + "Isi").html(loading);
            var act = url;
            $.post(
                act, {
                    _token: token,
                },
                function(data) {
                    $(modal + "Isi").html(data);
                }
            );
        }
    </script>
@endpush
