<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $persuratan->jenis_surat }} | {{ $persuratan->pemohon()->nama }}</title>
    <style>
        :root {
            font-family: 'Calibri', sans-serif;
            font-size: 14px;
        }

        html,
        body,
        div,
        span,
        applet,
        object,
        iframe,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        blockquote,
        pre,
        a,
        abbr,
        acronym,
        address,
        big,
        cite,
        code,
        del,
        dfn,
        em,
        img,
        ins,
        kbd,
        q,
        s,
        samp,
        small,
        strike,
        strong,
        sub,
        sup,
        tt,
        var,
        b,
        u,
        i,
        center,
        dl,
        dt,
        dd,
        ol,
        ul,
        li,
        fieldset,
        form,
        label,
        legend,
        table,
        caption,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        td,
        article,
        aside,
        canvas,
        details,
        embed,
        figure,
        figcaption,
        footer,
        header,
        hgroup,
        menu,
        nav,
        output,
        ruby,
        section,
        summary,
        time,
        mark,
        audio,
        video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        /* HTML5 display-role reset for older browsers */
        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        menu,
        nav,
        section {
            display: block;
        }

        body {
            line-height: 1;
        }

        ol,
        ul {
            list-style: none;
        }

        blockquote,
        q {
            quotes: none;
        }

        blockquote:before,
        blockquote:after,
        q:before,
        q:after {
            content: '';
            content: none;
        }

        /* table {
            border-collapse: collapse;
            border-spacing: 0;
        } */
    </style>
</head>

