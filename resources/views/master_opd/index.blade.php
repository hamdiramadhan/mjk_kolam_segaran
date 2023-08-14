@extends('layouts.app')
@include('layouts.function')
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
                <a href="{{ route('create_master_opd') }}" class="btn btn-sm waves-effect btn-primary btn-md">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            @endif
        </div>
    </div>
    <!--end breadcrumb-->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">

                        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 6)
                            <button type="button" class="btn btn-sm btn-primary btn-md btn_setting_template"
                                onclick="
                                    var list_id = $('#list_id').val();
                                    if(list_id == '' || list_id == null){
                                    alertKu('warning', 'Tidak ada data tercentang');
                                    } else {  
                                    aktif_usulan('{{ csrf_token() }}', list_id, 1, 'semua');
                                    }
                                    ">
                                Buka Usulan Semua SKPD Tercentang
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-md btn_setting_template"
                                onclick="
                                    var list_id = $('#list_id').val();
                                    if(list_id == '' || list_id == null){
                                    alertKu('warning', 'Tidak ada data tercentang');
                                    } else {  
                                    aktif_usulan('{{ csrf_token() }}', list_id, 0, 'semua');
                                    }
                                    ">
                                Tutup Usulan Semua SKPD Tercentang
                            </button>
                        @endif
                        <hr>
                        <input type="hidden" name="list_id" id="list_id">
                        <table class="table table-sm table-bordered key-buttons border-bottom datatable-not-paginate">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>
                                        <input type="checkbox" name="" style="transform: scale(1.5)"
                                            onchange="
                                      chk_all(this.checked);
                                      chg_chk_data();">
                                    </th>
                                    <th>Unit ID</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Buka Usulan</th>
                                    <th style="width: 5%">Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=0; @endphp
                                @foreach ($opds as $r)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <input name="chk_data" type="checkbox" value="{{ $r->id }}"
                                                style="transform: scale(1.5)  !important" onchange="chg_chk_data()">
                                        </td>
                                        <td>{{ $r->unit_id }}</td>
                                        <td> {{ $r->unit_name }}</td>
                                        <td> {{ @$r->jenis_instansi->nama }}</td>
                                        <td style="text-align: center">
                                            <span style="color: white; font-size: 1pt">{{ $r->aktif_usul }}</span>
                                            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 6)
                                                <input type="checkbox" style="transform: scale(1.5)"
                                                    {{ $r->aktif_usul == 1 ? 'checked' : '' }}
                                                    id="chk_aktif_usul_{{ $r->id }}" value="{{ $r->id }}"
                                                    onchange="opd_aktif_usul('{{ $r->id }}');">
                                                <div class="txt_pesan_{{ $r->id }}"></div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex p-2 txt-bold">
                                                <?php
                                                $key = hamdi_encrypt($r->id . $r->created_at . '##' . $r->id . '##' . $r->id . $r->created_at, 'progstylysbyhamdi');
                                                ?>
                                                <a href="{{ route('edit_master_opd', $key) }}" class="btn btn-sm btn-outline-primary"><i class='bx bx-edit me-0'></i>
                                                </a>
                                                @if (Auth::user()->role_id == 1)
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="delete_opd('{{ csrf_token() }}','{{ $r->id }}')"><i class='bx bx-trash me-0'></i>
                                                </button>
                                                @endif 
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection
@push('scripts')
    <script>
        var table = $('#file-datatable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                scrollX: "100%",
                sSearch: '',
            }
        });
        table.buttons().container()
            .appendTo('#file-datatable_wrapper .col-md-6:eq(0)');

        function chk_all(isChecked) {
            if (isChecked) {
                $('input[name="chk_data"]').each(function() {
                    this.checked = true;
                });
            } else {
                $('input[name="chk_data"]').each(function() {
                    this.checked = false;
                });
            }
        }

        function chg_chk_data() {
            var favorite = [];
            $.each($("input[name='chk_data']:checked"), function() {
                favorite.push($(this).val());
            });
            $('#list_id').val(favorite.join(","));
        }

        function opd_aktif_usul(id) {
            // alert(id);
            $('#chk_aktif_usul_' + id).attr('disabled', true);
            $('.txt_pesan_' + id).html('Loading...');
            var value = $('#chk_aktif_usul_' + id).is(":checked");
            var val = 0;
            if (value == true) {
                val = 1;
            }
            $.post('{{ route('opd_aktif_usul') }}', {
                    _token: "<?php echo csrf_token(); ?>",
                    id,
                    val
                },
                function(data) {
                    $('.txt_pesan_' + id).html('');
                    $('#chk_aktif_usul_' + id).attr('disabled', false);
                    alertKu(data.status, data.msg);
                    // location.reload();
                });
        }

        function aktif_usulan(token, id, val, tipe) {
            var public_path = $('#public_path').val(); /* di layouts */
            var pesan = "membuka";
            if (val == 0) {
                pesan = "menutup";
            }
            swal({
                    title: "Anda yakin " + pesan + " usulan untuk OPD ini ?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#FF5722",
                    confirmButtonText: "Ya, Yakin!",
                    cancelButtonText: "Tidak!",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.post(public_path + '/aktif_usulan', {
                                _token: token,
                                id: id,
                                tipe,
                                val
                            },
                            function(data) {
                                if (data == 'success') {
                                    swal({
                                            title: "Usulan berhasil ditutup untuk OPD terpilih",
                                            text: "",
                                            confirmButtonColor: "#4CAF50",
                                            type: "success"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                location.reload();
                                            }
                                        });
                                } else {
                                    alertKu(data);
                                }
                            });
                    }
                });
        }
    </script>
@endpush
