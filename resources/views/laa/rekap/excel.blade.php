<table>
    <thead>
        <tr>
            <th colspan="7" style="font-size: 14px; font-weight: bold; text-align: center;">REKAPITULASI BAP UJIAN</th>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center;">Periode: {{ $periode ?: 'Semua' }} | Prodi: {{ $prodiName }}
            </td>
        </tr>
        <tr></tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000; width: 5">No</th>
            <th style="font-weight: bold; border: 1px solid #000; width: 15">Tanggal</th>
            <th style="font-weight: bold; border: 1px solid #000; width: 10">Jam</th>
            <th style="font-weight: bold; border: 1px solid #000; width: 30">Mata Kuliah</th>
            <th style="font-weight: bold; border: 1px solid #000; width: 15">Kode MK</th>
            <th style="font-weight: bold; border: 1px solid #000; width: 25">Pengawas</th>
            <th style="font-weight: bold; border: 1px solid #000; width: 20">Prodi</th>
            <th style="font-weight: bold; border: 1px solid #000; width: 15">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($baps as $index => $bap)
            <tr>
                <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000;">{{ $bap->tanggal_ujian->format('Y-m-d') }}</td>
                <td style="border: 1px solid #000;">{{ \Carbon\Carbon::parse($bap->waktu_mulai)->format('H:i') }}</td>
                <td style="border: 1px solid #000;">{{ $bap->mata_kuliah }}</td>
                <td style="border: 1px solid #000;">{{ $bap->kode_mk }}</td>
                <td style="border: 1px solid #000;">{{ $bap->user->name ?? $bap->pengawas_1 }}</td>
                <td style="border: 1px solid #000;">{{ $bap->prodi->name ?? '-' }}</td>
                <td style="border: 1px solid #000;">{{ $bap->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>