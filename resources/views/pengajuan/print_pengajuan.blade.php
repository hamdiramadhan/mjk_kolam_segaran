@php
    function hari_ini($d)
    {
        $hari = date('D', strtotime($d));

        switch ($hari) {
            case 'Sun':
                $hari_ini = 'Minggu';
                break;

            case 'Mon':
                $hari_ini = 'Senin';
                break;

            case 'Tue':
                $hari_ini = 'Selasa';
                break;

            case 'Wed':
                $hari_ini = 'Rabu';
                break;

            case 'Thu':
                $hari_ini = 'Kamis';
                break;

            case 'Fri':
                $hari_ini = 'Jumat';
                break;

            case 'Sat':
                $hari_ini = 'Sabtu';
                break;

            default:
                $hari_ini = '';
                break;
        }
        return $hari_ini;
    }

    function tgl_indo($tanggal)
    {
        try {
            $bulan = [
                1 => 'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ];
            $pecahkan = explode('-', $tanggal);

            return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
        } catch (\Throwable $th) {
            return '';
        }
    }
@endphp
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $judul }}</title>
    <style>
        footer {
            position: fixed;
            bottom: -35px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            /* color: white; */
            font-size: 7pt;
            font-family: Arial, Helvetica, sans-serif;
            justify-content: center;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
        }

        [type="checkbox"] {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <footer>
        <table style="width: 100%;border-top: 1px solid gray" border="0">
            <tr>
                <td>
                    Dicetak pada {{ date('Y-m-d H:i') }} -
                    {{ str_replace('https://', '', str_replace('http://', '', url('/'))) }}
                    {{-- - * merupakan usulan OPD lain. ** merupakan data manual --}}
                </td>
            </tr>
        </table>
    </footer>
    <br>
    <table style="width: 100%" border="0">
        <tr>
            <td width="85" style="text-align: right;">
                <img src="{{ public_path('logo_mjk.png') }}" alt="" width="80">
            </td>
            <td align="center" style="text-align: center;">
                <span style="font-size: 13pt">PEMERINTAH KABUPATEN MOJOKERTO</span>
                <br>
                <span style="font-size: 14pt">
                    {{ strtoupper($opd->unit_name) }}
                </span>
                <br>
                <span style="font-size: 11pt;">
                    Jl. A. Yani Nomor 16, Kode Pos 61318, Jawa Timur.
                    <br>
                    Telp. (0321) 322744 email: bpkad@mojokertokab.go.id
                </span>
            </td>
        </tr>
    </table>
    <hr style="height: 2px;background: black;">
    <hr style="margin-top: -5px">

    <div style="padding-left: 40px;padding-right: 10px;">
        <table style="width: 100%" border="0">
            <tr>
                <td width="10%" style="text-align: left;">
                </td>
                <td width="1%"></td>
                <td width="60%">
                </td>
                <td>
                    Mojokerto, {{ tgl_indo($data->tanggal_surat) }}<br>
                    Kepada
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    Nomor
                </td>
                <td>
                    :
                </td>
                <td>
                    {{ $data->nomor_surat }}
                </td>
                <td>
                    Yth, {{ $kepada }}
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    Sifat
                </td>
                <td>
                    :
                </td>
                <td>
                    {{ $data->sifat_surat }}
                </td>
                <td style="text-align: left;">
                    c.q. PPKD Kab. Mojokerto
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    Lampiran
                </td>
                <td>
                    :
                </td>
                <td>
                    di -
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: left; vertical-align: top">
                    Hal
                </td>
                <td style="text-align: left; vertical-align: top">
                    :
                </td>
                <td> Usulan Pergeseran Anggaran<br> Dalam APBD TA {{ Auth::user()->tahun }}</td>
                <td style="text-align: left; vertical-align: top">
                    MOJOKERTO
                </td>
            </tr>
        </table>
    </div>
    <div style="padding-left: 100px; padding-right: 10px;">
        <p style="text-align: justify; text-justify: inter-word;margin-bottom: -10px; text-indent: 38px; ">
            Dengan memperhatikan ketentuan Pergeseran Anggaran sebagaimana tercantum dalam
            Peraturan Bupati Mojokerto Nomor ….. Tahun 2021 tentang Tata Cara Pergeseran
            Anggaran, dengan hormat kami mengajukan usulan {{ $data->usulan->usulan }}. Dalam Anggaran Pendapatan dan
            Belanja Daerah (APBD) Tahun Anggaran {{ $tahun }} dengan alasan dan
            pertimbangan sebagai berikut:
        </p>
        <ol>
            @foreach ($pengajuan_alasan as $r)
                @if (!empty($r->alasan))
                    <li style="margin-bottom: 5px; text-align: justify;">
                        {{ $r->alasan }}
                    </li>
                @endif
            @endforeach
        </ol>
        <p style="text-align: justify; text-justify: inter-word; text-indent: 38px; ">
            Berkaitan dengan hal tersebut di atas, kami mohon kiranya Bapak dapat menyetujui usulan Pergeseran Anggaran
            yang
            kami ajukan agar dapat ditampung dalam Peraturan Bupati tentang Perubahan Penjabaran APBD sebagai dasar
            penerbitan Perubahan Dokumen Pelaksanaan Anggaran Satuan Kerja Perangkat Daerah (Perubahan DPA-SKPD), dengan
            rincian pergeseran/ perubahan anggaran dan rancangan DPPA sebagaimana terlampir.
        </p>
        <p style="text-align: justify; text-justify: inter-word; text-indent: 38px; ">
            Demikian disampaikan, atas perhatian dan kerjasamanya diucapkan terima kasih.
        </p>
    </div>
    <div style="padding-left: 10px;">
        <div style="font-size: 11pt;">
            <table border="0" style="width:100%">
                <tr>
                    <td align="center" style="width: 55%">
                    </td>
                    <td align="center">
                        <b>{{ $opd->kepala_opd ?? 'Kepala SKPD' }}
                        </b>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <b><u>NAMA LENGKAP</u></b>
                        <br>
                        PANGKAT / GOL
                        <br>
                        NIP
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div style="padding-left: 40px;">
        <p style="text-align: justify; text-justify: inter-word; margin-bottom: -15px;">
            Tembusan :
        </p>
        <ol>
            <li>Kepala BPKAD Kabupaten Mojokerto</li>
            <li>Kepala Bappeda Kabupaten Mojokerto</li>
            <li>Inspektur Kabupaten Mojokerto</li>
        </ol>
    </div>
    <p style="text-align: justify; text-justify: inter-word; margin-top: 40px;">
        *) Dipilih salah satu jenis pergeseran yang akan dilakukan
    </p>
</body>

</html>
