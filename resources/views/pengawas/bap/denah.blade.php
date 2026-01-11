@extends('layouts.pengawas')
@section('title', 'Denah Tempat Duduk')

@section('content')
  <div class="max-w-6xl mx-auto">

    <div class="bg-white border border-slate-200 rounded-2xl p-6">
      <div class="flex items-start gap-3">
        <a href="{{ route('pengawas.bap.create') }}"
          class="text-slate-600 hover:text-slate-800 text-xl leading-none">←</a>
        <div>
          <div class="text-lg font-semibold text-slate-900">Denah Tempat Duduk</div>
          <div class="text-sm text-slate-500">Input NIM mahasiswa sesuai dengan posisi tempat duduk</div>
        </div>
      </div>

      @if(session('success'))
        <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
          ✅ {{ session('success') }}
        </div>
      @endif

      {{-- Petunjuk --}}
      <div class="mt-6 rounded-2xl border border-blue-200 bg-blue-50 p-5">
        <div class="text-blue-800 font-semibold">Petunjuk Pengisian:</div>
        <ul class="mt-2 text-sm text-blue-800 list-disc ml-5 space-y-1">
          <li>Masukkan NIM mahasiswa pada setiap kotak sesuai posisi tempat duduk</li>
          <li>Kosongkan kotak jika tempat duduk tidak terisi</li>
          <li>Pastikan semua NIM sudah terisi dengan benar sebelum menyimpan</li>
        </ul>
      </div>

      {{-- Papan --}}
      <div class="mt-6 rounded-2xl bg-emerald-700 text-white text-center py-6">
        <div class="font-semibold tracking-wide">■ MEJA PENGAWAS ■</div>
        <div class="text-sm opacity-90 mt-1">PAPAN TULIS / DEPAN KELAS</div>
      </div>

      {{-- Grid --}}
      @php
        $rows = 8;
        $cols = 5;
        $total = $rows * $cols;
      @endphp

      <form action="{{ route('pengawas.bap.denah.store') }}" method="POST" class="mt-8">
        @csrf
        
        <!-- Hidden BAP ID -->
        <input type="hidden" name="bap_id" value="{{ $bap->id }}">

        <div class="grid grid-cols-6 gap-4 items-start">
          <div class="col-span-1"></div>
          @for($c = 1; $c <= $cols; $c++)
            <div class="col-span-1 text-center text-sm text-slate-500">Kolom {{ $c }}</div>
          @endfor

          @for($r = 1; $r <= $rows; $r++)
            <div class="col-span-1 text-sm text-slate-500 flex items-center justify-end pr-2">Baris {{ $r }}</div>
            @for($c = 1; $c <= $cols; $c++)
              @php 
                $idx = (($r - 1) * $cols) + $c - 1; // 0-indexed for array
                $seatNum = $idx + 1;
                // Pre-fill if seat exists
                $existingSeat = $bap->seats->firstWhere('seat_number', $seatNum);
                $existingNim = $existingSeat ? $existingSeat->nim : '';
              @endphp
              <div class="col-span-1">
                <input name="seat[{{ $idx }}]" value="{{ old("seat.$idx", $existingNim) }}"
                  class="w-full rounded-xl bg-slate-100 border border-transparent px-4 py-3 text-center outline-none focus:ring-2 focus:ring-emerald-300"
                  placeholder="NIM">
              </div>
            @endfor
          @endfor
        </div>

        <div class="mt-8 rounded-xl bg-slate-200 text-center py-3 font-semibold text-slate-800">
          BELAKANG KELAS
        </div>

        <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-900">
          <span id="seatInfo">Total tempat duduk terisi: 0 dari {{ $total }}</span>
        </div>

        <div class="mt-5 flex items-center justify-end gap-3 sticky bottom-4 z-20">
          <a href="{{ route('pengawas.bap.edit', $bap->id) }}"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold hover:bg-slate-50">
            Batal
          </a>
          
          <button type="submit"
            class="inline-flex items-center gap-2 rounded-xl bg-emerald-700 text-white px-5 py-2.5 text-sm font-semibold hover:bg-emerald-800 shadow-lg shadow-emerald-200">
            💾 Simpan & Kembali ke BAP
          </button>
        </div>
      </form>

    </div>
  </div>

  <script>
    const inputs = Array.from(document.querySelectorAll('input[name^="seat["]'));
    const seatInfo = document.getElementById('seatInfo');
    const total = inputs.length;

    function countFilled() {
      const filled = inputs.filter(i => (i.value || '').trim().length > 0).length;
      seatInfo.textContent = `Total tempat duduk terisi: ${filled} dari ${total}`;
    }

    inputs.forEach(i => i.addEventListener('input', countFilled));
    countFilled();
  </script>
@endsection