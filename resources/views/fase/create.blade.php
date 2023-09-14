@extends('layouts.app')

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Fase</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-comment-check"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $nama_header }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <form class="row g-3" method="POST" action="{{ route('fase.store') }}">
            <div class="card-body p-4">
                <h5 class="mb-4">Tambah Data</h5>
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">Kode Urut</label>
                        <input type="number" class="form-control" name="kode">
                        <small>* Perubahan ke 1 atau Perubahan ke 2 dan seterusnya</small>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Tahun</label>
                        <input type="number" class="form-control" name="tahun">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jadwal Mulai Input Perubahan</label>
                        <input type="datetime-local" class="form-control" name="mulai">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jadwal Selesai Input Perubahan</label>
                        <input type="datetime-local" class="form-control" name="selesai">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <a href="{{ route('fase.index') }}" type="button" class="btn btn-danger px-4">Kembali</a>
                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        var noUrut = 1;

        function AddAlasan() {
            $('#AddAlasan').append(
                '<div class="col-md-12"> <label for="lampiran" class="form-label">Tambah Alasan</label><textarea name="alasan[]" class="form-control" id="alasan' +
                noUrut + '" placeholder ="Masukkan Alasan disini"></textarea></div>');
            noUrut++;
        }
    </script>
@endsection
