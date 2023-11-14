@extends('layouts.app')
@include('layouts.function')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Filter Data</div>
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
    <!--end breadcrumb-->
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="POST" class="form-horizontal">
                        @csrf
                        <div class=" row mb-4">
                            <label for="name" class="col-md-3 form-label">Fase</label>
                            <div class="col-md-9">
                                <select required class="form-control select22" name="fase_id" id="fase_id">
                                    @foreach ($fase as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-0 mt-4 row ">
                            <div class="col-md-2">

                            </div>
                            <div class="col-md-10">
                                <button onclick="show_report('{{ csrf_token() }}','#show_report')" type="button"
                                    style="text-align: center;width:80%" class="btn btn-primary btn-block">Cari</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
    <div id="show_report">

    </div>
@endsection

@push('scripts')
    <script>
        function show_report(token, target) {
            var fase_id = $('#fase_id').val();
            var act = '/report/show';
            $(target).html(loading);
            $.post(act, {
                    _token: token,
                    fase_id: fase_id
                },
                function(data) {
                    $(target).html(data);
                });
        }
    </script>
    <script>
        $(document).ready(function() {
            var table = $('.datatable-report').DataTable({
                "ordering": false,
                "paginate": false,
                "autoWidth": true,
                "columnDefs": [{
                    "visible": false,
                    "targets": [1]
                }],
                rowGroup: {
                    dataSrc: [1],
                    className: 'table-group'
                }
            });
        });
    </script>
@endpush
