@extends('layouts.app')

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">

            <a href="{{ route('users.create') }}" type="button" class="btn btn-primary px-5"><i
                    class="bx bx-plus mr-1"></i>Tambah</a>
        </div>
    </div>

    <!--end breadcrumb-->
    <a href="{{ route('users.create') }}" type="button" class="btn btn-primary px-5"><i
            class="bx bx-plus mr-1"></i>Tambah</a>
    <br><br>
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
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th width="15%">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=0; @endphp
                        @foreach ($user as $r)
                            @php $no++; @endphp
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $r->name }}</td>
                                <td>{{ $r->username }}</td>
                                <td>{{ $r->role->name }}</td>
                                <td>
                                    <a href="{{ route('users.edit', encrypt($r->id)) }}" type="button" style="width:100%"
                                        class="btn btn-success px-5"><i class="bx bx-pencil mr-1"></i>Edit</a>

                                    <form method="POST" onsubmit="return confirm('Anda yakin menghapus data ini ??')"
                                        action="{{ route('users.destroy', encrypt($r->id)) }}">
                                        @csrf

                                        <button type="submit" onclick="hapus_data('{{ $r->id }}')"
                                            style="width:100%" class="btn btn-danger px-5"><i
                                                class="bx bx-trash mr-1"></i>Hapus</button>
                                    </form>
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

        function hapus_data(id) {
            if (confirm('Apakah anda yakin menghapus data ini ? ')) {
                if (confirm('Apakah anda benar-benar yakin menghapus ini ? ')) {
                    $('#form-delete-' + id).submit();
                }
            }
        }
    </script>
@endpush
<!--app JS-->
</body>

</html>
