<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 10px;
        }
        .field {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="title">Surat Permohonan</div>
    <div class="content">
        <p><span class="field">NIK:</span> {{ $persuratan->pengajuan->penduduk->nik }}</p>
        <p><span class="field">Nama:</span> {{ $persuratan->pengajuan->penduduk->nama }}</p>
        <p><span class="field">Jenis Surat:</span> {{ $persuratan->jenis_surat }}</p>
        <p><span class="field">Keperluan:</span> {{ $persuratan->pengajuan->keperluan }}</p>
        <p><span class="field">Keterangan:</span> {{ $persuratan->pengajuan->keterangan }}</p>
        <p><span class="field">Disetujui Tanggal:</span> {{ $persuratan->pengajuan->accepted_at }}</p>
    </div>
</body>
</html>
