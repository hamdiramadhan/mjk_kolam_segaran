<style>
    .table tbody tr td {
        word-break: break-word !important;
        vertical-align: top;
    }

    table tbody tr td {
        word-break: break-word !important;
        vertical-align: top;
    }

    .select2-container {
        z-index: 9999;
        /* Adjust this value as needed */
    }
</style>
<div class="showOpd" style="display:none">
    <button type="button" id="simpanopd" class="btn waves-effect btn-success btn-md"
        onclick="$('.modalAddSubKegiatan').modal('show')">
        <i class=" fas fa-plus"></i> SKPD Sub Kegiatan
    </button>
    <button type="button" id="batalpindah" onClick="GetId(this.id)" class="btn waves-effect btn-danger btn-md">
        <i class=" fas fa-times"></i> Batal
    </button><br><br>
    <div class="col-lg-12">
        <div class="alert alert-warning">
            <ol>
                <li>
                    Centang <input class="form-check-inputs" checked type="checkbox"> (Checkbox)
                    untuk memilih
                    <b>Sub Kegiatan</b> yang ingin di pindah pada daftar Kegiatan SKPD Di bawah ini.
                </li>
                <li>
                    Jika sudah pilih Tombol <b>+ SKPD SUB KEGIATAN</b>.
                </li>
                <li>
                    Pilih SKPD terlebih dahulu, lalu Simpan <b>Sub Kegiatan</b> yang sudah dicentang
                    tadi.
                </li>
                <li>
                    Data <b>Sub Kegiatan</b> akan berpindah ke SKPD yang sudah dipilih.
                </li>
            </ol>
        </div>
    </div>
</div>

<div class="row">

    <div class="scrollable">
        <form action="{{ route('pengajuan_detail.store', encrypt($id)) }}" method="POST">
            @csrf
            <table class="table text-md-nowrap datatable-basic-subkegiatans">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="background-color: #ccf6c8">Program</th>
                        <th style="background-color: #ccf6c8">Kegiatan</th>
                        <th style="width: 180px">Sumber Dana</th>
                        <th style="width: 180px">Kode</th>
                        <th>Nama</th>
                        <th scope='col'>Nilai
                            <br>
                            <span class="badge badge-primary txt_total_pagu">0</span>
                        </th>
                        <th scope='col' style="width: 1%">Act</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $n = 0;
                    $total_pagu = 0;
                    ?>
                    @foreach ($data_sub_kegiatan as $dk)
                        <?php $n++;
                        $pagu = $dk->get_total_komponen($dk->id);
                        $total_pagu += $pagu; ?>
                        <tr>
                            <td>{{ $n }}</td>
                            <td style="background-color: #ccf6c8 !important">
                                Prog : {{ $dk->kegiatan->program->kode_program }}
                                {{ $dk->kegiatan->program->nama_program }}
                            </td>
                            <td style="background-color: #ccf6c8 !important">
                                &nbsp;&nbsp;&nbsp;&nbsp;Keg : {{ $dk->kegiatan->kode_kegiatan }}
                                {{ $dk->kegiatan->nama_kegiatan }}
                            </td>
                            <td style="word-break: break-word !important;"><input class="form-check-input"
                                    style="transform: scale(1.5)  !important" type="checkbox"
                                    value="{{ $dk->id }}" name="sub_kegiatan[]" id="checks"
                                    onclick="Checkeds()">

                                {{ $dk->kode_sub_kegiatan }}
                            </td>
                            <td>
                                <select id="sumber_dana_{{ $dk->id }}" name="sumber_dana_{{ $dk->id }}[]"
                                    class="form-control select2-multiple" aria-placeholder="Pilih Sumber Dana"
                                    multiple="multiple">
                                    @foreach ($sumber_dana as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td> {{ $dk->nama_sub_kegiatan }}</td>
                            <td style="min-width: 150px !important;" align="right">
                                <span class="badge badge-warning">
                                    {{ number_format($pagu, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-popup="tooltip"
                                    title="Komponen"
                                    onclick=" sub_kegiatan_rincian_detail('{{ csrf_token() }}','{{ $dk->id }}')">
                                    <i class="fa fa-list me-0"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="modal-footer">

                <button type="submit" class="btn btn-success"><i class="icon-check"></i>
                    Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Select2 on the select element with the 'select2-multiple' class
    $(document).ready(function() {
        $('.select2-multiple').select2({
            placeholder: 'Pilih Sumber Dana'
        });
    });
</script>
<script type="text/javascript">
    // START SCRIPT TABEL 
    $(document).ready(function() {
        var table = $('.datatable-basic-subkegiatans').DataTable({
            "ordering": false,
            "paginate": false,
            "autoWidth": true,
            "columnDefs": [{
                "visible": false,
                "targets": [1, 2]
            }],
            rowGroup: {
                dataSrc: [1, 2],
                className: 'table-group'
            }
        });
    });
    // END SCRIPT TABEL   
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    $('.txt_total_pagu').html(numberWithCommas('{{ $total_pagu }}'));

    $('.select22').select2();
    //check sub kegiatan
    function Checkeds() {
        var arr = [];
        $.each($("input[name='sub_kegiatan[]']:checked"), function() {
            arr.push($(this).val());
            $('#id_sub_kegiatan').val(arr.join(", "));
            // console.log($(this).val());
        });
        if (arr.length == 0) {
            $('#id_sub_kegiatan').val("");
        }
    }
    //show hide button pindah opd
    function GetId(id) {
        if (id == 'pindahopd') {
            $('.showOpd').show(500);
            $('.form-check-input').show(500);
            $('.showOpd2').hide(500);
        } else {
            $('.showOpd2').show(500);
            $('.showOpd').hide(500);
            $('.form-check-input').hide(500);
        }
    }

    function sub_kegiatan_rincian_detail(token, id_sub_kegiatan) {
        $("#ModalFull").modal("show");
        $("#ModalFullIsi").html('loading...');
        $("#ModalFullLabel").html("Detail Komponen");

        var act = "{{ route('sub_kegiatan_rincian_detail') }}";
        $.post(
            act, {
                _token: token,
                id_sub_kegiatan: id_sub_kegiatan,
            },
            function(data) {
                $("#ModalFullIsi").html(data);
                $("#ModalFull").modal("show");
            }
        );
    }
</script>
