@extends('layouts.pengawas')
@section('title','Input BAP')

@section('content')
  <div class="bg-white border rounded-2xl p-6">
    <div>
      <h1 class="text-lg font-semibold text-slate-800">Input BAP - Berita Acara Pelaksanaan Ujian</h1>
      <p class="text-sm text-slate-500 mt-1">Formulir Berita Acara Pengawasan Ujian sesuai format resmi</p>
    </div>

    <form class="mt-6 space-y-7" onsubmit="event.preventDefault(); alert('Dummy: Submit BAP');">

      <!-- I. Informasi Mata Kuliah -->
      <div>
        <div class="text-emerald-700 font-medium">I. Informasi Mata Kuliah</div>
        <div class="mt-3 border-t"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div>
            <label class="text-sm font-medium text-slate-700">
              Mata Kuliah <span class="text-red-500">*</span>
            </label>
            <input type="text" value="Algoritma dan Pemrograman"
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">
          </div>

          <div>
            <label class="text-sm font-medium text-slate-700">
              Kode Mata Kuliah <span class="text-red-500">*</span>
            </label>
            <input type="text" value="INF101"
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">
          </div>
        </div>
      </div>

      <!-- II. Waktu dan Tempat -->
      <div>
        <div class="text-emerald-700 font-medium">II. Waktu dan Tempat Pelaksanaan</div>
        <div class="mt-3 border-t"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div>
            <label class="text-sm font-medium text-slate-700">Ruang Ujian <span class="text-red-500">*</span></label>
            <input type="text" value="Lab Komputer 1"
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">
          </div>

          <div>
            <label class="text-sm font-medium text-slate-700">Tahun Ajaran <span class="text-red-500">*</span></label>
            <select
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">
              <option selected>2025/2026 Ganjil</option>
              <option>2025/2026 Genap</option>
              <option>2024/2025 Genap</option>
            </select>
          </div>

          <div>
            <label class="text-sm font-medium text-slate-700">Hari Ujian <span class="text-red-500">*</span></label>
            <select
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">
              <option>Senin</option><option>Selasa</option><option selected>Rabu</option><option>Kamis</option><option>Jumat</option>
            </select>
          </div>

          <div>
            <label class="text-sm font-medium text-slate-700">Tanggal Ujian <span class="text-red-500">*</span></label>
            <div class="mt-2 relative">
              <input type="date" value="2025-01-15"
                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-10 outline-none focus:ring-2 focus:ring-emerald-300">
              <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">📅</span>
            </div>
          </div>

          <div>
            <label class="text-sm font-medium text-slate-700">Waktu Mulai <span class="text-red-500">*</span></label>
            <div class="mt-2 relative">
              <input type="time" value="08:00"
                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-10 outline-none focus:ring-2 focus:ring-emerald-300">
              <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">🕒</span>
            </div>
          </div>

          <div>
            <label class="text-sm font-medium text-slate-700">Waktu Selesai <span class="text-red-500">*</span></label>
            <div class="mt-2 relative">
              <input type="time" value="10:00"
                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-10 outline-none focus:ring-2 focus:ring-emerald-300">
              <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">🕒</span>
            </div>
          </div>
        </div>
      </div>

      <!-- III. Kehadiran -->
      <div>
        <div class="text-emerald-700 font-medium">III. Kehadiran Peserta Ujian</div>
        <div class="mt-3 border-t"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div>
            <label class="text-sm font-medium text-slate-700">
              Jumlah Peserta Ujian (sesuai daftar hadir) <span class="text-red-500">*</span>
            </label>
            <input id="totalPeserta" type="number" value="45"
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">
          </div>

          <div>
            <label class="text-sm font-medium text-slate-700">
              Jumlah yang Tidak Hadir <span class="text-red-500">*</span>
            </label>
            <input id="jumlahTidakHadir" type="number" value="3"
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">
          </div>
        </div>

        <div class="mt-5 flex items-center justify-between gap-4">
          <div class="text-sm font-medium text-slate-700">Nama dan NIM Mahasiswa yang Tidak Hadir</div>
          <button type="button" id="btnAddMhs"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-sm font-medium">
            <span class="text-lg leading-none">＋</span> Tambah Mahasiswa
          </button>
        </div>

        <div class="mt-3 space-y-3" id="absenList">
          <!-- Row template inserted by JS -->
        </div>

        <div class="mt-4">
          <a href="{{ route('pengawas.bap.denah') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-sm font-medium">
            Input Denah Tempat Duduk (Optional)
          </a>
        </div>
      </div>

      <!-- IV. Peristiwa -->
      <div>
        <div class="text-emerald-700 font-medium">IV. Peristiwa yang Terjadi</div>
        <div class="mt-3 border-t"></div>

        <div class="mt-4">
          <label class="text-sm font-medium text-slate-700">Catatan Peristiwa <span class="text-red-500">*</span></label>
          <textarea rows="5"
            class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">Ujian berjalan dengan lancar. Tidak ada kecurangan atau pelanggaran yang terjadi.</textarea>
          <div class="text-sm text-slate-500 mt-2">Contoh: Ujian berjalan dengan lancar. Tidak ada kecurangan atau pelanggaran yang terjadi.</div>
        </div>
      </div>

      <!-- V. Pengawas -->
      <div>
        <div class="text-emerald-700 font-medium">V. Data Pengawas Ujian</div>
        <div class="mt-3 border-t"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div>
            <label class="text-sm font-medium text-slate-700">Pengawas Ujian 1 <span class="text-red-500">*</span></label>
            <input type="text" value="Dr. Ahmad Fauzi, M.Kom"
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">
          </div>
          <div>
            <label class="text-sm font-medium text-slate-700">Pengawas Ujian 2</label>
            <input type="text" value="Dr. Siti Rahma, M.T"
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">
          </div>
        </div>
      </div>

      <!-- VI. Dokumen -->
      <div>
        <div class="text-emerald-700 font-medium">VI. Dokumen Pendukung</div>
        <div class="mt-3 border-t"></div>

        <div class="mt-4">
          <label class="text-sm font-medium text-slate-700">Upload Dokumen (Opsional)</label>
          <div class="mt-2 flex items-stretch gap-3">
            <input type="file"
              class="flex-1 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none">
            <div class="w-12 rounded-xl border border-slate-200 bg-white flex items-center justify-center text-slate-500">
              ⤴
            </div>
          </div>
          <div class="text-sm text-slate-500 mt-2">Format: PDF, JPG, PNG (Max 5MB)</div>
        </div>

        <div class="mt-6 flex items-center gap-3">
          <button type="button"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 font-medium">
            👁️ Preview BAP
          </button>

          <button type="submit"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-700 text-white hover:bg-emerald-800 font-medium">
            🧾 Submit BAP
          </button>
        </div>
      </div>

    </form>
  </div>

  <script>
    // ===== Absen List (dynamic add/remove)
    const absenList = document.getElementById('absenList');
    const btnAddMhs = document.getElementById('btnAddMhs');
    const jumlahTidakHadir = document.getElementById('jumlahTidakHadir');

    const seed = [
      { nim: '1301210001', nama: 'Ahmad Rizki' },
      { nim: '1301210025', nama: 'Siti Nurhaliza' },
      { nim: '1301210087', nama: 'Budi Santoso' },
    ];

    function rowTemplate(index, nim = '', nama = '') {
      return `
        <div class="grid grid-cols-12 gap-3 items-center" data-row>
          <div class="col-span-12 md:col-span-1 text-slate-500 text-sm">${index}.</div>

          <div class="col-span-12 md:col-span-5">
            <input type="text" value="${nim}"
              placeholder="NIM"
              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">
          </div>

          <div class="col-span-12 md:col-span-6 flex items-center gap-3">
            <input type="text" value="${nama}"
              placeholder="Nama Mahasiswa"
              class="flex-1 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-300">
            <button type="button" class="btnRemove text-red-500 hover:text-red-700 px-2" title="Hapus">
              ✕
            </button>
          </div>
        </div>
      `;
    }

    function reindex() {
      const rows = Array.from(absenList.querySelectorAll('[data-row]'));
      rows.forEach((r, i) => {
        const num = r.querySelector('div');
        if (num) num.textContent = (i + 1) + '.';
      });
      jumlahTidakHadir.value = rows.length;
    }

    function addRow(nim = '', nama = '') {
      const idx = absenList.querySelectorAll('[data-row]').length + 1;
      const wrapper = document.createElement('div');
      wrapper.innerHTML = rowTemplate(idx, nim, nama);
      const node = wrapper.firstElementChild;
      absenList.appendChild(node);

      node.querySelector('.btnRemove').addEventListener('click', () => {
        node.remove();
        reindex();
      });

      reindex();
    }

    // init seed
    absenList.innerHTML = '';
    seed.forEach(s => addRow(s.nim, s.nama));

    btnAddMhs.addEventListener('click', () => addRow());
  </script>
@endsection
