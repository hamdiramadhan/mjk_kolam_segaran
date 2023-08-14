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

            <a href="{{ route('users.create') }}" type="button" class="btn btn-sm btn-primary px-5"><i
                    class="bx bx-plus mr-1"></i>Tambah</a>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive"> 
                <table class="table table-sm table-bordered key-buttons border-bottom datatable-basic">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th width="1%">Act</th>
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
                                <td>{{ $r->role->name ?? $r->role_id }}</td>
                                <td>
                                    <div class="d-flex p-2 txt-bold">
                                        <a href="{{ route('users.edit', encrypt($r->id)) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class='bx bx-edit me-0'></i>
                                        </a>

                                        <form method="POST" onsubmit="return confirm('Anda yakin menghapus data ini ??')"
                                            action="{{ route('users.destroy', encrypt($r->id)) }}">
                                            @csrf 
                                            <button type="submit" onclick="hapus_data('{{ $r->id }}')" class="btn btn-sm btn-outline-danger">
                                                <i class="bx bx-trash me-0"></i>
                                            </button>
                                        </form>
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

        function hapus_data(id) {
            if (confirm('Apakah anda yakin menghapus data ini ? ')) {
                if (confirm('Apakah anda benar-benar yakin menghapus ini ? ')) {
                    $('#form-delete-' + id).submit();
                }
            }
        }
    </script>
@endpush 