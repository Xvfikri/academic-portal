@extends('layouts.pengawas')
@section('title', 'Riwayat BAP')

@section('content')

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-semibold text-slate-800">Riwayat BAP</h1>
      <p class="text-sm text-slate-500 mt-1">
        Daftar Berita Acara Pelaksanaan yang telah Anda input.
      </p>
    </div>
  </div>

  <!-- Filter -->
  <div class="bg-white border rounded-xl p-4 mb-5">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
      <div class="md:col-span-4">
        <label class="text-xs text-slate-600">Cari</label>
        <input id="searchInput" type="text" placeholder="Cari mata kuliah / kelas / tanggal..."
          class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 focus:ring-emerald-300">
      </div>

      <div class="md:col-span-3">
        <label class="text-xs text-slate-600">Status</label>
        <select id="statusFilter" class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
          <option value="ALL">Semua</option>
          <option value="PENDING">Pending</option>
          <option value="APPROVED">Disetujui</option>
          <option value="REJECTED">Ditolak</option>
        </select>
      </div>

      <div class="md:col-span-3">
        <label class="text-xs text-slate-600">Tanggal</label>
        <input id="dateFilter" type="date" class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
      </div>

      <div class="md:col-span-2 flex items-end">
        <button id="btnReset" class="w-full px-4 py-2.5 rounded-lg border text-sm hover:bg-slate-50">
          Reset
        </button>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="bg-white border rounded-xl overflow-hidden">
    <div class="px-5 py-4 border-b flex justify-between items-center">
      <div class="font-semibold text-slate-800">Daftar BAP</div>
      <div class="text-xs text-slate-400">Dummy Data</div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="px-5 py-3 text-left">Tanggal</th>
            <th class="px-5 py-3 text-left">Mata Kuliah</th>
            <th class="px-5 py-3 text-left">Kelas</th>
            <th class="px-5 py-3 text-left">Status</th>
            <th class="px-5 py-3 text-right">Aksi</th>
          </tr>
        </thead>

        <tbody id="rows" class="divide-y">
          @php
            $baps = [
              ['id' => 1, 'tgl' => '2026-01-03', 'mk' => 'Algoritma & Pemrograman', 'kelas' => 'IF-45-01', 'status' => 'PENDING'],
              ['id' => 2, 'tgl' => '2026-01-02', 'mk' => 'Basis Data', 'kelas' => 'SI-45-02', 'status' => 'APPROVED'],
              ['id' => 3, 'tgl' => '2026-01-01', 'mk' => 'Jaringan Komputer', 'kelas' => 'IF-45-03', 'status' => 'REJECTED'],
            ];
          @endphp

          @foreach($baps as $b)
            <tr class="row" data-status="{{ $b['status'] }}"
              data-text="{{ strtolower($b['mk'] . ' ' . $b['kelas'] . ' ' . $b['tgl']) }}">
              <td class="px-5 py-4">{{ $b['tgl'] }}</td>
              <td class="px-5 py-4 font-medium text-slate-800">
                {{ $b['mk'] }}
                <div class="text-xs text-slate-500">ID BAP: #{{ $b['id'] }}</div>
              </td>
              <td class="px-5 py-4">{{ $b['kelas'] }}</td>

              <!-- STATUS -->
              <td class="px-5 py-4">
                @if($b['status'] == 'APPROVED')
                  <span class="px-3 py-1 rounded-full text-xs bg-emerald-100 text-emerald-700">Disetujui</span>
                @elseif($b['status'] == 'REJECTED')
                  <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">Ditolak</span>
                @else
                  <span class="px-3 py-1 rounded-full text-xs bg-amber-100 text-amber-800">Pending</span>
                @endif
              </td>

              <!-- AKSI -->
              <td class="px-5 py-4 text-right space-x-3">
                <button class="text-blue-600 hover:underline text-xs">Detail</button>
                <button class="text-slate-700 hover:underline text-xs">Preview</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <script>
    const rows = document.querySelectorAll('.row');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const btnReset = document.getElementById('btnReset');

    function applyFilter() {
      const q = searchInput.value.toLowerCase();
      const st = statusFilter.value;
      const dt = dateFilter.value;

      rows.forEach(r => {
        const matchQ = !q || r.dataset.text.includes(q);
        const matchS = st === 'ALL' || r.dataset.status === st;
        const matchD = !dt || r.dataset.text.includes(dt);
        r.classList.toggle('hidden', !(matchQ && matchS && matchD));
      });
    }

    searchInput.oninput = applyFilter;
    statusFilter.onchange = applyFilter;
    dateFilter.onchange = applyFilter;
    btnReset.onclick = () => {
      searchInput.value = '';
      statusFilter.value = 'ALL';
      dateFilter.value = '';
      applyFilter();
    };
  </script>

@endsection