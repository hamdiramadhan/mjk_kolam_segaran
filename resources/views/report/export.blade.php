<table>
    <thead>
        <tr>
            <th colspan="8"><b> REKAPITULASI USULAN PERGESERAN ANGGARAN</b></th>
        </tr>
        <tr>

        </tr>
        <tr>

        </tr>
        <tr>
            <th style="width: 5%">No</th>
            <th>SKPD</th>
            <th>Level</th>
            <th>Kode Sub Kegiatan</th>
            <th>Nama Sub Kegiatan</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Fase</th>
        </tr>
    </thead>
    <tbody>
        @php $i=0; @endphp
        @foreach ($pengajuandetail as $r)
            @php $i++; @endphp
            <tr>
                <td>{{ $i }}</td>
                <td>
                    {{ $r->pengajuan->skpd->unit_name }}
                </td>
                <td>{{ $r->pengajuan->usulan->usulan }}</td>
                <td> {{ $r->sub_kegiatan->kode_sub_kegiatan }}</td>
                <td> {{ $r->sub_kegiatan->nama_sub_kegiatan }}</td>
                <td> <span
                        class="badge bg-{{ $r->pengajuan->stat->color_div }} text-white shadow-sm w-100">{{ $r->pengajuan->stat->nama }}</span>
                </td>
                <td> {{ $r->pengajuan->tanggal_surat }}</td>
                <td> {{ $r->pengajuan->fase->nama }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
