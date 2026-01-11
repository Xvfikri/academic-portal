```
@extends('layouts.pengawas')
@section('title', 'Preview BAP')

@section('content')
    <div class="w-full pb-20 px-4 md:px-8">
        <div class="flex items-center justify-between mb-6 print:hidden max-w-7xl mx-auto">
            <h1 class="text-xl font-semibold text-slate-800">Preview BAP</h1>
            <div class="flex gap-2">
                <button onclick="window.print()" class="text-sm px-3 py-2 bg-slate-100 rounded-lg text-slate-600 hover:bg-slate-200 font-medium">
                    🖨️ Cetak / PDF
                </button>
                @if($bap->status === 'DRAFT')
                    <a href="{{ route('pengawas.bap.edit', $bap->id) }}"
                        class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center gap-1 px-3 py-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12">
                            </path>
                        </svg>
                        Kembali & Edit
                    </a>
                @endif
            </div>
        </div>

        <!-- STYLE FOR PRINT -->
        <style>
            @media print {
                @page { size: A4; margin: 10mm; }
                body { print-color-adjust: exact; -webkit-print-color-adjust: exact; background: white; }
                .no-print { display: none !important; }
                .page-break { page-break-before: always; }
                /* Reset layout for print to block/stack */
                .print-stack { display: block !important; }
                .paper-sheet { border: none !important; shadow: none !important; margin: 0 !important; width: 100% !important; padding: 0 !important; max-width: none !important; }
            }
            .form-input-line { border-bottom: 1px dotted #000; display: inline-block; padding-left: 5px; min-width: 50px; }
        </style>

        <div class="flex flex-col xl:flex-row gap-8 justify-center items-start print-stack">
            
            <div class="paper-sheet bg-white p-8 md:p-12 mb-10 mx-auto shadow-lg border border-slate-200 text-black font-sans text-sm w-full max-w-[210mm] min-h-[297mm] relative leading-tight shrink-0">
                
                <table class="w-full border border-black mb-6">
                    <tr>
                        <td class="w-[20%] border-r border-black p-4 text-center align-middle">
                            <img src="{{ asset('logobap.png') }}" alt="Logo" class="w-24 mx-auto">
                        </td>
                        <td class="w-[45%] border-r border-black p-2 text-center align-middle">
                            <div class="font-bold uppercase text-sm">Fakultas Rekayasa Industri</div>
                            <div class="text-[10px] mt-1">
                                Jl. Telekomunikasi No. 1 Buahbatu - Bandung 40257<br>
                                Telp: 022-7566454 Fax: 022-7566456
                            </div>
                        </td>
                        <td class="w-[35%] p-2 text-[10px] align-middle">
                            <table class="w-full">
                                <tr><td class="w-24">No. Formulir</td><td>: ITT-AK-REK-NBG-FM-004/00</td></tr>
                                <tr><td>No. Revisi</td><td>: 00</td></tr>
                                <tr><td>Berlaku Efektif</td><td>: 01-Jul-2025</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <div class="text-center mb-8">
                    <h2 class="text-lg font-bold uppercase underline decoration-2 underline-offset-4">Berita Acara Pelaksanaan Ujian</h2>
                    <h3 class="text-md font-bold uppercase mt-1">Fakultas Rekayasa Industri</h3>
                </div>

                <div class="space-y-3 mb-6 px-4">
                    <div class="grid grid-cols-[180px_10px_1fr]">
                        <div>MATA KULIAH</div><div>:</div>
                        <div class="border-b border-dotted border-black uppercase font-medium">{{ $bap->mata_kuliah }}</div>
                    </div>
                    <div class="grid grid-cols-[180px_10px_1fr]">
                        <div>KODE MK</div><div>:</div>
                        <div class="border-b border-dotted border-black uppercase font-medium">{{ $bap->kode_mk }}</div>
                    </div>
                    <div class="grid grid-cols-[180px_10px_1fr]">
                        <div>PROGRAM STUDI</div><div>:</div>
                        <div class="border-b border-dotted border-black uppercase font-medium">{{ $bap->prodi->name ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-[180px_10px_1fr]">
                        <div>RUANG UJIAN</div><div>:</div>
                        <div class="border-b border-dotted border-black uppercase font-medium">{{ $bap->ruang_ujian }}</div>
                    </div>
                    <div class="grid grid-cols-[180px_10px_1fr]">
                        <div>TAHUN AJARAN</div><div>:</div>
                        <div class="border-b border-dotted border-black uppercase font-medium">{{ $bap->tahun_ajaran }}</div>
                    </div>
                    <div class="grid grid-cols-[180px_10px_1fr]">
                        <div>TANGGAL UJIAN</div><div>:</div>
                        <div class="border-b border-dotted border-black uppercase font-medium">{{ $bap->tanggal_ujian->translatedFormat('l, d F Y') }}</div>
                    </div>
                    <div class="grid grid-cols-[180px_10px_1fr]">
                        <div>WAKTU</div><div>:</div>
                        <div class="border-b border-dotted border-black uppercase font-medium">{{ substr($bap->waktu_mulai,0,5) }} - {{ substr($bap->waktu_selesai,0,5) }}</div>
                    </div>
                    
                    <div class="pt-4 grid grid-cols-[280px_10px_1fr_40px]">
                        <div>JUMLAH PESERTA UJIAN (SESUAI DAFTAR HADIR)</div><div>:</div>
                        <div class="border-b border-dotted border-black text-center font-bold">{{ $bap->jumlah_peserta - $bap->jumlah_tidak_hadir }}</div>
                        <div class="pl-2">mhs.</div>
                    </div>
                    <div class="grid grid-cols-[280px_10px_1fr_40px]">
                        <div>JUMLAH YANG TIDAK HADIR</div><div>:</div>
                        <div class="border-b border-dotted border-black text-center font-bold">{{ $bap->jumlah_tidak_hadir }}</div>
                        <div class="pl-2">mhs.</div>
                    </div>
                </div>

                <div class="mb-6 px-4">
                    <div class="mb-2 font-bold">NAMA DAN NIM MAHASISWA YANG TIDAK HADIR:</div>
                    <div class="space-y-2 ml-1">
                        @php 
                            $absents = $bap->absents; 
                            $maxIdx = 5; 
                        @endphp
                        @for($i=0; $i<$maxIdx; $i++)
                            <div class="flex items-center gap-2">
                                <span class="w-4">{{ $i+1 }}.</span>
                                <div class="flex-1 border-b border-dotted border-black h-6">
                                    @if(isset($absents[$i]))
                                        <span class="uppercase font-medium px-2">{{ $absents[$i]->nim }} - {{ $absents[$i]->nama }}</span>
                                    @endif
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="mb-12 px-4">
                    <div class="mb-2 font-bold">PERISTIWA YANG TERJADI:</div>
                    <div class="w-full border border-black rounded p-3 min-h-[100px] text-sm">
                        {{ $bap->catatan_peristiwa ?? 'Tidak ada catatan peristiwa.' }}
                    </div>
                </div>

                <div class="flex justify-between px-10 mt-10">
                    <div class="text-center w-[200px]">
                        <div class="mb-20">PENGAWAS UJIAN 1</div>
                        <div class="font-bold underline">{{ $bap->pengawas_1 }}</div>
                        <div class="text-xs mt-1">NIM: {{ auth()->user()->nip ?? '....................' }}</div>
                    </div>
                    <div class="text-center w-[200px]">
                        <div class="mb-4">Bandung, {{ $bap->tanggal_ujian->translatedFormat('d F Y') }}</div>
                        <div class="mb-16">PENGAWAS UJIAN 2</div>
                        <div class="font-bold underline">{{ $bap->pengawas_2 ?? '........................................' }}</div>
                        <div class="text-xs mt-1">NIM: ....................</div>
                    </div>
                </div>
            </div>

            <div class="hidden print:block page-break"></div>

            <div class="paper-sheet bg-white p-8 md:p-12 mx-auto shadow-lg border border-slate-200 text-black font-sans text-sm w-full max-w-[210mm] min-h-[297mm] relative leading-tight shrink-0">
                
                <table class="w-full border border-black mb-6">
                    <tr>
                        <td class="w-[20%] border-r border-black p-4 text-center align-middle">
                            <img src="{{ asset('logobap.png') }}" alt="Logo" class="w-24 mx-auto">
                        </td>
                        <td class="w-[45%] border-r border-black p-2 text-center align-middle">
                            <div class="font-bold uppercase text-sm">Fakultas Rekayasa Industri</div>
                            <div class="text-[10px] mt-1">
                                FORM DAFTAR HADIR UJIAN<br>
                                Semester {{ str_contains($bap->tahun_ajaran, 'Ganjil') ? 'Ganjil' : 'Genap' }} Tahun {{ preg_replace('/[^0-9\/]/', '', $bap->tahun_ajaran) }}
                            </div>
                        </td>
                        <td class="w-[35%] p-2 text-[10px] align-middle">
                            <table class="w-full">
                                <tr><td class="w-24">No. Formulir</td><td>: ITT-AK-REK-NBG-FM-004/00</td></tr>
                                <tr><td>No. Revisi</td><td>: 00</td></tr>
                                <tr><td>Berlaku Efektif</td><td>: 01-Jul-2025</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <div class="mb-6 px-1 grid grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <div class="grid grid-cols-[100px_10px_1fr]">
                            <div>HARI/TANGGAL</div><div>:</div>
                            <div class="border-b border-dotted border-black font-medium">{{ $bap->tanggal_ujian->translatedFormat('l, d F Y') }}</div>
                        </div>
                        <div class="grid grid-cols-[100px_10px_1fr]">
                            <div>MATA KULIAH</div><div>:</div>
                            <div class="border-b border-dotted border-black font-medium">{{ $bap->mata_kuliah }} ({{ $bap->kode_mk }})</div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="grid grid-cols-[100px_10px_1fr]">
                            <div>KELAS/PRODI</div><div>:</div>
                            <div class="border-b border-dotted border-black font-medium">{{ $bap->prodi->name }}</div>
                        </div>
                        <div class="grid grid-cols-[100px_10px_1fr]">
                            <div>RUANG</div><div>:</div>
                            <div class="border-b border-dotted border-black font-medium">{{ $bap->ruang_ujian }}</div>
                        </div>
                    </div>
                </div>

                <div class="border border-black p-4 mb-8 min-h-[500px] relative">
                    <div class="absolute top-4 right-4 border border-black px-4 py-2 font-bold bg-slate-100">
                        MEJA PENGAWAS
                    </div>

                    <div class="text-center font-bold mb-6 underline">DENAH TEMPAT DUDUK</div>

                    <div class="mt-16 flex flex-wrap gap-4 justify-center">
                        <!-- Generate 40 seats grid default or map from DB -->
                        @php
                            $seats = $bap->seats->pluck('nim', 'seat_number')->toArray();
                            // 5 columns, 8 rows = 40 seats
                        @endphp

                        <div class="grid grid-cols-5 gap-4 w-full px-4">
                            @for($i=1; $i<=40; $i++)
                                <div class="border border-black h-12 flex items-center justify-center text-[10px] relative {{ isset($seats[$i]) ? 'bg-emerald-50' : 'bg-white' }}">
                                    <span class="absolute top-0.5 left-1 text-[8px] text-slate-400">{{ $i }}</span>
                                    @if(isset($seats[$i]))
                                        <span class="font-bold">{{ $seats[$i] }}</span>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="text-center mt-4 text-xs text-slate-500">* Kotak terisi menandakan kursi yang ditempati (NIM)</div>
                </div>

                <div class="flex justify-between px-10 mt-4">
                    <div class="text-center w-[200px]">
                        <div class="mb-20">PENGAWAS UJIAN 1</div>
                        <div class="font-bold underline">{{ $bap->pengawas_1 }}</div>
                    </div>
                    <div class="text-center w-[200px]">
                        <div class="mb-4">Bandung, {{ $bap->tanggal_ujian->translatedFormat('d F Y') }}</div>
                        <div class="mb-20">PENGAWAS UJIAN 2</div>
                        <div class="font-bold underline">{{ $bap->pengawas_2 ?? '........................................' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 left-0 lg:left-72 right-0 bg-white border-t p-4 z-40 flex items-center justify-center gap-4 shadow-[0_-5px_15px_-5px_rgba(0,0,0,0.1)] no-print">
            @if($bap->status === 'DRAFT')
                <a href="{{ route('pengawas.bap.edit', $bap->id) }}"
                    class="px-6 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali & Edit
                </a>
                <button onclick="openModal()"
                    class="px-6 py-2.5 rounded-lg bg-emerald-600 text-white font-medium hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Konfirmasi & Submit
                </button>
            @else
                <a href="{{ route('pengawas.bap.index') }}"
                    class="px-6 py-2.5 rounded-lg bg-emerald-600 text-white font-medium hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-200 flex items-center gap-2">
                    Kembali ke Beranda
                </a>
            @endif
        </div>
    </div>

    <!-- Modal Confirmation -->
    <div id="confirmModal" class="hidden fixed inset-0 z-50 overflow-y-auto w-full h-full bg-black/50 flex items-center justify-center no-print">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl relative">
            <h3 class="text-lg font-bold text-slate-800 mb-2">Konfirmasi Submit BAP</h3>
            <p class="text-slate-600 text-sm mb-6">Apakah Anda yakin semua data sudah benar? Data tidak dapat diubah setelah disubmit.</p>
            
            <div class="flex gap-3 justify-end">
                <button onclick="closeModal()" type="button" class="px-4 py-2 border rounded-lg text-slate-600 hover:bg-slate-50">Batal</button>
                <form action="{{ route('pengawas.bap.submit', $bap->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-medium">Ya, Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
    </script>
@endsection
```