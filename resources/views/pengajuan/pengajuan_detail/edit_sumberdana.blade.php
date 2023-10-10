<style>
    .select2-container {
        z-index: 9999;
        /* Adjust this value as needed */
    }
</style>
<form id="form_edit" method="post" action="{{ route('update_sumberdana', encrypt($id)) }}" class="form-horizontal">
    <div class="form-group">
        {{ csrf_field() }}
    </div>
    <p style="font-weight:bold"><i>Yang bertanda <span class="text-danger">*</span> wajib diisi/dipilih.</i></p>
    <div class="row mb-2">
        <div class="col-md-3">Sumber Dana <span style="color:red">*</span></div>
        <div class="col-md-9">
            <div class="form-group">
                <select id="sumberdana[]" name="sumberdana[]" class="form-control select2-multiple" style="width: 100%"
                    aria-placeholder="Pilih Sumber Dana" multiple="multiple">
                    @foreach ($sumber_dana as $r)
                        @php $selected = in_array($r->id, $sumber_dana_pengajuan->pluck('sumber_dana_id')->toArray()) ? 'selected' : ''; @endphp
                        <option value="{{ $r->id }}" {{ $selected }}>{{ $r->id }} -
                            {{ $r->nama }}</option>
                    @endforeach
                </select>
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

<script>
    // Initialize Select2 on the select element with the 'select2-multiple' class
    $(document).ready(function() {
        $('.select2-multiple').select2({
            placeholder: 'Pilih Sumber Dana'
        });
    });
</script>
