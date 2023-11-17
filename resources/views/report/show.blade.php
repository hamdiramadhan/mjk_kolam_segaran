<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Data</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="lni lni-bookmark-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{!! @$nama_header !!}</li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">

        <form action="{{ route('export_excel', $fase->id) }}" method="post" target="_blank">
            @csrf
            <button type="submit" class="btn btn-sm btn-success">
                <i class="fa fa-upload"></i> Export Excel
            </button>
        </form>
    </div>
</div>
<!--end breadcrumb-->

<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap datatable-report">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Nomor Pengajuan</th>
                                <th>Level</th>
                                <th>Kode Sub Kegiatan</th>
                                <th>Nama Sub Kegiatan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=0; @endphp
                            @foreach ($pengajuandetail as $r)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                        {{ $r->pengajuan->nomor_surat }}
                                    </td>
                                    <td>{{ $r->pengajuan->usulan->usulan }}</td>
                                    <td> {{ $r->sub_kegiatan->kode_sub_kegiatan }}</td>
                                    <td> {{ $r->sub_kegiatan->nama_sub_kegiatan }}</td>
                                    <td> <span
                                            class="badge bg-{{ $r->pengajuan->stat->color_div }} text-white shadow-sm w-100">{{ $r->pengajuan->stat->nama }}</span>
                                    </td>
                                    <td> {{ $r->pengajuan->tanggal_surat }}</td>

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

<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    // START SCRIPT TABEL 
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
    // END SCRIPT TABEL   
</script>
