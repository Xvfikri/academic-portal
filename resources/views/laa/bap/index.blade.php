@extends('layouts.laa')
@section('title', 'Manajemen BAP')

@section('content')
  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-semibold text-slate-800">Manajemen BAP</h1>
      <p class="text-sm text-slate-500 mt-1">
        Kelola Berita Acara Pelaksanaan (BAP): verifikasi, tolak, dan pantau status.
      </p>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-5 px-4 py-3 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
      {{ session('success') }}
    </div>
  @endif

  <!-- Summary Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-5">
    <div class="bg-white border rounded-xl p-5">
      <div class="text-sm text-slate-500">Total BAP</div>
      <div class="text-3xl font-semibold text-slate-800 mt-2">{{ $baps->count() }}</div>
      <div class="text-xs text-slate-400 mt-1">Semua masuk</div>
    </div>
    <div class="bg-white border rounded-xl p-5">
      <div class="text-sm text-slate-500">Terverifikasi</div>
      <div class="text-3xl font-semibold text-slate-800 mt-2">{{ $baps->where('status', 'APPROVED')->count() }}</div>
      <div class="text-xs text-slate-400 mt-1">Siap direkap</div>
    </div>
    <div class="bg-white border rounded-xl p-5">
      <div class="text-sm text-slate-500">Menunggu Verifikasi</div>
      <div class="text-3xl font-semibold text-slate-800 mt-2">{{ $baps->where('status', 'PENDING')->count() }}</div>
      <div class="text-xs text-slate-400 mt-1">Butuh tindakan LAA</div>
    </div>
    <div class="bg-white border rounded-xl p-5">
      <div class="text-sm text-slate-500">Ditolak</div>
      <div class="text-3xl font-semibold text-slate-800 mt-2">{{ $baps->where('status', 'REJECTED')->count() }}</div>
      <div class="text-xs text-slate-400 mt-1">Perlu revisi</div>
    </div>
  </div>

  <!-- Filter + Search -->
  <div class="bg-white border rounded-xl p-4 mb-4">
    <form action="{{ route('laa.bap.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3">
      <div class="md:col-span-4">
        <label class="text-xs text-slate-600">Cari BAP</label>
        <div class="mt-1 relative">
          <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">🔎</span>
          <input name="q" value="{{ request('q') }}" type="text" placeholder="Cari matkul / pengawas / kode MK..."
            class="w-full rounded-lg border border-slate-200 bg-slate-50 pl-9 pr-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
        </div>
      </div>

      <div class="md:col-span-2">
        <label class="text-xs text-slate-600">Status</label>
        <select name="status"
          class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
          <option value="ALL">Semua</option>
          <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>Pending</option>
          <option value="APPROVED" {{ request('status') === 'APPROVED' ? 'selected' : '' }}>Terverifikasi</option>
          <option value="REJECTED" {{ request('status') === 'REJECTED' ? 'selected' : '' }}>Ditolak</option>
        </select>
      </div>

      <div class="md:col-span-3">
        <label class="text-xs text-slate-600">Tahun Ajaran</label>
        <select name="ta"
          class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
          <option value="">Semua</option>
          <option value="2025/2026 Ganjil">2025/2026 Ganjil</option>
          <option value="2025/2026 Genap">2025/2026 Genap</option>
        </select>
      </div>

      <div class="md:col-span-2">
        <label class="text-xs text-slate-600">Dari Tanggal</label>
        <input name="date_from" value="{{ request('date_from') }}" type="date"
          class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
      </div>

      <div class="md:col-span-1 flex items-end">
        <button type="submit"
          class="w-full px-4 py-2.5 rounded-lg bg-emerald-700 text-white text-sm font-medium hover:bg-emerald-800">
          Filter
        </button>
      </div>
    </form>
  </div>

  <!-- Table -->
  <div class="bg-white border rounded-xl overflow-hidden">
    <div class="px-5 py-4 border-b flex items-center justify-between">
      <div>
        <div class="font-semibold text-slate-800">Daftar BAP</div>
      </div>
      <div class="text-xs text-slate-400">Terakhir update: {{ now()->format('d M Y, H:i') }}</div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm table-fixed">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="px-5 py-3 text-left w-[120px]">Tanggal</th>
            <th class="px-5 py-3 text-left w-[300px]">Mata Kuliah</th>
            <th class="px-5 py-3 text-left w-[120px]">Ruang</th>
            <th class="px-5 py-3 text-left w-[200px]">Pengawas 1</th>
            <th class="px-5 py-3 text-left w-[150px]">Status</th>
            <th class="px-5 py-3 text-right w-[250px]">Aksi</th>
          </tr>
        </thead>

        <tbody id="rows" class="divide-y">
          @forelse($baps as $b)
            <tr class="row" data-id="{{ $b->id }}" data-tanggal="{{ $b->tanggal_ujian->format('d M Y') }}"
              data-matkul="{{ $b->mata_kuliah }}" data-kode="{{ $b->kode_mk }}" data-ruang="{{ $b->ruang_ujian }}"
              data-pengawas="{{ $b->pengawas_1 }}" data-pengawas2="{{ $b->pengawas_2 }}" data-status="{{ $b->status }}"
              data-note="{{ $b->catatan_admin }}">
              <td class="px-5 py-4 text-slate-700 break-words">{{ $b->tanggal_ujian->format('d/m/Y') }}</td>

              <td class="px-5 py-4">
                <div class="font-medium text-slate-800 leading-snug">{{ $b->mata_kuliah }}</div>
                <div class="text-xs text-slate-500 mt-1">{{ $b->kode_mk }}</div>
              </td>

              <td class="px-5 py-4 text-slate-700">{{ $b->ruang_ujian }}</td>
              <td class="px-5 py-4 text-slate-700">{{ $b->pengawas_1 }}</td>

              <!-- STATUS -->
              <td class="px-5 py-4">
                @php
                  $badge = [
                    'PENDING' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800',
                    'APPROVED' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700',
                    'REJECTED' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700',
                  ];
                  $label = [
                    'PENDING' => 'Pending',
                    'APPROVED' => 'Terverifikasi',
                    'REJECTED' => 'Ditolak',
                  ];
                @endphp
                <span class="{{ $badge[$b->status] ?? $badge['PENDING'] }}">
                  {{ $label[$b->status] ?? $b->status }}
                </span>
              </td>

              <!-- AKSI -->
              <td class="px-5 py-4">
                <div class="flex justify-end gap-2 flex-wrap">

                  <a href="{{ route('laa.bap.preview', $b->id) }}"
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                                    border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-xs font-semibold">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                      <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z" />
                      <circle cx="12" cy="12" r="3" stroke-width="2" />
                    </svg>
                    Detail
                  </a>

                  @if($b->status === 'PENDING')
                    <form action="{{ route('laa.bap.verify', $b->id) }}" method="POST"
                      onsubmit="return confirm('Verifikasi BAP ini?')">
                      @csrf
                      <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                                                  bg-emerald-700 text-white hover:bg-emerald-800 text-xs font-semibold">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                          <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5" />
                        </svg>
                        Verify
                      </button>
                    </form>

                    <button class="btnReject inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                                              bg-red-100 text-red-700 hover:bg-red-200 text-xs font-semibold"
                      data-id="{{ $b->id }}">
                      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M18 6L6 18M6 6l12 12" />
                      </svg>
                      Tolak
                    </button>
                  @endif

                  @if($b->lampiran)
                    <a href="{{ Storage::url($b->lampiran) }}" target="_blank"
                      class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                                            border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-xs font-semibold">
                      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M7 10l5 5 5-5" />
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 15V3" />
                      </svg>
                      Lampiran
                    </a>
                  @endif

                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-5 py-8 text-center text-slate-500 italic">Belum ada data BAP.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- MODAL DETAIL -->
  <div id="modalDetail" class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4 z-[99]">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl border overflow-hidden">
      <div class="px-6 py-4 border-b flex items-center justify-between">
        <div class="font-semibold text-slate-800">Detail BAP</div>
        <button class="closeModal text-slate-500 hover:text-slate-800">✕</button>
      </div>

      <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="bg-slate-50 border rounded-xl p-4">
            <div class="text-xs text-slate-500">ID BAP</div>
            <div id="dId" class="text-lg font-semibold text-slate-800">-</div>
          </div>
          <div class="bg-slate-50 border rounded-xl p-4">
            <div class="text-xs text-slate-500">Status</div>
            <div id="dStatus" class="text-lg font-semibold text-slate-800">-</div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <div class="text-xs text-slate-600">Tanggal</div>
            <div id="dTanggal" class="font-medium text-slate-800">-</div>
          </div>
          <div>
            <div class="text-xs text-slate-600">Ruang</div>
            <div id="dRuang" class="font-medium text-slate-800">-</div>
          </div>
          <div>
            <div class="text-xs text-slate-600">Mata Kuliah</div>
            <div id="dMatkul" class="font-medium text-slate-800">-</div>
          </div>
          <div>
            <div class="text-xs text-slate-600">Kode MK</div>
            <div id="dKode" class="font-medium text-slate-800">-</div>
          </div>
          <div>
            <div class="text-xs text-slate-600">Pengawas 1</div>
            <div id="dPengawas" class="font-medium text-slate-800">-</div>
          </div>
          <div>
            <div class="text-xs text-slate-600">Pengawas 2</div>
            <div id="dPengawas2" class="font-medium text-slate-800">-</div>
          </div>
        </div>

        <div>
          <div class="text-xs text-slate-600">Catatan Admin (Alasan Penolakan)</div>
          <div id="dNote" class="mt-1 bg-slate-50 border rounded-xl p-4 text-slate-700 min-h-[50px]">-</div>
        </div>
      </div>

      <div class="px-6 py-4 border-t flex justify-end gap-2">
        <button
          class="closeModal px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 text-sm hover:bg-slate-50">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <!-- MODAL REJECT -->
  <div id="modalReject" class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4 z-[99]">
    <form id="formReject" action="" method="POST"
      class="w-full max-w-lg bg-white rounded-2xl shadow-xl border overflow-hidden">
      @csrf
      <div class="px-6 py-4 border-b flex items-center justify-between">
        <div class="font-semibold text-red-600">Tolak BAP</div>
        <button type="button" class="closeModalReject text-slate-500 hover:text-slate-800">✕</button>
      </div>

      <div class="p-6 space-y-4">
        <p class="text-sm text-slate-600">Apakah Anda yakin ingin menolak BAP ini? Mohon berikan alasan penolakan agar
          pengawas dapat memperbaikinya.</p>
        <div>
          <label class="text-xs font-semibold text-slate-700">Alasan Penolakan <span class="text-red-500">*</span></label>
          <textarea name="reason" rows="3" required placeholder="Contoh: Lampiran buram, mohon upload ulang..."
            class="mt-1 w-full rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-red-200"></textarea>
        </div>
      </div>

      <div class="px-6 py-4 border-t flex justify-end gap-2">
        <button type="button"
          class="closeModalReject px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 text-sm hover:bg-slate-50">
          Batal
        </button>
        <button type="submit" class="px-4 py-2.5 rounded-lg bg-red-600 text-white text-sm font-medium hover:bg-red-700">
          Tolak BAP
        </button>
      </div>
    </form>
  </div>

  <script>
    // ===== Modal helper
    const modalDetail = document.getElementById('modalDetail');
    const modalReject = document.getElementById('modalReject');
    const formReject = document.getElementById('formReject');

    function openModal(el) { el.classList.remove('hidden'); el.classList.add('flex'); }
    function closeModal(el) { el.classList.add('hidden'); el.classList.remove('flex'); }

    // Click listeners
    document.querySelectorAll('.closeModal').forEach(btn => btn.addEventListener('click', () => closeModal(modalDetail)));
    document.querySelectorAll('.closeModalReject').forEach(btn => btn.addEventListener('click', () => closeModal(modalReject)));

    [modalDetail, modalReject].forEach(m => {
      m.addEventListener('click', (e) => {
        if (e.target === m) closeModal(m);
      });
    });

    // ===== Detail fill
    const dId = document.getElementById('dId');
    const dStatus = document.getElementById('dStatus');
    const dTanggal = document.getElementById('dTanggal');
    const dRuang = document.getElementById('dRuang');
    const dMatkul = document.getElementById('dMatkul');
    const dKode = document.getElementById('dKode');
    const dPengawas = document.getElementById('dPengawas');
    const dPengawas2 = document.getElementById('dPengawas2');
    const dNote = document.getElementById('dNote');

    document.querySelectorAll('.btnDetail').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const tr = e.target.closest('.row');
        dId.textContent = '#' + tr.dataset.id;
        dTanggal.textContent = tr.dataset.tanggal;
        dRuang.textContent = tr.dataset.ruang;
        dMatkul.textContent = tr.dataset.matkul;
        dKode.textContent = tr.dataset.kode;
        dPengawas.textContent = tr.dataset.pengawas;
        dPengawas2.textContent = tr.dataset.pengawas2 || '-';
        dNote.textContent = tr.dataset.note || '-';

        const st = tr.dataset.status;
        dStatus.textContent =
          st === 'APPROVED' ? 'Terverifikasi' : st === 'REJECTED' ? 'Ditolak' : 'Pending';

        // Colors
        dStatus.className = "text-lg font-semibold " +
          (st === 'APPROVED' ? 'text-emerald-700' : st === 'REJECTED' ? 'text-red-700' : 'text-amber-600');

        openModal(modalDetail);
      });
    });

    // ===== Reject Modal
    document.querySelectorAll('.btnReject').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = e.currentTarget.dataset.id; // use currentTarget because of SVG inside button
        formReject.action = `/laa/bap/${id}/reject`;
        openModal(modalReject);
      });
    });

  </script>
@endsection