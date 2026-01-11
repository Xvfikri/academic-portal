@extends('layouts.pengawas')
@section('title', isset($bap) ? 'Edit BAP' : 'Input BAP')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-semibold text-slate-800">{{ isset($bap) ? 'Edit BAP' : 'Input Berita Acara' }}</h1>
      <p class="text-sm text-slate-500 mt-1">Silakan lengkapi form berikut dengan data yang valid.</p>
    </div>
  </div>

  @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 rounded-xl text-red-600 text-sm">
      <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if(session('success'))
    <div
      class="mb-6 px-4 py-3 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center gap-2">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
      {{ session('success') }}
    </div>
  @endif

  <form id="bapForm" action="{{ isset($bap) ? route('pengawas.bap.update', $bap->id) : route('pengawas.bap.store') }}"
    method="POST" enctype="multipart/form-data" class="space-y-8 pb-20">
    @csrf
    @if(isset($bap))
      @method('PUT')
    @endif

    <!-- Hidden input to determine action type (save, denah, preview) -->
    <input type="hidden" name="action" id="actionInput" value="save">

    <!-- I. Informasi Mata Kuliah -->
    <section class="bg-white border rounded-2xl p-6 shadow-sm">
      <h2 class="text-lg font-semibold text-slate-800 border-b pb-4 mb-6 flex items-center gap-2">
        <span
          class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">1</span>
        Informasi Mata Kuliah
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Mata Kuliah</label>
          <input type="text" name="mata_kuliah" value="{{ old('mata_kuliah', $bap->mata_kuliah ?? '') }}"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm"
            placeholder="Contoh: Algoritma dan Pemrograman">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Kode MK</label>
          <input type="text" name="kode_mk" value="{{ old('kode_mk', $bap->kode_mk ?? '') }}"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm"
            placeholder="Contoh: CS101">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Program Studi</label>
          <select name="prodi_id"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            <option value="">Pilih Program Studi</option>
            @foreach($prodis as $prod)
              <option value="{{ $prod->id }}" {{ (old('prodi_id', $bap->prodi_id ?? '') == $prod->id) ? 'selected' : '' }}>
                {{ $prod->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Tahun Ajaran / Semester</label>
          <select name="tahun_ajaran"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            <option value="Ganjil 2025/2026">Ganjil 2025/2026</option>
            <option value="Genap 2025/2026">Genap 2025/2026</option>
          </select>
        </div>
      </div>
    </section>

    <!-- II. Waktu dan Tempat -->
    <section class="bg-white border rounded-2xl p-6 shadow-sm">
      <h2 class="text-lg font-semibold text-slate-800 border-b pb-4 mb-6 flex items-center gap-2">
        <span
          class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">2</span>
        Jadwal & Ruang Ujian
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Hari Ujian</label>
          <select name="hari_ujian"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
              <option value="{{ $hari }}" {{ (old('hari_ujian', $bap->hari_ujian ?? '') == $hari) ? 'selected' : '' }}>
                {{ $hari }}
              </option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Ujian</label>
          <input type="date" name="tanggal_ujian"
            value="{{ old('tanggal_ujian', isset($bap) ? $bap->tanggal_ujian->format('Y-m-d') : date('Y-m-d')) }}"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Ruang Ujian</label>
          <input type="text" name="ruang_ujian" value="{{ old('ruang_ujian', $bap->ruang_ujian ?? '') }}"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm"
            placeholder="Contoh: GKU-304">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Jam Mulai</label>
          <input type="time" name="waktu_mulai"
            value="{{ old('waktu_mulai', isset($bap) ? substr($bap->waktu_mulai, 0, 5) : '08:00') }}"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Jam Selesai</label>
          <input type="time" name="waktu_selesai"
            value="{{ old('waktu_selesai', isset($bap) ? substr($bap->waktu_selesai, 0, 5) : '10:00') }}"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        </div>
      </div>
    </section>

    <!-- III. Kehadiran -->
    <section class="bg-white border rounded-2xl p-6 shadow-sm">
      <h2 class="text-lg font-semibold text-slate-800 border-b pb-4 mb-6 flex items-center gap-2">
        <span
          class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">3</span>
        Kehadiran Peserta
      </h2>

      <div class="flex flex-col md:flex-row gap-6 mb-6">
        <div class="flex-1">
          <label class="block text-sm font-medium text-slate-700 mb-2">Total Jumlah Peserta (Terdaftar)</label>
          <input type="number" id="totalPeserta" name="jumlah_peserta"
            value="{{ old('jumlah_peserta', $bap->jumlah_peserta ?? 40) }}"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        </div>
        <div class="flex-1">
          <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Tidak Hadir</label>
          <input type="number" id="totalTidakHadir" name="jumlah_tidak_hadir"
            value="{{ old('jumlah_tidak_hadir', $bap->jumlah_tidak_hadir ?? 0) }}" readonly
            class="bg-slate-50 w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium text-red-600">
        </div>
      </div>

      <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-semibold text-slate-800">Daftar Mahasiswa Tidak Hadir</h3>
          <button type="button" onclick="addAbsentRow()"
            class="text-xs flex items-center gap-1 bg-white border border-slate-200 shadow-sm px-3 py-1.5 rounded-lg hover:bg-slate-50 text-emerald-600 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Mahasiswa
          </button>
        </div>

        <div id="absentContainer" class="space-y-3">
          @if(old('absent'))
            @foreach(old('absent') as $index => $abs)
              <div class="flex gap-3 items-center absent-row">
                <input type="text" name="absent[{{$index}}][nim]" value="{{ $abs['nim'] }}"
                  class="w-1/3 rounded-lg border-slate-200 text-sm" placeholder="NIM">
                <input type="text" name="absent[{{$index}}][nama]" value="{{ $abs['nama'] }}"
                  class="w-2/3 rounded-lg border-slate-200 text-sm" placeholder="Nama Lengkap">
                <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700"><svg class="w-5 h-5"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                  </svg></button>
              </div>
            @endforeach
          @elseif(isset($bap) && $bap->absents->count() > 0)
            @foreach($bap->absents as $index => $abs)
              <div class="flex gap-3 items-center absent-row">
                <input type="text" name="absent[{{$index}}][nim]" value="{{ $abs->nim }}"
                  class="w-1/3 rounded-lg border-slate-200 text-sm" placeholder="NIM">
                <input type="text" name="absent[{{$index}}][nama]" value="{{ $abs->nama }}"
                  class="w-2/3 rounded-lg border-slate-200 text-sm" placeholder="Nama Lengkap">
                <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700"><svg class="w-5 h-5"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                  </svg></button>
              </div>
            @endforeach
          @else
            <div class="text-center py-4 text-xs text-slate-400 italic" id="emptyMsg">Tidak ada mahasiswa yang absen.</div>
          @endif
        </div>

        <div class="mt-4 pt-4 border-t border-slate-200">
          <div class="flex items-center justify-between">
            <div>
              <label class="block text-sm font-medium text-slate-700">Denah Tempat Duduk</label>
              <p class="text-xs text-slate-500">Wajib diisi untuk dokumentasi.</p>
            </div>
            <button type="button" onclick="submitToDenah()"
              class="px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg hover:bg-indigo-100 font-medium text-sm flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                </path>
              </svg>
              {{ isset($bap) && $bap->seats()->count() > 0 ? 'Edit Denah' : 'Isi Denah Tempat Duduk' }}
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- IV. Catatan & Dokumen -->
    <section class="bg-white border rounded-2xl p-6 shadow-sm">
      <h2 class="text-lg font-semibold text-slate-800 border-b pb-4 mb-6 flex items-center gap-2">
        <span
          class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">4</span>
        Catatan & Dokumen Pndukung
      </h2>

      <div class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Kejadian / Berita Acara</label>
          <textarea name="catatan_peristiwa" rows="4"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm"
            placeholder="Tuliskan kejadian penting selama ujian berlangsung...">{{ old('catatan_peristiwa', $bap->catatan_peristiwa ?? '') }}</textarea>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Lampiran (Foto/Scan)</label>
          <div class="flex items-center justify-center w-full">
            <label for="lampiran-file"
              class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100">
              <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <p class="mb-2 text-sm text-slate-500"><span class="font-semibold">Klik untuk upload</span> atau drag and
                  drop</p>
                <p class="text-xs text-slate-500">PDF, JPG, PNG (MAX. 5MB)</p>
              </div>
              <input id="lampiran-file" name="lampiran" type="file" class="hidden" onchange="showFileName(this)" />
            </label>
          </div>
          <!-- Show existing file if any -->
          @if(isset($bap) && $bap->lampiran)
            <div class="mt-2 text-sm text-emerald-600 flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              File tersimpan. Upload baru untuk mengganti.
            </div>
          @endif
          <div id="file-name-display" class="mt-2 text-sm text-slate-600"></div>
        </div>
      </div>
    </section>

    <!-- V. Pengawas -->
    <section class="bg-white border rounded-2xl p-6 shadow-sm">
      <h2 class="text-lg font-semibold text-slate-800 border-b pb-4 mb-6 flex items-center gap-2">
        <span
          class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">5</span>
        Tim Pengawas
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Pengawas 1 (Anda)</label>
          <input type="text" name="pengawas_1" value="{{ auth()->user()->name }}" readonly
            class="w-full bg-slate-100 rounded-lg border-slate-200 text-slate-500 cursor-not-allowed text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Pengawas 2 (Opsional)</label>
          <input type="text" name="pengawas_2" value="{{ old('pengawas_2', $bap->pengawas_2 ?? '') }}"
            class="w-full rounded-lg border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm"
            placeholder="Nama Pengawas Pendamping">
        </div>
      </div>
    </section>

    <!-- Action Buttons -->
    <div class="flex items-center justify-end gap-3 sticky bottom-4 z-20">
      <div class="bg-white p-3 rounded-xl shadow-lg border flex gap-3">
        <button type="submit" onclick="setAction('save')"
          class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition-colors">
          Simpan Draft
        </button>
        <button type="button" onclick="submitToPreview()"
          class="px-5 py-2.5 rounded-lg bg-emerald-600 text-white font-medium hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-200">
          Preview & Submit
        </button>
      </div>
    </div>
  </form>

  <!-- Script for Dynamic Rows & Logic -->
  <script>
    let absentIndex = {{ isset($bap) ? $bap->absents->count() : (old('absent') ? count(old('absent')) : 0) }};

    function addAbsentRow() {
      document.getElementById('emptyMsg')?.remove();
      const container = document.getElementById('absentContainer');
      const div = document.createElement('div');
      div.className = 'flex gap-3 items-center absent-row';
      div.innerHTML = `
                <input type="text" name="absent[${absentIndex}][nim]" class="w-1/3 rounded-lg border-slate-200 text-sm" placeholder="NIM">
                <input type="text" name="absent[${absentIndex}][nama]" class="w-2/3 rounded-lg border-slate-200 text-sm" placeholder="Nama Lengkap">
                <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
            `;
      container.appendChild(div);
      absentIndex++;
      updateCount();
    }

    function removeRow(btn) {
      btn.closest('.absent-row').remove();
      updateCount();
    }

    function updateCount() {
      const rows = document.querySelectorAll('.absent-row').length;
      document.getElementById('totalTidakHadir').value = rows;
    }

    function showFileName(input) {
      if (input.files && input.files[0]) {
        document.getElementById('file-name-display').innerText = 'File dipilih: ' + input.files[0].name;
      }
    }

    function setAction(val) {
      document.getElementById('actionInput').value = val;
    }

    function submitToDenah() {
      setAction('denah');
      document.getElementById('bapForm').submit();
    }

    function submitToPreview() {
      setAction('preview');
      document.getElementById('bapForm').submit();
    }
  </script>
@endsection