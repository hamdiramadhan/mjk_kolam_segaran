@extends('layouts.app')

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pengajuan Pergeseran</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-comment-check"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $nama_header }}</li>
                </ol>
            </nav>
        </div>
        {{-- @if ($count_pengajuan == 0) --}}
        <div class="ms-auto">
            <a href="{{ route('pengajuan.create') }}" type="button" class="btn btn-primary px-5"><i
                    class="bx bx-plus mr-1"></i>Tambah</a>
        </div>
        {{-- @endif --}}
    </div>

    <!--end breadcrumb-->
    @if (session()->has('status'))
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><i class='bx bxs-check-circle'></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Berhasil</h6>
                    <div class="text-white">
                        <p>{{ session()->get('status') }}
                            {{ session()->forget('status') }}</p>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('statusT'))
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Gagal</h6>
                    <div class="text-white">
                        <p>{{ session()->get('statusT') }}
                            {{ session()->forget('statusT') }}</p>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card radius-10 w-100">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">{{ $nama_header }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Data</th>
                            <th>Tanggal Surat</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th width="15%">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=0; @endphp
                        @foreach ($pengajuan as $p)
                            @php $no++; @endphp
                            <tr>
                                <td>{{ $no }}</td>
                                <td>
                                    <b>SKPD</b> : {{ $p->unit_id }} {{ @$p->skpd->unit_name }}
                                    <br>
                                    <b>Jabatan TTD</b> : {{ $p->skpd->jabatan }}
                                    <br>
                                    <b>NIP TTD</b> : {{ $p->skpd->nip }}
                                    <br>
                                    <b>Dibuat Pada</b> : {{ $p->created_at }}
                                </td>
                                <td>{{ $p->tanggal_surat }}</td>
                                <td>
                                    <b>Nomor Surat</b> : {{ $p->nomor_surat }}
                                    <br>
                                    <b>Lampiran</b> : {{ $p->lampiran }}
                                    <br>
                                    <b>Usulan</b> : {{ $p->usulan->usulan }}
                                    <br>
                                    <b>Alasan</b> : <ul>
                                        @foreach ($pengajuan_alasan->where('pengajuan_id', $p->id) as $r)
                                            <li>{{ $r->alasan }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $p->stat->color_div }} text-white shadow-sm w-100">{{ $p->stat->nama }}</span>
                                </td>
                                <td>

                                    <form><a href="{{ route('pengajuan.detail', encrypt($p->id)) }}" type="button"
                                            style="width:100%" class="btn btn-info px-5"><i
                                                class="bx bx-detail mr-1"></i>Detail</a></form>
                                    @if (Auth::user()->role_id != 2 || Auth::user()->role_id != 7)
                                        @if ($p->status != 0)
                                            <form><button type="button" onclick="$('#modal_verif').modal('show')"
                                                    style="width:100%;color:white" class="btn bg-gradient-deepblue px-5"><i
                                                        class="bx bx-check-circle mr-1"></i>Verif</button>
                                            </form>
                                        @endif
                                    @endif
                                    @if ($p->status == 0)
                                        <form><a href="{{ route('pengajuan.edit', encrypt($p->id)) }}" type="button"
                                                style="width:100%" class="btn btn-success px-5"><i
                                                    class="bx bx-pencil mr-1"></i>Edit</a></form>

                                        <form method="POST" onsubmit="return confirm('Anda yakin menghapus data ini ??')"
                                            action="{{ route('pengajuan.destroy', encrypt($p->id)) }}">
                                            @csrf

                                            <button type="submit" style="width:100%" class="btn btn-danger px-5"><i
                                                    class="bx bx-trash mr-1"></i>Hapus</button>
                                        </form>
                                        <form method="POST" onsubmit="return confirm('Anda yakin mengirim data ini ??')"
                                            action="{{ route('pengajuan.send', encrypt($p->id)) }}">
                                            @csrf

                                            <button type="submit" style="width:100%" class="btn btn-primary px-5"><i
                                                    class="bx bx-send mr-1"></i>Kirim</button>
                                        </form>
                                    @endif


                                    <form target="_blank" action="{{ route('pengajuan.print', encrypt($p->id)) }}"
                                        method="POST">
                                        @csrf
                                        <button href="{{ route('jenis_usulan.edit', encrypt($p->id)) }}" type="submit"
                                            style="width:100%" class="btn btn-warning px-5"><i
                                                class="bx bx-printer mr-1"></i>Cetak</button>
                                    </form>

                                    <div id="modal_verif" class="modal fade" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel" aria-hidden="true" width="100%">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-gradient-deepblue">
                                                    <h6 class="modal-title" id="ModalBiruSmLabel" style="color:white">
                                                        Verifikasi Pergeseran
                                                    </h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form class="row g-3" method="POST"
                                                        action="{{ route('pengajuan.verif', encrypt($p->id)) }}">
                                                        @csrf
                                                        <div class="col-md-12">
                                                            <label for="status_id" class="form-label">Status</label>
                                                            <select name="status_id" class="form-control" id="status_id">
                                                                @foreach ($status as $s)
                                                                    <option value="{{ $s->kode }}">
                                                                        {{ $s->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label for="Keterangan" class="form-label">Keterangan</label>
                                                            <textarea class="form-control" name="keterangan_status" id="keterangan_status"></textarea>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="d-md-flex d-grid align-items-center gap-3">

                                                                <button type="submit"
                                                                    class="btn btn-primary px-4">Simpan</button>
                                                                <button type="button" onclick="$('.modal').modal('hide')"
                                                                    class="btn btn-danger px-4">Batal</button>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var loading = `<div class="loadinghamdi hamdistyle-2"><div class="loadinghamdi-wheel"></div></div>`;
    </script>
@endpush
<!--app JS-->
</body>

</html>
