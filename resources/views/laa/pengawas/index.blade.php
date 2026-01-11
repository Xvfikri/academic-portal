@extends('layouts.laa')
@section('title','Manajemen Pengawas')

@section('content')
  <!-- Header + Actions -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-semibold text-slate-800">Manajemen Pengawas</h1>
      <p class="text-sm text-slate-500 mt-1">
        Kelola akun pengawas: tambah, edit, aktif/nonaktif, dan reset password.
      </p>
    </div>

    <div class="flex gap-2">
      <button id="btnOpenCreate"
        class="px-4 py-2.5 rounded-lg bg-emerald-700 text-white text-sm font-medium hover:bg-emerald-800">
        + Tambah Pengawas
      </button>
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
        <div class="text-sm text-slate-500">Total Pengawas</div>
        <div class="text-3xl font-semibold text-slate-800 mt-2">{{ $pengawas->count() }}</div>
        <div class="text-xs text-slate-400 mt-1">Terdaftar di sistem</div>
      </div>
      <div class="bg-white border rounded-xl p-5">
        <div class="text-sm text-slate-500">Akun Aktif</div>
        <div class="text-3xl font-semibold text-slate-800 mt-2">{{ $pengawas->where('status', 'AKTIF')->count() }}</div>
        <div class="text-xs text-slate-400 mt-1">Bisa login & input BAP</div>
      </div>
      <div class="bg-white border rounded-xl p-5">
        <div class="text-sm text-slate-500">Akun Nonaktif</div>
        <div class="text-3xl font-semibold text-slate-800 mt-2">{{ $pengawas->where('status', 'NONAKTIF')->count() }}</div>
        <div class="text-xs text-slate-400 mt-1">Tidak dapat login</div>
      </div>
      <div class="bg-white border rounded-xl p-5">
        <div class="text-sm text-slate-500">Program Studi</div>
        <div class="text-3xl font-semibold text-slate-800 mt-2">{{ $prodis->count() }}</div>
        <div class="text-xs text-slate-400 mt-1">Terdaftar</div>
      </div>
  </div>

  <!-- Filter + Search -->
  <div class="bg-white border rounded-xl p-4 mb-4">
    <form action="{{ route('laa.pengawas.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3">
      <div class="md:col-span-4">
        <label class="text-xs text-slate-600">Cari Pengawas</label>
        <div class="mt-1 relative">
          <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">🔎</span>
          <input name="q" value="{{ request('q') }}" type="text" placeholder="Cari nama / NIM / email..."
            class="w-full rounded-lg border border-slate-200 bg-slate-50 pl-9 pr-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
        </div>
      </div>

      <!-- FILTER PRODI -->
      <div class="md:col-span-3">
        <label class="text-xs text-slate-600">Program Studi</label>
        <select name="prodi"
          class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
          <option value="ALL">Semua Prodi</option>
          @foreach($prodis as $p)
            <option value="{{ $p->id }}" {{ request('prodi') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="md:col-span-3">
        <label class="text-xs text-slate-600">Status Akun</label>
        <select name="status"
          class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
          <option value="ALL">Semua</option>
          <option value="AKTIF" {{ request('status') === 'AKTIF' ? 'selected' : '' }}>Aktif</option>
          <option value="NONAKTIF" {{ request('status') === 'NONAKTIF' ? 'selected' : '' }}>Nonaktif</option>
        </select>
      </div>

      <div class="md:col-span-2 flex items-end gap-2">
        <button type="submit"
          class="w-full px-4 py-2.5 rounded-lg bg-emerald-700 text-white text-sm font-medium hover:bg-emerald-800">
          Filter
        </button>
        <a href="{{ route('laa.pengawas.index') }}"
          class="w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 text-sm text-center hover:bg-slate-50">
          Reset
        </a>
      </div>
    </form>

    <div class="mt-3 text-xs text-slate-500 flex justify-end gap-6">
      <div>Total: <span class="font-semibold text-slate-700">{{ $pengawas->count() }}</span></div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white border rounded-xl overflow-hidden">
    <div class="px-5 py-4 border-b flex items-center justify-between">
      <div>
        <div class="font-semibold text-slate-800">Daftar Pengawas</div>
      </div>

      <div class="text-xs text-slate-400">
        Terakhir update: {{ now()->format('d M Y, H:i') }}
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="px-5 py-3 text-left">Pengawas</th>
            <th class="px-5 py-3 text-left">Program Studi</th>
            <th class="px-5 py-3 text-left">NIM</th>
            <th class="px-5 py-3 text-left">Email</th>
            <th class="px-5 py-3 text-left">Status</th>
            <th class="px-5 py-3 text-left">Terakhir Login</th>
            <th class="px-5 py-3 text-right">Aksi</th>
          </tr>
        </thead>

        <tbody id="rows" class="divide-y">
          @forelse($pengawas as $p)
            <tr class="row"
                data-id="{{ $p->id }}"
                data-nama="{{ $p->name }}"
                data-prodi="{{ $p->prodi_id }}"
                data-nim="{{ $p->nip }}"
                data-email="{{ $p->email }}"
                data-status="{{ $p->status }}">
              <td class="px-5 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-semibold">
                    {{ strtoupper(substr($p->name,0,1)) }}
                  </div>
                  <div>
                    <div class="font-medium text-slate-800">{{ $p->name }}</div>
                    <div class="text-xs text-slate-500">Role: Pengawas</div>
                  </div>
                </div>
              </td>

              <td class="px-5 py-4 text-slate-700">
                {{ $p->prodi->name ?? '-' }}
              </td>

              <td class="px-5 py-4 text-slate-700">{{ $p->nip }}</td>
              <td class="px-5 py-4 text-slate-700">{{ $p->email }}</td>

              <td class="px-5 py-4">
                @if($p->status === 'AKTIF')
                  <span class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Aktif</span>
                @else
                  <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Nonaktif</span>
                @endif
              </td>

              <td class="px-5 py-4 text-slate-500">{{ $p->last_login_at ? $p->last_login_at->format('d/m/Y H:i') : '-' }}</td>

              <td class="px-5 py-4 text-right whitespace-nowrap">
                <div class="flex justify-end gap-3 rotate-actions">
                    <button class="btnEdit text-blue-600 hover:underline">Edit</button>
                    
                    <form action="{{ route('laa.pengawas.resetPassword', $p->id) }}" method="POST" onsubmit="return confirm('Reset password ke default (password123)?')">
                        @csrf
                        <button type="submit" class="text-amber-600 hover:underline">Reset Password</button>
                    </form>

                    <form action="{{ route('laa.pengawas.toggle', $p->id) }}" method="POST">
                        @csrf
                        @if($p->status === 'AKTIF')
                          <button type="submit" class="text-red-600 hover:underline">Nonaktifkan</button>
                        @else
                          <button type="submit" class="text-emerald-700 hover:underline">Aktifkan</button>
                        @endif
                    </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
                <td colspan="7" class="px-5 py-10 text-center text-slate-500 italic">Data pengawas tidak ditemukan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- MODAL: Tambah -->
  <div id="modalCreate" class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4 z-[99]">
    <form action="{{ route('laa.pengawas.store') }}" method="POST" class="w-full max-w-xl bg-white rounded-2xl shadow-xl border overflow-hidden">
      @csrf
      <div class="px-6 py-4 border-b flex items-center justify-between">
        <div class="font-semibold text-slate-800">Tambah Pengawas</div>
        <button type="button" class="closeModal text-slate-500 hover:text-slate-800">✕</button>
      </div>

      <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <div>
            <label class="text-xs text-slate-600">Nama</label>
            <input name="name" type="text" placeholder="Nama pengawas" required
              class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
          </div>
          <div>
            <label class="text-xs text-slate-600">NIM (Username)</label>
            <input name="nip" type="text" placeholder="130121xxxx" required
              class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
          </div>
        </div>

        <div>
          <label class="text-xs text-slate-600">Email</label>
          <input name="email" type="email" placeholder="email@telu.ac.id" required
            class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
        </div>

        <div>
          <label class="text-xs text-slate-600">Program Studi</label>
          <select name="prodi_id" required class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
            @foreach($prodis as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <div>
            <label class="text-xs text-slate-600">Password Awal</label>
            <input type="text" value="password123" readonly
              class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-500 cursor-not-allowed">
            <div class="text-xs text-slate-400 mt-1">Default password untuk akun baru.</div>
          </div>

          <div>
            <label class="text-xs text-slate-600">Status</label>
            <select name="status" class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
              <option value="AKTIF">Aktif</option>
              <option value="NONAKTIF">Nonaktif</option>
            </select>
          </div>
        </div>
      </div>

      <div class="px-6 py-4 border-t flex justify-end gap-2">
        <button type="button" class="closeModal px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 text-sm hover:bg-slate-50">
          Batal
        </button>
        <button type="submit" class="px-4 py-2.5 rounded-lg bg-emerald-700 text-white text-sm font-medium hover:bg-emerald-800">
          Simpan Pengawas
        </button>
      </div>
    </form>
  </div>

  <!-- MODAL: Edit -->
  <div id="modalEdit" class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4 z-[99]">
    <form id="formEdit" action="" method="POST" class="w-full max-w-xl bg-white rounded-2xl shadow-xl border overflow-hidden">
      @csrf
      @method('PUT')
      <div class="px-6 py-4 border-b flex items-center justify-between">
        <div class="font-semibold text-slate-800">Edit Pengawas</div>
        <button type="button" class="closeModal text-slate-500 hover:text-slate-800">✕</button>
      </div>

      <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <div>
            <label class="text-xs text-slate-600">Nama</label>
            <input id="editNama" name="name" type="text" required
              class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
          </div>
          <div>
            <label class="text-xs text-slate-600">NIM (Username) - <span class="text-slate-400">Locked</span></label>
            <input id="editNim" type="text" readonly
              class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-500 cursor-not-allowed">
          </div>
        </div>

        <div>
          <label class="text-xs text-slate-600">Email</label>
          <input id="editEmail" name="email" type="email" required
            class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
        </div>

        <div>
          <label class="text-xs text-slate-600">Program Studi</label>
          <select id="editProdi" name="prodi_id" required class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
            @foreach($prodis as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="text-xs text-slate-600">Status</label>
          <select id="editStatus" name="status"
            class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-300">
            <option value="AKTIF">Aktif</option>
            <option value="NONAKTIF">Nonaktif</option>
          </select>
        </div>
      </div>

      <div class="px-6 py-4 border-t flex justify-end gap-2">
        <button type="button" class="closeModal px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 text-sm hover:bg-slate-50">
          Batal
        </button>
        <button type="submit" class="px-4 py-2.5 rounded-lg bg-emerald-700 text-white text-sm font-medium hover:bg-emerald-800">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>

  <style>
      .rotate-actions form { display: inline; }
  </style>

  <script>
    // ===== Modal helpers
    const modalCreate = document.getElementById('modalCreate');
    const modalEdit   = document.getElementById('modalEdit');
    const openCreate  = document.getElementById('btnOpenCreate');

    function openModal(el){ el.classList.remove('hidden'); el.classList.add('flex'); }
    function closeModal(el){ el.classList.add('hidden'); el.classList.remove('flex'); }

    openCreate?.addEventListener('click', () => openModal(modalCreate));

    document.querySelectorAll('.closeModal').forEach(btn => {
      btn.addEventListener('click', () => {
        closeModal(modalCreate);
        closeModal(modalEdit);
      });
    });

    [modalCreate, modalEdit].forEach(m => {
      m.addEventListener('click', (e) => {
        if (e.target === m) closeModal(m);
      });
    });

    // ===== Edit modal fill
    const editNama = document.getElementById('editNama');
    const editNim = document.getElementById('editNim');
    const editEmail = document.getElementById('editEmail');
    const editStatus = document.getElementById('editStatus');
    const editProdi = document.getElementById('editProdi');
    const formEdit = document.getElementById('formEdit');

    document.querySelectorAll('.btnEdit').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const tr = e.target.closest('.row');
        const id = tr.dataset.id;
        
        editNama.value = tr.dataset.nama;
        editNim.value = tr.dataset.nim;
        editEmail.value = tr.dataset.email;
        editStatus.value = tr.dataset.status;
        editProdi.value = tr.dataset.prodi || '';
        
        // Update form action URL
        formEdit.action = `/laa/pengawas/${id}`;
        
        openModal(modalEdit);
      });
    });
  </script>
@endsection
