<form method="POST" action="{{ route('store_komponen_rekening') }}" id="modal_tambah_komponen"
    enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" class="form-control" id="opd_id" name="opd_id"
        value="{{ $pengajuan_detail->sub_kegiatan->opd_id }}">
    <input type="hidden" class="form-control" id="id_kegiatan" name="id_kegiatan"
        value="{{ $pengajuan_detail->sub_kegiatan->id }}">
    <input type="hidden" class="form-control" id="tahun" name="tahun" value="{{ date('Y') }}">
    <input type="hidden" class="form-control" id="pengajuan_detail_id" name="pengajuan_detail_id"
        value="{{ $pengajuan_detail->id }}">
    {{-- <input type="hidden" class="form-control" id="detail_id" name="detail_id" value="{{ $data_detail->id }}"> --}}
    <div class="modal-body row">
        <p style="font-weight:bold"><i>Yang bertanda <span class="text-danger">*</span> wajib
                diisi/dipilih.</i></p>
        <div class="col-md-2">Kelompok Belanja <span style="color:red">*</span></div>
        <div class="col-md-10">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="[#]....." id="tmb_subtitle" name="subtitle"
                    value="[#]" required>
            </div>
        </div>
        <div class="col-md-2">Keterangan<span style="color:red">*</span></div>
        <div class="col-md-10">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="[-]....." id="tmb_subtitle2" name="subtitle2"
                    value="[-]" required>
            </div>
        </div>

        <div class="col-md-2">Kode Rekening<span style="color:red">*</span></div>
        <div class="col-md-10">
            <div class="form-group">
                <select class="select2onmodal" name="kode_rekening" id="tmb_kode_rekening" style="width: 100%">
                    @foreach ($data_rekening as $dt)
                        <option value="{{ $dt->kode_rek }}" {{ strlen($dt->kode_rek) <= 12 ? 'disabled' : '' }}>
                            {{ $dt->kode_rek }} - {{ $dt->nama_rek }} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">Uraian<span style="color:red">*</span></div>
        <div class="col-md-10">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Masukkan Uraian" id="detail" name="detail"
                    required>
            </div>
        </div>
        <div class="col-md-2">Satuan<span style="color:red">*</span></div>
        <div class="col-md-10">
            <div class="form-group">
                <select class="select2onmodal" name="satuan" id="satuan" style="width:100%" required>
                    @foreach ($data_satuan as $dt)
                        <option value="{{ $dt->satuan }}">{{ $dt->satuan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">Spek</div>
        <div class="col-md-10">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Masukkan Spek" id="spek" name="spek">
            </div>
        </div>
        <div class="col-md-2">Koefisien<span style="color:red">*</span></div>
        <div class="col-md-10">
            <div class="form-group">
                <input type="number" step="any" class="form-control" placeholder="Masukkan Koefisien"
                    id="volume" name="volume" required>
            </div>
        </div>
        <div class="col-md-2">Harga<span style="color:red">*</span></div>
        <div class="col-md-10">
            <div class="form-group">
                <input type="number" step="any" class="form-control" placeholder="Masukkan Harga" id="harga"
                    name="harga" oninput="$('.txt_harga').html(addCommas(this.value));" required>
                Rp. <span class="help-text txt_harga">0</span>
            </div>
        </div>
        <div class="col-md-2">PPN</div>
        <div class="col-md-10">
            <div class="form-group">
                <input type="number" step="any" class="form-control" placeholder="Masukkan PPN" id="ppn"
                    name="ppn" value="0">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-success"><i class="icon-check"></i>
                Simpan</button>
            <button type="button" class="btn btn-sm btn-danger" onclick="$('.modal').modal('hide')"><i
                    class="icon-cancel-circle2"></i>
                Batal</button>
        </div>
</form>

<script>
    $('.select2onmodal').select2({
        dropdownParent: $('#modal_tambah_komponen')
    });
</script>
