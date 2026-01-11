@extends('layouts.pengawas')
@section('title', 'Riwayat BAP')

@section('content')
  <div class="space-y-6 pb-20">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h1 class="text-xl font-semibold text-slate-800">Riwayat BAP</h1>
        <p class="text-sm text-slate-500 mt-1">Daftar Berita Acara Pengawasan yang telah Anda submit</p>
      </div>
    </div>

    <!-- SEARCH & FILTER -->
    <div class="flex flex-col md:flex-row gap-4">
      <div class="flex-1 relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>
        <input type="text" id="searchInput"
          class="block w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm"
          placeholder="Cari berdasarkan kode atau mata kuliah...">
      </div>

      <div class="flex gap-3">
        <div class="relative">
          <select id="statusFilter"
            class="appearance-none bg-white border border-slate-200 text-slate-700 py-2.5 pl-4 pr-10 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="">Semua Status</option>
            <option value="Berhasil">Berhasil (Approved)</option>
            <option value="Pending">Pending</option>
            <option value="Ditolak">Ditolak</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>

        <div class="relative">
          <select id="periodFilter"
            class="appearance-none bg-white border border-slate-200 text-slate-700 py-2.5 pl-4 pr-10 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="">Semua Periode</option>
            @foreach($baps->unique('tahun_ajaran') as $b)
              <option value="{{ $b->tahun_ajaran }}">{{ $b->tahun_ajaran }}</option>
            @endforeach
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white border rounded-2xl p-6 shadow-sm flex flex-col items-center justify-center text-center">
        <div class="text-3xl font-bold text-slate-800">{{ $baps->count() }}</div>
        <div class="text-sm text-slate-500 mt-1">Total BAP</div>
      </div>
      <div class="bg-white border rounded-2xl p-6 shadow-sm flex flex-col items-center justify-center text-center">
        <div class="text-3xl font-bold text-emerald-600">{{ $baps->where('status', 'APPROVED')->count() }}</div>
        <div class="text-sm text-slate-500 mt-1">Terverifikasi</div>
      </div>
      <div class="bg-white border rounded-2xl p-6 shadow-sm flex flex-col items-center justify-center text-center">
        <div class="text-3xl font-bold text-amber-500">{{ $baps->where('status', 'PENDING')->count() }}</div>
        <div class="text-sm text-slate-500 mt-1">Pending</div>
      </div>
    </div>

    <!-- TABLE -->
    <div class="bg-white border rounded-2xl overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="bg-slate-50 text-slate-900 border-b">
            <tr>
              <th class="px-6 py-4 font-semibold">Nomor BAP</th>
              <th class="px-6 py-4 font-semibold">Tanggal</th>
              <th class="px-6 py-4 font-semibold">Mata Kuliah</th>
              <th class="px-6 py-4 font-semibold">Status</th>
              <th class="px-6 py-4 font-semibold text-right">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100" id="bapTableBody">
            @forelse($baps as $bap)
              @php
                // Mapping Status for Filter logic and Display info
                $displayStatus = 'Pending';
                $badgeClass = 'bg-amber-100 text-amber-800';

                if ($bap->status == 'APPROVED') {
                  $displayStatus = 'Berhasil';
                  $badgeClass = 'bg-emerald-100 text-emerald-700';
                } elseif ($bap->status == 'REJECTED') {
                  $displayStatus = 'Ditolak';
                  $badgeClass = 'bg-red-100 text-red-700';
                } elseif ($bap->status == 'DRAFT') {
                  $displayStatus = 'Draft';
                  $badgeClass = 'bg-slate-100 text-slate-700';
                }
              @endphp
              <tr class="hover:bg-slate-50 transition-colors search-item" data-mk="{{ strtolower($bap->mata_kuliah) }}"
                data-kode="{{ strtolower($bap->kode_mk) }}" data-status="{{ $displayStatus }}"
                data-periode="{{ $bap->tahun_ajaran }}">

                <td class="px-6 py-4 font-medium text-slate-700">
                  BAP-{{ $bap->created_at->format('Y') }}-{{ str_pad($bap->id, 3, '0', STR_PAD_LEFT) }}
                </td>
                <td class="px-6 py-4 text-slate-600">
                  {{ $bap->tanggal_ujian->format('d M Y') }}
                </td>
                <td class="px-6 py-4 font-medium text-slate-800">
                  {{ $bap->mata_kuliah }}
                  @if($bap->status == 'DRAFT') <span class="text-xs text-slate-400 italic ml-2">(Draft)</span> @endif
                </td>
                <td class="px-6 py-4">
                  <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                    {{ $displayStatus }}
                  </span>
                </td>
                <td class="px-6 py-4 text-right">
                  @if($bap->status == 'DRAFT')
                    <a href="{{ route('pengawas.bap.edit', $bap->id) }}"
                      class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-slate-300 rounded-lg text-slate-600 font-medium text-xs hover:bg-slate-50">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                        </path>
                      </svg>
                      Edit
                    </a>
                  @else
                    <a href="{{ route('pengawas.bap.preview', $bap->id) }}"
                      class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-slate-300 rounded-lg text-slate-600 font-medium text-xs hover:bg-slate-50">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                      </svg>
                      View
                    </a>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                  Tidak ada data yang ditemukan.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div id="noResult" class="hidden px-6 py-10 text-center text-slate-500">
        Tidak ada data yang cocok dengan pencarian.
      </div>
      <div class="px-6 py-4 border-t text-xs text-slate-500 flex justify-between items-center">
        <span>Menampilkan <span id="visibleCount">{{ $baps->count() }}</span> dari {{ $baps->count() }} data</span>
        <!-- Pagination could go here if server-side -->
      </div>
    </div>
  </div>

  <script>
    // Realtime Search & Filter Logic
    document.addEventListener('DOMContentLoaded', () => {
      const searchInput = document.getElementById('searchInput');
      const statusFilter = document.getElementById('statusFilter');
      const periodFilter = document.getElementById('periodFilter');
      const tableBody = document.getElementById('bapTableBody');
      const rows = document.querySelectorAll('.search-item');
      const noResult = document.getElementById('noResult');
      const visibleCountSpan = document.getElementById('visibleCount');

      function filterData() {
        const query = searchInput.value.toLowerCase();
        const status = statusFilter.value; // Exact match string from option (e.g. "Berhasil")
        const period = periodFilter.value;

        let visible = 0;

        rows.forEach(row => {
          const mk = row.getAttribute('data-mk');
          const kode = row.getAttribute('data-kode');
          const rowStatus = row.getAttribute('data-status');
          const rowPeriod = row.getAttribute('data-periode');

          const matchesSearch = mk.includes(query) || kode.includes(query);
          const matchesStatus = status === '' || rowStatus === status;
          const matchesPeriod = period === '' || rowPeriod === period;

          if (matchesSearch && matchesStatus && matchesPeriod) {
            row.style.display = '';
            visible++;
          } else {
            row.style.display = 'none';
          }
        });

        if (visible === 0) {
          noResult.classList.remove('hidden');
        } else {
          noResult.classList.add('hidden');
        }
        visibleCountSpan.textContent = visible;
      }

      searchInput.addEventListener('input', filterData);
      statusFilter.addEventListener('change', filterData);
      periodFilter.addEventListener('change', filterData);
    });
  </script>
@endsection