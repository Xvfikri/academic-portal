@extends('layouts.laa')
@section('title', 'Rekapitulasi')

@section('content')
  <!-- Card Wrapper -->
  <div class="bg-white border rounded-2xl p-6 min-h-[85vh]">
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-xl font-semibold text-slate-800">Rekapitulasi & Export Data</h1>
      <p class="text-sm text-slate-500 mt-1">Generate dan export laporan BAP</p>
    </div>

    <!-- Filter Form -->
    <form action="{{ route('laa.rekap.index') }}" method="GET" class="mb-8">
      <div class="mb-5">
        <h2 class="text-lg font-semibold text-emerald-700">Filter Rekapitulasi</h2>
        <div class="mt-2 h-px bg-slate-200"></div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Periode Ujian -->
        <div>
          <label class="text-sm font-semibold text-slate-700">Periode Ujian</label>
          <div class="mt-2 relative">
            <select name="periode"
              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-10 outline-none focus:ring-2 focus:ring-emerald-300">
              <option value="">Semua Periode</option>
              @foreach($periodes as $p)
                <option value="{{ $p }}" {{ $periode == $p ? 'selected' : '' }}>{{ $p }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Program Studi -->
        <div>
          <label class="text-sm font-semibold text-slate-700">Program Studi</label>
          <div class="mt-2 relative">
            <select name="prodi_id"
              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-10 outline-none focus:ring-2 focus:ring-emerald-300">
              <option value="">Semua Program Studi</option>
              @foreach($prodis as $prod)
                <option value="{{ $prod->id }}" {{ $prodiId == $prod->id ? 'selected' : '' }}>{{ $prod->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Jenis Rekapitulasi -->
        <div>
          <label class="text-sm font-semibold text-slate-700">Jenis Rekapitulasi</label>
          <div class="mt-2 relative">
            <select name="jenis"
              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-10 outline-none focus:ring-2 focus:ring-emerald-300">
              <option value="summary" {{ $jenis == 'summary' ? 'selected' : '' }}>Summary (Ringkasan)</option>
              <option value="detail" {{ $jenis == 'detail' ? 'selected' : '' }}>Detail per BAP</option>
              <option value="per_pengawas" {{ $jenis == 'per_pengawas' ? 'selected' : '' }}>Per Pengawas</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="mt-6">
        <button type="submit"
          class="px-6 py-3 rounded-xl bg-emerald-700 text-white font-semibold hover:bg-emerald-800 shadow-lg shadow-emerald-200 transition-all active:scale-95">
          Generate Rekapitulasi
        </button>
      </div>
    </form>

    <!-- RESULT SECTION -->
    <div class="mt-10">
      <h2 class="text-lg font-semibold text-emerald-700">Hasil Rekapitulasi</h2>
      <div class="mt-2 h-px bg-slate-200 mb-6"></div>

      @if(is_null($baps))
        <!-- INITIAL STATE (No Filter Selected) -->
        <div
          class="border rounded-2xl p-10 min-h-[300px] flex flex-col items-center justify-center text-center bg-white border-slate-200">
          <div class="text-slate-400 mb-4">
            <svg class="w-16 h-16 mx-auto opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
          </div>
          <p class="text-slate-500 max-w-sm">
            Silakan pilih filter dan klik <span class="font-medium text-slate-700">"Generate Rekapitulasi"</span> untuk
            melihat hasil
          </p>
        </div>

      @elseif($baps->isEmpty())
        <!-- EMPTY STATE (No Data Found for Filter) -->
        <div
          class="border rounded-2xl p-10 flex flex-col items-center justify-center text-center bg-slate-50 border-dashed border-slate-300 min-h-[300px]">
          <div class="text-slate-400 mb-4">
            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
          </div>
          <p class="text-slate-600 font-medium">Tidak ada data ditemukan untuk filter ini.</p>
        </div>

      @else
        <!-- DATA RESULTS -->

        <!-- SUMMARY VIEW / STATS -->
        @if($jenis != 'detail')
          <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white border p-6 rounded-2xl shadow-sm">
              <div class="text-sm text-slate-500">Total BAP</div>
              <div class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-white border p-6 rounded-2xl shadow-sm">
              <div class="text-sm text-slate-500">Terverifikasi</div>
              <div class="text-3xl font-bold text-emerald-600 mt-2">{{ $stats['verified'] }}</div>
            </div>
            <div class="bg-white border p-6 rounded-2xl shadow-sm">
              <div class="text-sm text-slate-500">Pending</div>
              <div class="text-3xl font-bold text-amber-500 mt-2">{{ $stats['pending'] }}</div>
            </div>
            <div class="bg-white border p-6 rounded-2xl shadow-sm">
              <div class="text-sm text-slate-500">Ditolak</div>
              <div class="text-3xl font-bold text-red-500 mt-2">{{ $stats['rejected'] }}</div>
            </div>
          </div>
        @endif

        <!-- EXPORT ACTIONS -->
        <div class="flex gap-3 mb-6">
          <a href="{{ route('laa.rekap.export', array_merge(request()->all(), ['type' => 'pdf'])) }}" target="_blank"
            class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
              </path>
            </svg>
            Export PDF
          </a>
          <a href="{{ route('laa.rekap.export', array_merge(request()->all(), ['type' => 'excel'])) }}" target="_blank"
            class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            Export Excel
          </a>
        </div>

        @if($jenis == 'per_pengawas')
          <!-- TABLE: PER PENGAWAS -->
          <div class="bg-white border rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
              <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-900 border-b font-semibold">
                  <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Nama Pengawas</th>
                    <th class="px-6 py-4">NIM</th>
                    <th class="px-6 py-4 text-center">Total BAP</th>
                    <th class="px-6 py-4 text-center text-emerald-600">Terverifikasi</th>
                    <th class="px-6 py-4 text-center text-amber-600">Pending</th>
                    <th class="px-6 py-4 text-center text-red-600">Ditolak</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                  @foreach($perPengawas as $idx => $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                      <td class="px-6 py-4">{{ $idx + 1 }}</td>
                      <td class="px-6 py-4 font-medium text-slate-800">{{ $row['name'] }}</td>
                      <td class="px-6 py-4 text-slate-600">{{ $row['nip'] }}</td>
                      <td class="px-6 py-4 text-center font-bold">{{ $row['total'] }}</td>
                      <td class="px-6 py-4 text-center font-bold text-emerald-600">{{ $row['approved'] }}</td>
                      <td class="px-6 py-4 text-center font-bold text-amber-600">{{ $row['pending'] }}</td>
                      <td class="px-6 py-4 text-center font-bold text-red-600">{{ $row['rejected'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @else
          <!-- TABLE: DETAIL / SUMMARY (DEFAULT BAP LIST) -->
          <div class="bg-white border rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
              <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-900 border-b font-semibold">
                  <tr>
                    <th class="px-6 py-4">Kode BAP</th>
                    <th class="px-6 py-4">Mata Kuliah</th>
                    <th class="px-6 py-4">Pengawas</th>
                    <th class="px-6 py-4">Prodi</th>
                    <th class="px-6 py-4">Status</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                  @foreach($baps as $bap)
                    <tr class="hover:bg-slate-50 transition-colors">
                      <td class="px-6 py-4 font-medium text-slate-700">
                        BAP-{{ str_pad($bap->id, 3, '0', STR_PAD_LEFT) }}
                      </td>
                      <td class="px-6 py-4 text-slate-600">
                        <div class="font-medium text-slate-800">{{ $bap->mata_kuliah }}</div>
                        <div class="text-xs">{{ $bap->kode_mk }} • {{ $bap->tanggal_ujian->format('d M Y') }}</div>
                      </td>
                      <td class="px-6 py-4 text-slate-600">
                        {{ $bap->user->name ?? $bap->pengawas_1 }}
                      </td>
                      <td class="px-6 py-4 text-slate-600">
                        {{ $bap->prodi->name ?? '-' }}
                      </td>
                      <td class="px-6 py-4">
                        @if($bap->status == 'APPROVED')
                          <span
                            class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-xs font-semibold">Terverifikasi</span>
                        @elseif($bap->status == 'PENDING')
                          <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded text-xs font-semibold">Pending</span>
                        @elseif($bap->status == 'REJECTED')
                          <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">Ditolak</span>
                        @else
                          <span
                            class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-semibold">{{ $bap->status }}</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            @if($baps->count() > 10)
              <div class="px-6 py-4 border-t text-xs text-slate-500 text-center uppercase tracking-wide">
                ... dan {{ $baps->count() - 10 }} data lainnya (Gunakan Export untuk data lengkap)
              </div>
            @endif
          </div>
        @endif
      @endif

    </div>
  </div>
@endsection