<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Kartu Rencana Studi</title>

    <style>
        body {
            margin: 30px;
            color: #222222;
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            padding-bottom: 15px;
            border-bottom: 2px solid #222222;
            text-align: center;
        }

        .header h1 {
            margin: 0 0 5px;
            font-size: 20px;
        }

        .header p {
            margin: 0;
        }

        .identity {
            width: 100%;
            margin: 25px 0 20px;
        }

        .identity td {
            padding: 4px 0;
        }

        .identity-label {
            width: 140px;
            font-weight: bold;
        }

        .krs-table {
            width: 100%;
            border-collapse: collapse;
        }

        .krs-table th,
        .krs-table td {
            padding: 9px;
            border: 1px solid #444444;
        }

        .krs-table th {
            background-color: #eeeeee;
            text-align: center;
        }

        .center {
            text-align: center;
        }

        .total {
            font-weight: bold;
        }

        .empty {
            padding: 20px;
            text-align: center;
        }

        .signature {
            width: 240px;
            margin-top: 40px;
            margin-left: auto;
            text-align: center;
        }

        .signature-space {
            height: 65px;
        }
    </style>
</head>

<body>
    <header class="header">
        <h1>KARTU RENCANA STUDI</h1>

        <p>Sistem Informasi Akademik Sederhana</p>
    </header>

    <table class="identity">
        <tr>
            <td class="identity-label">Nama Mahasiswa</td>
            <td>: {{ $mahasiswa->nama }}</td>
        </tr>

        <tr>
            <td class="identity-label">NPM</td>
            <td>: {{ $mahasiswa->npm }}</td>
        </tr>

        <tr>
            <td class="identity-label">Tanggal Cetak</td>
            <td>: {{ now()->format('d-m-Y') }}</td>
        </tr>
    </table>

    <table class="krs-table">
        <thead>
            <tr>
                <th width="45">No.</th>
                <th width="110">Kode</th>
                <th>Nama Mata Kuliah</th>
                <th width="65">SKS</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($krs as $item)
                <tr>
                    <td class="center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="center">
                        {{ $item->kode_matakuliah }}
                    </td>

                    <td>
                        {{ $item->matakuliah?->nama_matakuliah ?? '-' }}
                    </td>

                    <td class="center">
                        {{ $item->matakuliah?->sks ?? 0 }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td
                        colspan="4"
                        class="empty"
                    >
                        Belum ada mata kuliah yang diambil.
                    </td>
                </tr>
            @endforelse

            <tr class="total">
                <td colspan="3">
                    Total SKS
                </td>

                <td class="center">
                    {{ $totalSks }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>Mahasiswa,</p>

        <div class="signature-space"></div>

        <strong>{{ $mahasiswa->nama }}</strong>

        <p>NPM {{ $mahasiswa->npm }}</p>
    </div>
</body>
</html>