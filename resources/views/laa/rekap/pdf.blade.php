<!DOCTYPE html>
<html>

<head>
    <title>Rekapitulasi BAP</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
        }

        .header p {
            margin: 2px 0;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            bg-color: #f0f0f0;
        }

        .meta {
            margin-bottom: 15px;
        }

        .meta p {
            margin: 2px 0;
        }

        .status-badge {
            font-weight: bold;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Rekapitulasi Berita Acara Pengawasan (BAP)</h1>
        <p>Layanan Administrasi Akademik - Telkom University</p>
    </div>

    <div class="meta">
        <p><strong>Periode Ujian:</strong> {{ $periode ?: 'Semua Periode' }}</p>
        <p><strong>Program Studi:</strong> {{ $prodiName }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    @if($jenis == 'per_pengawas')
        <!-- TABLE FOR PER PENGAWAS -->
        <table>
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Nama Pengawas</th>
                    <th>NIM</th>
                    <th width="60" align="center">Total</th>
                    <th width="60" align="center" style="color: green;">Verified</th>
                    <th width="60" align="center" style="color: orange;">Pending</th>
                    <th width="60" align="center" style="color: red;">Rejected</th>
                </tr>
            </thead>
            <tbody>
                @foreach($perPengawas as $index => $row)
                    <tr>
                        <td align="center">{{ $index + 1 }}</td>
                        <td>{{ $row['name'] }}</td>
                        <td>{{ $row['nip'] }}</td>
                        <td align="center"><b>{{ $row['total'] }}</b></td>
                        <td align="center">{{ $row['approved'] }}</td>
                        <td align="center">{{ $row['pending'] }}</td>
                        <td align="center">{{ $row['rejected'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <!-- STANDARD TABLE -->
        <table>
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th width="70">Tanggal</th>
                    <th>Mata Kuliah</th>
                    <th>Pengawas / NIM</th>
                    <th>Prodi</th>
                    <th width="60">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($baps as $index => $bap)
                    <tr>
                        <td align="center">{{ $index + 1 }}</td>
                        <td>{{ $bap->tanggal_ujian->format('d/m/Y') }}<br><small>{{ \Carbon\Carbon::parse($bap->waktu_mulai)->format('H:i') }}</small>
                        </td>
                        <td>
                            <b>{{ $bap->mata_kuliah }}</b><br>
                            <small>Kode: {{ $bap->kode_mk }}</small>
                        </td>
                        <td>
                            {{ $bap->user->name ?? $bap->pengawas_1 }}<br>
                            <small>{{ $bap->user->nip ?? '' }}</small>
                        </td>
                        <td>{{ $bap->prodi->name ?? '-' }}</td>
                        <td>
                            {{ $bap->status }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div style="margin-top: 30px; text-align: right; padding-right: 20px;">
        <p>Dicetak oleh:</p>
        <p style="margin-top: 50px; font-weight: bold;">( {{ auth()->user()->name }} )</p>
    </div>
</body>

</html>