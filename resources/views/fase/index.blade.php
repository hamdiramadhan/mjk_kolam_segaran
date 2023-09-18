@extends('layouts.app')
@include('layouts.function')
@section('content')
    <!--breadcrumb-->
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

        <div class="ms-auto">
            @if (Auth::user()->role_id == 1)
                <a href="{{ route('fase.create') }}" class="btn waves-effect btn-primary btn-md">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            @endif
        </div>
    </div>
    <!--end breadcrumb-->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body"> 
                    <hr>
                    <input type="hidden" name="list_id" id="list_id">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered key-buttons border-bottom datatable-basic">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Kode</th> 
                                    <th>Nama</th>
                                    <th>Tahun</th> 
                                    <th>Waktu Perubahan</th>
                                    <th style="width: 5%">Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=0; @endphp
                                @foreach ($opds as $r)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><b>{{ @$r->kode }}</b></td>
                                        <td>{{ @$r->nama }}</td> 
                                        <td>{{ @$r->tahun }}</td> 
                                        <td>{{ @$r->mulai }} s/d {{ @$r->selesai }}</td>  
                                        <td>
                                            <div class="d-flex p-2 txt-bold">
                                                <?php
                                                $key = encrypt($r->id);
                                                ?>
                                                <a href="{{ route('fase.edit', $key) }}" class="btn btn-outline-primary"><i class='bx bx-edit me-0'></i>
                                                </a>
                                                @if (Auth::user()->role_id == 1)
                                                <button type="button" class="btn btn-outline-danger" onclick="delete_opd('{{ csrf_token() }}','{{ $r->id }}')"><i class='bx bx-trash me-0'></i>
                                                </button>
                                                @endif  
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection 