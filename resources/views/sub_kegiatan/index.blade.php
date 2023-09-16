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
                <a href="{{ route('create_sub_kegiatan') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
                <button type="button" class="btn btn-sm btn-warning modal-effect" onclick="$('#modal_import_data_prog_keg_sub').modal('show')">
                    <i class="fa fa-upload"></i> Import Data Program - Kegiatan - Sub Kegiatan
                </button>
            @endif
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $nama_header }} {{ @Auth::user()->skpd->unit_name ?? 'Data Global' }} Tahun
                        {{ Auth::user()->tahun }}</h3>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="datatable-progja" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 1%;">No</th>
                                    <th>Sub Kegiatan</th>
                                    <th>Satuan</th>
                                    <th>Tahun</th>
                                    <th style="width: 1%;">Act</th> 
                                </tr>
                            </thead>
                            <tbody id="data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="modal_import_data_prog_keg_sub" tabindex="-1" role="dialog"
        aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">IMPORT Data Program-Kegiatan-Sub Kegiatan Tahun <b>{{ Auth::user()->tahun ?? date('Y') }} {{ @Auth::user()->skpd->unit_name ?? 'Data Global' }} </b>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        IMPORT Data Program-Kegiatan-Sub Kegiatan Tahun <b><span class="txt_tahun_asb">{{ Auth::user()->tahun ?? date('Y') }}</span></b>.
                        <br>Format yang dapat diupload adalah sesuai dengan <b>contoh Format</b>.
                    <ol>
                        <li>
                            Format 1 <a target="_blank" href="{{ asset('format_upload_program_kegiatan.xlsx') }}">Klik
                                disini untuk contoh Format 1 </a>
                        </li>
                        <li>
                            Format 2 <a target="_blank" href="{{ asset('format_upload_program_kegiatan_2.xlsx') }}">Klik
                                disini untuk contoh Format 2 </a>
                        </li>
                        @if(@Auth::user()->skpd->id ?? 0 == 0)
                        <li>
                            Format 3 <a target="_blank" href="{{ asset('format_upload_program_kegiatan_3.xlsx') }}">Klik
                                disini untuk contoh Format 3 </a> khusus untuk upload ALL SKPD
                        </li>
                        @endif
                    </ol>
                    </p>
                    <br><br>
                    <form target="_blank" enctype="multipart/form-data" class="form-horizontal" method="POST"
                        action="{{ route('sub_kegiatan.import') }}">
                        @csrf
                        <div class=" row mb-4">
                            <label class="col-md-3 form-label">Format</label>
                            <div class="col-md-9">
                                <select class="form-control" name="format">
                                    <option value="1">Format 1</option>
                                    <option value="2">Format 2</option>
                                    @if(@Auth::user()->skpd->id ?? 0 == 0)
                                    <option value="3">Format 3</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class=" row mb-4">
                            <label class="col-md-3 form-label">File Excel</label>
                            <div class="col-md-9">
                                <input type="file" class="form-control" name="file_upload_excel" required=""
                                    accept=".xls,.xlsx">
                            </div>
                        </div>
                        <div class=" row mb-4">
                            <label class="col-md-3 form-label">Konsep Simpan</label>
                            <div class="col-md-9">
                                <select class="form-control" name="konsep">
                                    <option value="1">Menambah Data, tanpa menghapus data <span
                                            class="txt_tahun_asb"></span> yang sudah ada</option>
                                    <option value="2">Hapus data <span class="txt_tahun_asb">{{ Auth::user()->tahun ?? date('Y') }} {{ @Auth::user()->skpd->unit_name ?? 'Data Global' }}</span>, lalu simpan
                                        dari
                                        hasil import</option>
                                </select>
                            </div>
                        </div>
                        <div class=" row mb-4">
                            <label class="col-md-3 form-label">Jenis Upload</label>
                            <div class="col-md-9">
                                <select class="form-control" name="jenis_upload">
                                    <option value="1">Langsung Simpan</option>
                                    <option value="2">Lihat Hasil Pembacaan sistem Tanpa Simpan Dahulu</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-0 mt-4 row justify-content-end">
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-primary">Upload</button>
                                <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush
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
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#datatable-progja').DataTable({
                autoWidth: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                language: {
                    "infoFiltered": " ",
                    "processing": "SEDANG MEMUAT DATA ..."
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('sub_kegiatan.ajax') }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                type: "POST",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'data',
                        name: 'data'
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
                    },
                ],
            });
        });
    </script>
@endpush
