@extends('layouts.app')
@section('content')
@php 
$required = '<span style="color: red; font-weight: bold">*</span>';
@endphp 
    <div class="breadcrumb-header justify-content-between mg-lg-t-0  ">
        <div class="left-content">
            <h4 class="content-title mb-1">Ubah Data {{ @$nama_header }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Master</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ @$nama_header }}</li>
                    <li class="breadcrumb-item active" aria-current="page">Ubah {{ @$nama_header }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Row -->
    <div class="card">
        <div class="col-md-12 col-xl-12">

            <div class="card-header">
                <h4 class="card-title">Data {{ $nama_header }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" class="form-horizontal" action="{{ route('simpan_ubah_sub_opd', $opd->id) }}">
                    @csrf
                    <div class=" row mb-4">
                        <label for="name" class="col-md-3 form-label">SKPD Induk {!! $required !!}</label>
                        <div class="col-md-9">
                            <select class="select22" name="induk" style="width: 100%" required>
                                <option value="">-- Pilih --</option>
                                @foreach($opdinduks as $o)
                                <option {{ $o->id == $opd->induk ? 'selected' : '' }} value="{{ $o->id }}">{{ $o->unit_id }} {{ $o->unit_name }}</option>
                                @endforeach
                            </select> 
                        </div>
                    </div> 
                    <div class=" row mb-4">
                        <label for="name" class="col-md-3 form-label">Jenis Instansi {!! $required !!}</label>
                        <div class="col-md-9">
                            <select class="form-control" name="jenis_instansi_id" required>
                                <option value="">-- Pilih --</option>
                                @foreach($jenis_instansis as $ji)
                                <option {{ $ji->id == $opd->jenis_instansi_id ? 'selected' : '' }} value="{{ $ji->id }}">{{ $ji->nama }}</option>
                                @endforeach
                            </select> 
                        </div>
                    </div> 
                    <div class=" row mb-4">
                        <label for="name" class="col-md-3 form-label">Kode SKPD {!! $required !!}</label>
                        <div class="col-md-9">
                            <input type="text" required class="form-control" id="unit_id" name="unit_id" placeholder="Contoh : 1.01.01" autocomplete="Nama" value="{{ $opd->unit_id }}">

                        </div>
                    </div>
                    @if(env('URL_SIDIRGA', '') != '')
                    <div class=" row mb-4">
                        <label for="name" class="col-md-3 form-label">Kode SKPD SIDIRGA</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="unit_id_sidirga" name="unit_id_sidirga" placeholder="Kode SKPD di aplikasi SIDIRGA" autocomplete="Nama" value="{{ $opd->unit_id_sidirga }}">
                        </div>
                    </div> 
                    @endif 

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Nama SKPD {!! $required !!}</label>
                        <div class="col-md-9">

                            <input required type="text" placeholder="Nama SKPD" class="form-control" name="unit_name"
                                id="unit_name" value="{{ $opd->unit_name }}">

                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Nama Kepala</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="Nama Kepala" class="form-control" name="kepala_nama"
                                id="kepala_nama" value="{{ $opd->kepala_nama }}">
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Kepala NIP</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="Kepala NIP" class="form-control" name="kepala_nip"
                                id="kepala_nip" value="{{ $opd->kepala_nip }}">

                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Kepala Pangkat</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="Kepala Pangkat" class="form-control" name="kepala_pangkat"
                                id="kepala_pangkat" value="{{ $opd->kepala_pangkat }}">
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Kepala Jabatan</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="Kepala Jabatan" class="form-control" name="kepala_jabatan"
                                id="kepala_jabatan" value="{{ $opd->kepala_jabatan }}">
                        </div>
                    </div> 

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Alamat</label>
                        <div class="col-md-9">
                            <input type="text" value="{{ $opd->alamat }}" placeholder="Alamat" class="form-control"
                                name="alamat" id="alamat">
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Telp</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="Telp" class="form-control" name="telp" id="telp"
                                value="{{ $opd->telp }}">
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="nama" class="col-md-3 form-label">Fax</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="Fax" class="form-control" name="fax" id="fax"
                                value="{{ $opd->fax }}">
                        </div>
                    </div>

                    <div class="mb-0 mt-4 row justify-content-end">
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-danger" onclick="history.back()">Batal</button>
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
