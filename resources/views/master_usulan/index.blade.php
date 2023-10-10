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
                    <li class="breadcrumb-item active" aria-current="page">Jenis Usulan</li>
                </ol>
            </nav>
        </div>
        {{-- <div class="ms-auto">

            <a href="{{ route('jenis_usulan.create') }}" type="button" class="btn btn-primary px-5"><i
                    class="bx bx-plus mr-1"></i>Tambah</a>
        </div> --}}
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
                            <th>Usulan</th>
                            <th width="15%">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=0; @endphp
                        @foreach ($jenisUsulan as $r)
                            @php $no++; @endphp
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $r->usulan }}</td>
                                <td>
                                    <a href="{{ route('jenis_usulan.edit', encrypt($r->id)) }}" type="button"
                                        style="width:100%" class="btn btn-success px-5"><i
                                            class="bx bx-pencil mr-1"></i>Edit</a>

                                    {{-- <form method="POST" onsubmit="return confirm('Anda yakin menghapus data ini ??')"
                                        action="{{ route('jenis_usulan.destroy', encrypt($r->id)) }}">
                                        @csrf

                                        <button type="submit" onclick="hapus_data('{{ $r->id }}')"
                                            style="width:100%" class="btn btn-danger px-5"><i
                                                class="bx bx-trash mr-1"></i>Hapus</button>
                                    </form> --}}
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