<body style="padding: 4rem;">
    <div style="text-align: center; font-weight: bold; border-bottom: 2px solid black; padding: 1rem;">
        <h1 style="font-size: 1.4rem;">RUKUN TETANGGA 01 RUKUN WARGA 03 <br> KELURAHAN TUNJUNGSEKAR KECAMATAN LOWOKWARU
            <br> KOTA MALANG
        </h1>
    </div>

    <div style="text-align: center;padding: 1.5rem;">
        <div>
            <h1 style="font-weight: bold; text-decoration: underline; margin-bottom: 0.5rem;">SURAT PENGANTAR</h1>
        </div>
        <div>
            <p>Nomor: .... / RT 01 / RW 03 / TS / {{ date('Y') }} / 20</p>
        </div>
    </div>

    <div>
        <p style="text-align: center; font-weight: bold">Yang bertandatangan di bawah ini menerangkan bahwa:</p>
    </div>

    <table style="width: 100%; margin-top: 1.5rem; padding: 0 1.3rem">
        <tr>
            <td style="padding: 0.3rem 0;">1.</td>
            <td style="width: 180px; padding: 0.3rem 0;">Nama</td>
            <td style="padding: 0.3rem 0; width: 20px">:</td>
            <td style="padding: 0.3rem 0;">{{ $persuratan->pengajuan->penduduk->nama }}</td>
        </tr>
        <tr>
            <td style="padding: 0.3rem 0;">2.</td>
            <td style="width: 180px; padding: 0.3rem 0;">Tempat, Tanggal Lahir</td>
            <td style="padding: 0.3rem 0; width: 20px">:</td>
            <td style="padding: 0.3rem 0;">
                {{ \Carbon\Carbon::parse($persuratan->pengajuan->penduduk->tanggal_lahir)->locale('id_ID')->isoFormat('DD MMMM YYYY') }}
            </td>
        </tr>
        <tr>
            <td style="padding: 0.3rem 0;">3.</td>
            <td style="width: 180px; padding: 0.3rem 0;">Jenis Kelamin</td>
            <td style="padding: 0.3rem 0; width: 20px">:</td>
            <td style="padding: 0.3rem 0;">
                <p style="display: inline-block; width: 80px; padding-top: 0.3rem"><span
                        style="{{ $persuratan->pemohon()->jenis_kelamin == 'Laki-laki' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">a.</span>
                    Laki-laki</p>
                <p style="display: inline-block; width: 150px; padding-top: 0.3rem"><span
                        style="{{ $persuratan->pemohon()->jenis_kelamin == 'Perempuan' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">b.</span>
                    Perempuan * )</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 0.3rem 0;">4.</td>
            <td style="width: 180px; padding: 0.3rem 0;">Agama</td>
            <td style="padding: 0.3rem 0; width: 20px">:</td>
            <td style="padding: 0.3rem 0;">{{ $persuratan->pengajuan->penduduk->agama ?? "" }}</td>
        </tr>
        <tr>
            <td style="padding: 0.3rem 0;">5.</td>
            <td style="width: 180px; padding: 0.3rem 0;">Status Perkawinan</td>
            <td style="padding: 0.3rem 0; width: 20px">:</td>
            <td style="padding: 0.3rem 0;">
                <p style="display: inline-block; width: 80px; padding-top: 0.3rem"><span
                        style="{{ $persuratan->pemohon()->status_perkawinan == 'Kawin' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : ''}}">a.</span>
                    Kawin</p>
                <p style="display: inline-block; width: 110px; padding-top: 0.3rem"><span
                        style="{{ $persuratan->pemohon()->status_perkawinan == 'Belum Kawin' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">b.</span>
                    Belum Kawin</p>
                <p style="display: inline-block; width: 110px; padding-top: 0.3rem"><span
                        style="{{ $persuratan->pemohon()->status_perkawinan == 'Cerai Hidup' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">c.</span>
                    Cerai Hidup</p>
                <p style="display: inline-block; width: 110px; padding-top: 0.3rem"><span
                        style="{{ $persuratan->pemohon()->status_perkawinan == 'Cerai Mati' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">d.</span>
                    Cerai Mati * )</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 0.3rem 0;">6.</td>
            <td style="width: 180px; padding: 0.3rem 0;">Pekerjaan</td>
            <td style="padding: 0.3rem 0; width: 20px">:</td>
            <td style="padding: 0.3rem 0;">{{ $persuratan->pengajuan->penduduk->pekerjaan ??  "" }}</td>
        </tr>
        <tr>
            <td style="padding: 0.3rem 0;">7.</td>
            <td style="width: 180px; padding: 0.3rem 0;">Nomor KTP / KK</td>
            <td style="padding: 0.3rem 0; width: 20px">:</td>
            <td style="padding: 0.3rem 0;">{{ $persuratan->pengajuan->penduduk->nik ?? ""}}</td>
        </tr>
        <tr>
            <td style="padding: 0.3rem 0;">8.</td>
            <td style="width: 180px; padding: 0.3rem 0;">Alamat</td>
            <td style="padding: 0.3rem 0; width: 20px">:</td>
            <td style="padding: 0.3rem 0;">{{ $persuratan->pengajuan->penduduk->kartuKeluarga->alamat ?? "" }}</td>
        </tr>
        <tr style="border: 1px solid black">
            <td style="padding: 0.3rem 0;">9.</td>
            <td colspan="3" style="padding: 0.3rem 0">Bahwa nama tersebut diatas benar-benar warga RT 01 RW 03 dan
                berkelakuan baik.</td>
        </tr>
        <tr>
            <td style="padding: 0.3rem 0;">&nbsp;</td>
            <td colspan="3" style="padding: 0.3rem 0; font-weight: bold">Surat Pengantar ini dipergunakan untuk
                mengurus : </td>
        </tr>
        <tr>
            <td style="padding: 0.3rem 0;">&nbsp;</td>
            <td colspan="3">
                <div>
                    <table>
                        <tr>
                            <td style="width: 150px; padding: 0.5rem 0">
                                <p style="display: inline-block;"><span
                                        style="{{ $persuratan->jenis_surat == 'Surat Pengantar KTP' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">a.</span>
                                    KTP</p>
                            </td>
                            <td style="width: 150px; padding: 0.5rem 0">
                                <p style="display: inline-block;"><span
                                        style="{{ $persuratan->jenis_surat == 'Surat Pengantar Kartu Keluarga' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">b.</span>
                                    KK</p>
                            </td>
                            <td style="width: 150px; padding: 0.5rem 0">
                                <p style="display: inline-block;"><span
                                        style="{{ $persuratan->jenis_surat == 'Surat Pengantar Akta Kelahiran' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">c.</span>
                                    Akte Kelahiran</p>
                            </td>
                            <td style="width: 150px; padding: 0.5rem 0">
                                <p style="display: inline-block;"><span
                                        style="{{ $persuratan->jenis_surat == 'Surat Pengantar Akta Kematian' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">d.</span>
                                    Akte Kematian</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px; padding: 0.5rem 0">
                                <p style="display: inline-block;"><span
                                        style="{{ $persuratan->jenis_surat == 'Surat Pengantar SKCK' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">e.</span>
                                    SKCK</p>
                            </td>
                            <td style="width: 150px; padding: 0.5rem 0">
                                <p style="display: inline-block;"><span
                                        style="{{ $persuratan->jenis_surat == 'Surat Pengantar Nikah' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">f.</span>
                                    Persyaratan Nikah</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="width: 150px; padding: 0.5rem 0">
                                <p style="display: inline-block;"><span
                                        style="{{ $persuratan->jenis_surat == 'Lainnya' ? 'border: 2px solid black; border-radius: 100%; padding: 2px' : '' }}">g.</span>
                                    (Lainnya) :
                                    @if ($persuratan->jenis_surat === 'Lainnya')
                                        <span
                                            style="border-bottom-color: black; border-bottom-width: 1.5px; border-bottom-style: solid; overflow-wrap: break-word; line-height: 1.3rem;">
                                            {{ $persuratan->pengajuan->keperluan }}
                                        </span>
                                    @else
                                        .....................................................................................................................................
                                    @endif
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div style="text-align: center; margin-top: 1.5rem">
        <p>Demikian Surat Pengantar ini dibuat untuk dipergunakan sebagaimana mestinya</p>
    </div>

    <table style="width: 100%; margin-top: 3rem; padding: 0 1.3rem">
        <tr>
            <td>
                <table>
                    <tr>
                        <td style="padding: 0.3rem 0; width: 50px;">Nomor</td>
                        <td style="padding: 0.3rem 0">:</td>
                        <td style="padding: 0.3rem 0">........ / III / TS / ...... / 20</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.3rem 0; width: 50px;">Tanggal</td>
                        <td style="padding: 0.3rem 0">:</td>
                        <td style="padding: 0.3rem 0">..................................</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 0.3rem 0">Ketua RW 03 ,</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.3rem 0">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.3rem 0">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.3rem 0">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 0.3rem 0">.........................................................</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td style="padding: 0.3rem 0">Malang,
                            {{ \Carbon\Carbon::parse($persuratan->pengajuan->accepted_at)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.3rem 0">&nbsp;</td>
                        <td style="padding: 0.3rem 0"></td>
                        <td style="padding: 0.3rem 0"></td>
                    </tr>
                    <tr>
                        <td style="padding: 0.3rem 0">Ketua RT 01 ,</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.3rem 0">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.3rem 0">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.3rem 0">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.3rem 0">{{ $persuratan->pengajuan->acceptedBy->nama }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="margin-top: 2rem">
        <p style="text-decoration: underline; text-transform: uppercase">Catatan:</p>
        <table>
            <tr>
                <td>1.</td>
                <td>Semua pengurusan surat di Kelurahan harus melampirkan Foto Copy KTP / KK / Pelunasan PBB Tahun 2018.
                </td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Untuk Pengurusan KTP dilampiri:</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Pas Foto Berwarna ukuran 4 x 6 sebanyak 4 lembar.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>(Background sesuai Tahun Kelahiran: Warna Biru = Tahun Genap, Warna Merah = Tahun Ganjil).</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>*) Lingkari huruf a, b, c, d, e, atau g sesuai dengan yang diinginkan.</td>
            </tr>
        </table>
    </div>

</body>

</html>
