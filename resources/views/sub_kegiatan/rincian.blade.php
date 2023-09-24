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
            @if (Auth::user()->role_id == 1)
                <button type="button" id="pindahopd" onClick="GetId(this.id)"
                    class="btn btn-sm text-light waves-effect btn-info btn-md">
                    <i class=" fas fa-paper-plane"></i> Pindah Sub Kegiatan
                </button>
            @endif
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body overflow-hidden p-relative z-index-1" style="text-align: center; font-weight: bold">
            SUB KEGIATAN {{ @Auth::user()->skpd->unit_name }}
            <br>
            TAHUN {{ Auth::user()->tahun ?? '' }} 
        </div>
        <div class="card-body overflow-hidden p-relative z-index-1">
            <style type="text/css">
                .table tbody tr td {
                    word-break: break-word !important;
                    vertical-align: top;
                }

                table tbody tr td {
                    word-break: break-word !important;
                    vertical-align: top;
                }
            </style>
            <div class="showOpd" style="display:none">
                <button type="button" id="simpanopd" class="btn waves-effect btn-success btn-md"
                    onclick="$('.modalAddSubKegiatan').modal('show')">
                    <i class=" fas fa-plus"></i> SKPD Sub Kegiatan
                </button>
                <button type="button" id="batalpindah" onClick="GetId(this.id)" class="btn waves-effect btn-danger btn-md">
                    <i class=" fas fa-times"></i> Batal
                </button><br><br>
                <div class="col-lg-12">
                    <div class="alert alert-warning">
                        <ol>
                            <li>
                                Centang <input class="form-check-inputs" checked type="checkbox"> (Checkbox) untuk memilih
                                <b>Sub Kegiatan</b> yang ingin di pindah pada daftar Kegiatan SKPD Di bawah ini.
                            </li>
                            <li>
                                Jika sudah pilih Tombol <b>+ SKPD SUB KEGIATAN</b>.
                            </li>
                            <li>
                                Pilih SKPD terlebih dahulu, lalu Simpan <b>Sub Kegiatan</b> yang sudah dicentang tadi.
                            </li>
                            <li>
                                Data <b>Sub Kegiatan</b> akan berpindah ke SKPD yang sudah dipilih.
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="scrollable">
                <table class="table text-md-nowrap datatable-basic-subkegiatan ">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="background-color: #ccf6c8">Program</th>
                            <th style="background-color: #ccf6c8">Kegiatan</th>
                            <th style="width: 180px">Kode</th>
                            <th>Nama</th>
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
                        @foreach ($data_sub_kegiatan as $dk)
                            <?php $n++;
                            $pagu = $dk->get_total_komponen($dk->id);
                            $total_pagu += $pagu; ?>
                            <tr>
                                <td>{{ $n }}</td>
                                <td style="background-color: #ccf6c8 !important">
                                    Prog : {{ $dk->kegiatan->program->kode_program }}
                                    {{ $dk->kegiatan->program->nama_program }}
                                </td>
                                <td style="background-color: #ccf6c8 !important">
                                    &nbsp;&nbsp;&nbsp;&nbsp;Keg : {{ $dk->kegiatan->kode_kegiatan }}
                                    {{ $dk->kegiatan->nama_kegiatan }}
                                </td>
                                <td style="word-break: break-word !important;"><input class="form-check-input" type="checkbox"
                                        value="{{ $dk->id }}" name="sub_kegiatan[]" id="checks" onclick="Checkeds()"
                                        style="display:none"> {{ $dk->kode_sub_kegiatan }}</td>
                                <td> {{ $dk->nama_sub_kegiatan }}</td>
                                <td style="min-width: 150px !important;" align="right">
                                    <span class="badge badge-warning">
                                        {{ number_format($pagu, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td> 
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-popup="tooltip" title="Komponen"
                                        onclick=" sub_kegiatan_rincian_detail('{{ csrf_token() }}','{{ $dk->id }}')">
                                        <i class="fa fa-list me-0"></i> 
                                    </button> 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="" class="modal fade modalAddSubKegiatan" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true" width="100%">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title" id="Label" style="color:white">
                        Judul
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('pindah_sub_kegiatan') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id_sub_kegiatan" name="id_sub_kegiatan">
                        <label id="alert" style="font-weight:bold">Pastikan Anda Sudah Mencentang Data Sub Kegiatan
                            Sebelum Menyimpan Data !!</label>
                        <div class="form-group">
                            <select class="select22" id="unit_id" name="unit_id" required style="width:100%">
                                <option value="" selected disabled>-- Pilih SKPD --</option>
                                @foreach ($data_opd as $opd)
                                    <option value="{{ $opd->id_sipd }}">{{ $opd->tahun }} - {{ $opd->unit_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="icon-check"></i> Simpan</button>
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
