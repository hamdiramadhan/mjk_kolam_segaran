@extends('layouts.app')

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pengajuan</div>
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
        <div class="card-body p-4">
            <h5 class="mb-4">Ubah Pengajuan</h5>
            <form class="row g-3" method="POST" action="{{ route('pengajuan.update', encrypt($pengajuan->id)) }}">
                @csrf
                <div class="col-md-12">
                    <label for="nomor_surat" class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" value="{{ $pengajuan->nomor_surat }}" name="nomor_surat"
                        id="nomor_surat" placeholder="Masukkan Nomor Surat">
                </div>

                <div class="col-md-12">
                    <label for="Nama" class="form-label">Tanggal Surat</label>
                    <input type="date" class="form-control" value="{{ $pengajuan->tanggal_surat }}" name="tanggal_surat"
                        id="tanggal_surat" value="<?= date('Y-m-d') ?>">
                </div>

                <div class="col-md-12">
                    <label for="sifat_surat" class="form-label">Sifat Surat</label>
                    <input type="text" class="form-control" value="{{ $pengajuan->sifat_surat }}" name="sifat_surat"
                        id="sifat_surat" placeholder="Masukkan Sifat Surat">
                </div>

                <div class="col-md-12">
                    <label for="lampiran" class="form-label">Lampiran</label>
                    <input type="text" class="form-control" value="{{ $pengajuan->lampiran }}" name="lampiran"
                        id="lampiran" placeholder="Masukkan Lampiran">
                </div>

                <div class="col-md-12">
                    <label for="lampiran" class="form-label">Usulan</label>
                    <select name="usulan_id" id="usulan_id" style="width:100%" class="select22">
                        @foreach ($usulan as $r)
                            @php $selected = ''; @endphp
                            @if ($r->id == $pengajuan->usulan_id)
                                @php $selected = 'selected'; @endphp
                            @endif
                            <option {{ $selected }} value="{{ $r->id }}">{{ $r->usulan }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-12">
                    <label for="lampiran" class="form-label">Tambahkkan Alasan</label>

                    <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white " onclick="AddAlasan();"><i
                            class="bx bx-plus"></i>
                    </div>
                </div>
                <div id="AddAlasan">
                    @foreach ($pengajuan_alasan as $r)
                        <div class="col-md-12"> <label for="lampiran" class="form-label">Tambah Alasan</label>
                            <textarea name="alasan[]" class="form-control" id="alasan' +
                        noUrut + '"
                                placeholder="Masukkan Alasan disini">{{ $r->alasan }}</textarea>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-2">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <a href="{{ route('pengajuan.index') }}" type="button" class="btn btn-danger px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                    </div>
                </div>

            </form>
        </div>
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