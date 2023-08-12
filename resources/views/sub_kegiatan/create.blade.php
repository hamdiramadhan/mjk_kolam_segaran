@extends('layouts.app')
@section('content')
    <!-- PAGE-HEADER -->
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
    </div>
    <!-- PAGE-HEADER END -->

    <!-- Row -->
    <div class="card">
        <div class="col-md-12 col-xl-12">

            <div class="card-header">
                <h4 class="card-title">Tambahg Data {{ $nama_header }} {{ Auth::user()->tahun }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" class="form-horizontal" action="{{ route('simpan_tambah_sub_kegiatan') }}">
                    @csrf
                    <div class=" row mb-4">
                        <label for="name" class="col-md-3 form-label">Kegiatan</label>
                        <div class="col-md-9">
                            <select required class="form-control select22" name="master_kegiatan_id" id="master_kegiatan_id" onchange="$('#kode_sub_kegiatan').val($(this).find(':selected').attr('data-kode'));">
                                <option value="">-- Pilih --</option>
                                @foreach ($kegiatan as $r)
                                    <option value="{{ $r->id }}" data-kode="{{ $r->kode_kegiatan }}">{{ $r->kode_kegiatan }} - {{ $r->nama_kegiatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Kode Sub Kegiatan</label>
                        <div class="col-md-9">

                            <input type="text" class="form-control"
                                name="kode_sub_kegiatan" id="kode_sub_kegiatan">

                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Nama Sub Kegiatan</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="nama_sub_kegiatan"
                                id="nama_sub_kegiatan">
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Kinerja</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="kinerja" id="kinerja">

                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Indikator</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="indikator"
                                id="indikator">
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Satuan</label>
                        <div class="col-md-9">
                            <select required class="form-control select22" name="satuan" id="satuan">
                                <option value="">-- Pilih --</option>
                                @foreach ($satuan as $d)
                                    <option value="{{ $d->satuan }}">
                                        {{ $d->satuan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class=" row mb-4 d-none">
                        <label for="nama" class="col-md-3 form-label">Tahun</label>
                        <div class="col-md-9">
                            <select class="form-control" name="tahun" id="tahun">
                                <option value="{{ Auth::user()->tahun ?? date('Y') }}">{{ Auth::user()->tahun ?? date('Y') }}</option> 
                            </select>
                        </div>
                    </div>

                    <div class="mb-0 mt-4 row justify-content-end">
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('sub_kegiatan') }}"><button type="button"
                                    class="btn btn-danger">Batal</button></a>
                        </div>
                    </div>
                </form>
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
    </script>
@endpush
