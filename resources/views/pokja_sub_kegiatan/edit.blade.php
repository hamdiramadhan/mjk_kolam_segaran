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
                <h4 class="card-title">Data {{ $nama_header }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" class="form-horizontal" action="{{ route('simpan_ubah_sub_kegiatan', $sub_keg->id) }}">
                    @csrf
                    <div class=" row mb-4">
                        <label for="name" class="col-md-3 form-label">Kegiatan</label>
                        <div class="col-md-9">
                            <select required class="form-control select22" name="master_kegiatan_id" id="master_kegiatan_id">
                                @foreach ($kegiatan as $r)
                                    @if ($r->id == $sub_keg->master_kegiatan_id)
                                        <option value="{{ $r->id }}" selected>{{ $r->kode_kegiatan }} -
                                            {{ $r->nama_kegiatan }}</option>
                                    @else
                                        <option value="{{ $r->id }}">{{ $r->kode_kegiatan }} -
                                            {{ $r->nama_kegiatan }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Kode Sub Kegiatan</label>
                        <div class="col-md-9">

                            <input type="text" placeholder="Kode Sub Kegiatan" value="{{ $sub_keg->kode_sub_kegiatan }}"
                                class="form-control" name="kode_sub_kegiatan" id="kode_sub_kegiatan">

                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Nama Sub Kegiatan</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="Nama Kepala" value="{{ $sub_keg->nama_sub_kegiatan }}"
                                class="form-control" name="nama_sub_kegiatan" id="nama_sub_kegiatan">
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Kinerja</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="Kinerja" class="form-control" name="kinerja"
                                value="{{ $sub_keg->kinerja }}" id="kinerja">

                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Indikator</label>
                        <div class="col-md-9">
                            <input type="text" value="{{ $sub_keg->indikator }}" placeholder="Kepala Pangkat"
                                class="form-control" name="indikator" id="indikator">
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Satuan</label>
                        <div class="col-md-9">
                            <select required class="form-control select22" name="satuan" id="satuan">
                                @foreach ($satuan as $d)
                                    <option {{ $sub_keg->satuan == $d->satuan ? 'selected' : '' }} value="{{ $d->satuan }}">
                                        {{ $d->satuan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div> 

                    <div class="mb-0 mt-4 row justify-content-end">
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('sub_kegiatan') }}"><button type="button"
                                    class="btn btn-danger">Cancel</button></a>
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
