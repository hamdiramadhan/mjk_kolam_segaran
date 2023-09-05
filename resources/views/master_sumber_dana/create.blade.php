@extends('layouts.app')

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-cube"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $nama_header }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body p-4">
            <h5 class="mb-4">Tambah {{ $nama_header }}</h5>
            <form class="row g-3" method="POST" action="{{ route('sumber_dana.store') }}">
                @csrf
                <div class="col-md-12">
                    <label for="Nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama">
                </div>

                <div class="col-md-12">
                    <label for="Keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" id="keterangan" name="keterangan"></textarea>
                </div>
                <div class="col-md-2">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <a href="{{ route('sumber_dana.index') }}" type="button" class="btn btn-danger px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
