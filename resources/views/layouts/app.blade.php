<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('images/logo2.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />

    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



    <!--- Internal Sweet-Alert css-->
    <link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

    <!-- RowGroup CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.dataTables.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style type="text/css">
    </style>
    @stack('css')

    <title>{!! env('APP_NAME') !!}</title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--start header wrapper-->
        <div class="header-wrapper">
            <!--start header -->
            <header>
                <div class="topbar d-flex align-items-center">
                    <nav class="navbar navbar-expand gap-3">
                        <div class="topbar-logo-header d-none d-lg-flex">
                            <div class="">
                                <img src="{{ asset('images/logo2.png') }}" class="logo-icon" alt="logo icon"
                                    style="width: 100px; margin-top:10px">
                            </div>
                            <div class="">
                                {{-- <h4 class="logo-text" style="font-size: 15px">{!! env('APP_NAME') !!}</h4> --}}
                            </div>
                        </div>

                        <div class="top-menu ms-auto">
                            &nbsp;
                            &nbsp;
                            <a href="javascript:;" onclick="$('#modal_setting_app').modal('show')">
                                <span class="badge bg-primary badge-sm text-light  me-1 mb-1 mt-1">
                                    {{ @Auth::user()->tahun }} {{ @Auth::user()->skpd->unit_name ?? 'Data Global' }}
                                </span>
                            </a>
                        </div>
                        <div class="user-box dropdown px-3">
                            <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
                                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{-- <img src="{{ asset('assets/images/avatars/avatar-2.png') }}" class="user-img"
                                    alt="user avatar"> --}}
                                <i class="bx bx-user fs-5"></i>
                                <div class="user-info">
                                    <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                                    <p class="designattion mb-0">{{ Auth::user()->role->name }}</p>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item d-flex align-items-center" href="javascript:;">
                                        <i class="bx bx-user fs-5"></i><span>Profile</span></a>
                                </li>
                                <li>
                                    <div class="dropdown-divider mb-0"></div>
                                </li>
                                <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"
                                        onclick="$('#logout-form').submit();">
                                        <i class="bx bx-log-out-circle"></i><span>Logout</span></a>
                                </li>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf</form>
                        </div>
                    </nav>
                </div>
            </header>
            <!--end header -->
            <!--navigation-->
            <div class="primary-menu">
                @include('include.navbar');
            </div>
            <!--end navigation-->
        </div>
        <!--end header wrapper-->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <input type="hidden" value="{{ url('/') }}" id="public_path">

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
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')

            </div>
        </div>
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © 2023. <a href="https://kodig.id" target="_blank">CV TIM.</a></p>
        </footer>
    </div>
    <!--end wrapper-->


    <div id="modal_setting_app" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" width="100%">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title" id="modal_setting_appLabel" style="color:white">
                        Setting Aplikasi
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="modal_setting_appIsi">
                        <form class="form-horizontal" method="POST" action="{{ route('change_tahun_app_login') }}">
                            @csrf
                            <div class=" row mb-4">
                                <label for="inputName" class="col-md-3 form-label">Tahun</label>
                                <div class="col-md-9">
                                    <select class="form-control select22_modal_setting_tahun" id="setting_tahun"
                                        name="tahun" required="">
                                        @php
                                            $list_tahun = App\Models\Setting::get_tahun();
                                        @endphp
                                        @foreach ($list_tahun as $tahun)
                                            <option {{ Auth::user()->tahun == $tahun ? 'selected' : '' }}
                                                value="{{ $tahun }}">{{ $tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class=" row mb-4">
                                <label for="inputEmail3" class="col-md-3 form-label">SKPD</label>
                                <div class="col-md-9">
                                    <select class="form-control select22_modal_setting_tahun" id="setting_id_skpd"
                                        name="id_skpd" required="">
                                        @if ((Auth::user()->role_id == 2 || Auth::user()->role_id == 3) && !empty(Auth::user()->opd_id))
                                        @else
                                            <option value="global">Data Global</option>
                                        @endif
                                        @php
                                            $list_opd = App\Models\Opd::whereNull('induk')
                                                ->orderBy('unit_id')
                                                ->get();
                                            if ((Auth::user()->role_id == 2 || Auth::user()->role_id == 3) && !empty(Auth::user()->opd_id)) {
                                                $list_opd = App\Models\Opd::orderBy('unit_id')
                                                    ->where('id', Auth::user()->opd_id)
                                                    ->get();
                                            }
                                        @endphp
                                        @foreach ($list_opd as $uk)
                                            <option {{ Auth::user()->opd_id == $uk->id ? 'selected' : '' }}
                                                value="{{ $uk->id }}">{{ $uk->unit_id }}
                                                {{ $uk->unit_name }}</option>
                                            @foreach ($uk->subOpd as $ukk)
                                                <option {{ Auth::user()->opd_id == $ukk->id ? 'selected' : '' }}
                                                    value="{{ $ukk->id }}">---{{ $ukk->unit_id }}
                                                    {{ $ukk->unit_name }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-0 mt-4 row justify-content-end">
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-primary">Simpan</button>

                                    <button type="button" onclick="$('.modal').modal('hide')"
                                        class="btn btn-danger">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="ModalBiruSm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" width="100%">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title" id="ModalBiruSmLabel" style="color:white">
                        Judul
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="ModalBiruSmIsi">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ModalBiru" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" width="100%">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title" id="ModalBiruLabel" style="color:white">
                        Judul
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="ModalBiruIsi">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ModalHijau" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" width="100%">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title" id="ModalHijauLabel" style="color:white">
                        Judul
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="ModalHijauIsi">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ModalFull" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" width="100%">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title" id="ModalFullLabel" style="color:white">
                        Judul
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="max-height: 800px">
                    <div id="ModalFullIsi">

                    </div>
                </div>
            </div>
        </div>
    </div>


    @stack('modals')

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/js/chart.js') }}"></script>

    <script src="{{ asset('js/share.js') }}"></script>
    <script src="{{ asset('js/proses_data.js') }}"></script>

    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <!--Internal  Sweet-Alert js-->
    <script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweet-alert/jquery.sweet-alert.js') }}"></script>
    <!--app JS-->

    <!-- jQuery Library -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- RowGroup JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>>
    <script src="{{ asset('assets/plugins/select2/js/select2-custom.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
        $(document).ready(function() {
            if ($('.select22').length) {
                $('.select22').select2();
            }
        });
    </script>


    <script>
        if ($('.datatable-basic').length) {
            $('.datatable-basic').DataTable({
                autoWidth: false
            });
        }
        if ($('.datatable-not-paginate').length) {
            $('.datatable-not-paginate').DataTable({
                paging: false,
            });
        }
        if ($('.datatable-not-paginate-not-search').length) {
            $('.datatable-not-paginate-not-search').DataTable({
                paging: false,
                search: false
            });
        }
        if ($('.datatable-not-sortable-paging').length) {
            $('.datatable-not-sortable-paging').DataTable({
                paging: false,
                sort: false
            });
        }

        $(document).ready(function() {
            $('#setting_tahun').trigger('change');
            if ($('.select22').length) {
                $('.select22').select2();
            }
        });
    </script>

    <script>
        $('.select22modal').select2();

        function setting() {}
        $('.select22_modal_setting_tahun').select2({
            minimumResultsForSearch: '',
            width: '100%',
            dropdownParent: $('#modal_setting_app')
        });
    </script>
    @stack('scripts')
</body>

</html>
