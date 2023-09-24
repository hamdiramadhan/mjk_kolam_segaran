<form id="form_edit" method="post" action="{{ route('update_komponen') }}" class="form-horizontal">
    <div class="form-group">
        {{ csrf_field() }}
    </div>
    <p style="font-weight:bold"><i>Yang bertanda <span class="text-danger">*</span> wajib diisi/dipilih.</i></p>
    <input type="hidden" class="form-control" id="id" name="id" value="{{ $data->id }}">
    <div class="row mb-2">
        <div class="col-md-3">Kelompok Belanja <span style="color:red">*</span></div>
        <div class="col-md-9">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="[#]....." id="subtitle" name="subtitle"
                    value="{{ $data->subtitle ?? '[#]' }}">
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">Keterangan <span style="color:red">*</span></div>
        <div class="col-md-9">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="[-]....." id="subtitle2" name="subtitle2"
                    value="{{ $data->subtitle2 ?? '[-]' }}">
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">Rekening <span style="color:red">*</span></div>
        <div class="col-md-9">
            <div class="form-group">
                <select class="select22_modal" name="kode_rekening" id="kode_rekening" style="width:100%">
                    @foreach ($data_rekening as $dt)
                        <option {{ $dt->kode_rek == $data->kode_rekening ? 'selected' : '' }}
                            value="{{ $dt->kode_rek }}">{{ $dt->kode_rek }} - {{ $dt->nama_rek }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">Uraian <span style="color:red">*</span></div>
        <div class="col-md-9">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Masukkan Uraian" id="detail" name="detail"
                    value="{{ $data->detail }}" required>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">Spek</div>
        <div class="col-md-9">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Masukkan Spek" id="spek" name="spek"
                    value="{{ $data->spek }}">
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">Volume <span style="color:red">*</span></div>
        <div class="col-md-9">
            <div class="form-group">
                <input type="number" step="any" class="form-control" placeholder="Masukkan Jumlah" id="volume"
                    name="volume" value="{{ $data->volume }}" required>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">Satuan <span style="color:red">*</span></div>
        <div class="col-md-9">
            <div class="form-group">
                <select class="select22_modal" name="satuan" id="satuan" style="width:100%" required>
                    @foreach ($data_satuan as $dt)
                        <option {{ $dt->satuan == $data->satuan ? 'selected' : '' }} value="{{ $dt->satuan }}">
                            {{ $dt->satuan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">Harga <span style="color:red">*</span></div>
        <div class="col-md-9">
            <div class="form-group">
                <input type="number" step="any" class="form-control" placeholder="Masukkan Harga" id="harga"
                    name="harga" oninput="$('.txt_harga').html(addCommas(this.value));" value="{{ $data->harga }}"
                    required>
                Rp. <span class="help-text txt_harga">0</span>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">PPN</div>
        <div class="col-md-9">
            <div class="form-group">
                <input type="number" step="any" class="form-control" placeholder="Masukkan PPN" id="ppn"
                    name="ppn" value="{{ $data->ppn }}">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-success">
            <i class="fa fa-edit"></i> Simpan</button>
        <button type="button" class="btn btn-sm btn-danger" onclick="dismissmodal()">
            <i class="fa fa-times"></i>
            Batal
        </button>
    </div>
</form>
<script type="text/javascript">
    $('.select22_modal').select2({
        minimumResultsForSearch: '',
        width: '100%',
        dropdownParent: $('#form_edit')
    });
</script>
