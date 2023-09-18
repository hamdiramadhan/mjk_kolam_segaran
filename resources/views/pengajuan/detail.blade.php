@extends('layouts.app')
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
            @if ($pengajuan->status == 0)
                <form id="frm_kirim" method="POST" onsubmit="return confirm('Anda yakin mengirim data ini ??')"
                    action="{{ route('pengajuan.send', encrypt($pengajuan->id)) }}">
                    @csrf
                </form>
                <form id="frm_cetak" target="_blank" action="{{ route('pengajuan.print', encrypt($pengajuan->id)) }}" method="POST">
                    @csrf
                </form>
                <form id="frm_pengajuan" target="_blank" action="{{ route('pengajuan.print_detail', encrypt($pengajuan->id)) }}"
                    method="POST">
                    @csrf
                </form>

                <button type="button" class="btn btn-primary px-5" onclick="$('#frm_kirim').submit();">
                    <i class="bx bx-send mr-1"></i> Kirim
                </button>
                <button type="button" class="btn btn-warning px-5" onclick="$('#frm_cetak').submit();">
                    <i class="bx bx-printer mr-1"></i> Cetak
                </button>
                <button type="button" class="btn btn-info px-5" onclick="$('#frm_pengajuan').submit();">
                    <i class="bx bx-printer mr-1"></i> Pengajuan 
                </button> 
            @endif
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <b>Status RKBMD</b> : <span class="badge badge-{{ $pengajuan->stat->color_div }}">
                        <b>{{ @$pengajuan->stat->nama }}</b>
                    </span>
                    <br>
                    <b>Pengusul</b> : {{ @$pengajuan->skpd->unit_name }}
                    <br>
                    <b>SKPD</b> : {{ $pengajuan->unit_id }}
                    <br>
                    <b>Tanggal Surat</b> : {{ $pengajuan->tanggal_surat }}
                    <br>
                    <b>Nomor Surat</b> : {{ $pengajuan->nomor_surat }}
                    <br>
                    <b>Usulan</b> : {{ @$pengajuan->usulan->usulan }}
                    <br>
                    <b>Tahun RKBMD</b> : <b style="color: red">{{ @$pengajuan->tahun }}</b>
                    <br>

                    {{ $pengajuan->keterangan }}
                </div>
            </div>

            <hr style="background-color: blue">
        </div>
        @if ($pengajuan->stat->kode == 0)
            <div class="card-body overflow-hidden p-relative z-index-1">
                <a href="#"
                    onclick="pengajuan_detail_create('{{ csrf_token() }}', '#ModalFull','{{ encrypt($id) }}')"
                    type="button" class="btn btn-primary px-5"><i class="bx bx-plus mr-1"></i>Tambah Sub
                    Kegiatan</a>
            </div>
        @endif


        <div class="scrollable">
            <table class="table text-md-nowrap datatable-basic-subkegiatan ">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="background-color: #ccf6c8">Program</th>
                        <th style="background-color: #ccf6c8">Kegiatan</th>
                        <th style="width: 180px">Kode</th>
                        <th>Nama</th>
                        <th>Sumber Dana</th>
                        <th scope='col'>Nilai
                            <br>
                            <span class="badge badge-primary txt_total_pagu">0</span>
                        </th>
                        <th scope='col' style="width: 1%">Act</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $n = 0;
                    $total_pagu = 0;
                    ?>
                    @foreach ($pengajuan_detail as $dk)
                        <?php $n++;
                        $pagu = $dk->sub_kegiatan->get_total_komponen($dk->master_sub_kegiatan_id);
                        $total_pagu += $pagu; ?>
                        <tr>
                            <td>{{ $n }}</td>
                            <td style="background-color: #ccf6c8 !important">
                                Prog : {{ $dk->sub_kegiatan->kegiatan->program->kode_program }}
                                {{ $dk->sub_kegiatan->kegiatan->program->nama_program }}
                            </td>
                            <td style="background-color: #ccf6c8 !important">
                                &nbsp;&nbsp;&nbsp;&nbsp;Keg : {{ $dk->sub_kegiatan->kegiatan->kode_kegiatan }}
                                {{ $dk->sub_kegiatan->kegiatan->nama_kegiatan }}
                            </td>
                            <td style="word-break: break-word !important;"><input class="form-check-input" type="checkbox"
                                    value="{{ $dk->sub_kegiatan->id }}" name="sub_kegiatan[]" id="checks"
                                    onclick="Checkeds()" style="display:none"> {{ $dk->sub_kegiatan->kode_sub_kegiatan }}
                            </td>
                            <td> {{ $dk->sub_kegiatan->nama_sub_kegiatan }}</td>
                            <td>
                                @foreach ($detail_sumberdana->where('pengajuan_detail_id', $dk->id) as $r)
                                    <li>{{ $r->sumber_dana->nama }}</li>
                                @endforeach
                            </td>
                            <td style="min-width: 150px !important;" align="right">
                                <span class="badge badge-warning">
                                    {{ number_format($pagu, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('pengajuan_detail.komponen', encrypt($dk->id)) }}" type="button"
                                    class="btn btn-sm btn-outline-primary" data-popup="tooltip" title="Komponen">
                                    <i class="fa fa-list me-0"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <div id="ModalBiruSm" class="modal fade modalAddSubKegiatan" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true" width="100%">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title" id="ModalBiruSmLabel" style="color:white">
                        Judul
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('pindah_sub_kegiatan') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id_sub_kegiatan" name="id_sub_kegiatan">
                        <label id="alert" style="font-weight:bold">Pastikan Anda Sudah Mencentang Data Sub
                            Kegiatan
                            Sebelum Menyimpan Data !!</label>
                        <div class="form-group">
                            <select class="select22" id="unit_id" name="unit_id" required style="width:100%">
                                <option value="" selected disabled>-- Pilih SKPD --</option>
                                @foreach ($data_opd as $opd)
                                    <option value="{{ $opd->id_sipd }}">{{ $opd->tahun }} -
                                        {{ $opd->unit_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="icon-check"></i>
                            Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="icon-cancel-circle2"></i> Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        // START SCRIPT TABEL 
        $(document).ready(function() {
            var table = $('.datatable-basic-subkegiatan').DataTable({
                "ordering": false,
                "paginate": false,
                "autoWidth": true,
                "columnDefs": [{
                    "visible": false,
                    "targets": [1, 2]
                }],
                rowGroup: {
                    dataSrc: [1, 2],
                    className: 'table-group'
                }
            });
        });
        // END SCRIPT TABEL   
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        $('.txt_total_pagu').html(numberWithCommas('{{ $total_pagu }}'));

        $('.select22').select2();
        //check sub kegiatan
        function Checkeds() {
            var arr = [];
            $.each($("input[name='sub_kegiatan[]']:checked"), function() {
                arr.push($(this).val());
                $('#id_sub_kegiatan').val(arr.join(", "));
                // console.log($(this).val());
            });
            if (arr.length == 0) {
                $('#id_sub_kegiatan').val("");
            }
        }
        //show hide button pindah opd
        function GetId(id) {
            if (id == 'pindahopd') {
                $('.showOpd').show(500);
                $('.form-check-input').show(500);
                $('.showOpd2').hide(500);
            } else {
                $('.showOpd2').show(500);
                $('.showOpd').hide(500);
                $('.form-check-input').hide(500);
            }
        }

        function sub_kegiatan_rincian_detail(token, id_sub_kegiatan) {
            $("#ModalFull").modal("show");
            $("#ModalFullIsi").html('loading...');
            $("#ModalFullLabel").html("Detail Komponen");

            var act = "{{ route('sub_kegiatan_rincian_detail') }}";
            $.post(
                act, {
                    _token: token,
                    id_sub_kegiatan: id_sub_kegiatan,
                },
                function(data) {
                    $("#ModalFullIsi").html(data);
                    $("#ModalFull").modal("show");
                }
            );
        }
    </script>
@endpush
