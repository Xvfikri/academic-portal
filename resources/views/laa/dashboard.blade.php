@extends('layouts.laa')
@section('title', 'Dashboard - Admin LAA')

@section('content')
  <!-- Banner -->
  <div class="bg-[#198754] rounded-xl p-6 text-white mb-6 relative overflow-hidden shadow-sm">
    <div class="relative z-10">
      <h2 class="text-xl font-medium mb-1">Selamat Datang, Admin LAA</h2>
      <p class="text-emerald-100 text-sm">Periode Akademik: Ganjil 2025/2026</p>
    </div>
    <!-- Decor -->
    <div class="absolute right-0 top-0 h-full w-1/3 bg-white/10 skew-x-12 mix-blend-overlay"></div>
  </div>

  <!-- Stats Grid -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total BAP Masuk -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
      <div class="flex justify-between items-start mb-4">
        <h3 class="text-slate-600 text-sm font-medium">Total BAP Masuk</h3>
        <span class="text-slate-400">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
          </svg>
        </span>
      </div>
      <div>
        <div class="text-3xl font-bold text-slate-800 mb-1">{{ $totalBap }}</div>
        <div class="text-xs text-emerald-600 font-medium">+12% dari bulan lalu</div>
      </div>
    </div>

    <!-- Terverifikasi -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
      <div class="flex justify-between items-start mb-4">
        <h3 class="text-slate-600 text-sm font-medium">Total BAP Terverifikasi</h3>
        <span class="text-emerald-500">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </span>
      </div>
      <div>
        <div class="text-3xl font-bold text-slate-800 mb-1">{{ $verifiedBap }}</div>
        <div class="text-xs text-slate-500">{{ $verifiedPercent }}% dari total BAP</div>
      </div>
    </div>

    <!-- Belum Terverifikasi (Pending) -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
      <div class="flex justify-between items-start mb-4">
        <h3 class="text-slate-600 text-sm font-medium">Total BAP Belum Terverifikasi</h3>
        <span class="text-amber-500">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </span>
      </div>
      <div>
        <div class="text-3xl font-bold text-slate-800 mb-1">{{ $pendingBap }}</div>
        <div class="text-xs text-slate-500">Menunggu verifikasi</div>
      </div>
    </div>
  </div>

  <!-- Chart Section -->
  <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
      <div>
        <h3 class="font-semibold text-slate-800">Statistik BAP Harian</h3>
        <p class="text-sm text-slate-500">
          Rentang: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}
        </p>
      </div>

      <!-- Date Filter Form -->
      <form method="GET" action="{{ route('laa.dashboard') }}"
        class="flex flex-col sm:flex-row gap-3 items-center w-full md:w-auto">
        <div class="flex items-center gap-2 w-full md:w-auto">
          <input type="date" name="start_date" value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
            class="px-3 py-1.5 border border-slate-300 rounded-lg text-xs w-full">
          <span class="text-slate-400">-</span>
          <input type="date" name="end_date" value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
            class="px-3 py-1.5 border border-slate-300 rounded-lg text-xs w-full">
        </div>
        <button type="submit"
          class="px-4 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-medium hover:bg-emerald-700 w-full sm:w-auto">
          Filter
        </button>
      </form>
    </div>

    <div class="relative h-64 w-full">
      <canvas id="bapChart"></canvas>
    </div>

    <div class="flex justify-center gap-6 mt-4 text-sm flex-wrap">
      <div class="flex items-center gap-2">
        <span class="w-3 h-3 rounded-full bg-emerald-600"></span>
        <span class="text-slate-600">Terverifikasi</span>
      </div>
      <div class="flex items-center gap-2">
        <span class="w-3 h-3 rounded-full bg-amber-400"></span>
        <span class="text-slate-600">Pending</span>
      </div>
      <div class="flex items-center gap-2">
        <span class="w-3 h-3 rounded-full bg-red-500"></span>
        <span class="text-slate-600">Ditolak</span>
      </div>
    </div>
  </div>

  <!-- Recent Activities -->
  <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
    <h3 class="font-semibold text-slate-800 mb-1">Aktivitas Terbaru</h3>
    <p class="text-sm text-slate-500 mb-6">BAP yang baru saja disubmit</p>

    <div class="space-y-6">
      @forelse($recentActivities as $b)
        <div class="flex items-start justify-between border-b border-slate-50 pb-4 last:border-0 last:pb-0">
          <div>
            <div class="font-medium text-slate-800">{{ $b->user->name ?? $b->pengawas_1 }}</div>
            <div class="text-sm text-slate-500">{{ $b->mata_kuliah }}</div>
          </div>
          <div class="text-right">
            @if($b->status == 'PENDING')
              <span
                class="inline-block px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold mb-1">Pending</span>
            @elseif($b->status == 'APPROVED')
              <span
                class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold mb-1">Terverifikasi</span>
            @else
              <span
                class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold mb-1">Ditolak</span>
            @endif
            <div class="text-xs text-slate-400">{{ $b->created_at->diffForHumans() }}</div>
          </div>
        </div>
      @empty
        <div class="text-center text-slate-500 italic py-4">Belum ada aktivitas.</div>
      @endforelse
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('bapChart');

    // Data from Controller
    const labels = {!! json_encode($dates) !!};
    const pendingData = {!! json_encode($pendingSeries) !!};
    const approvedData = {!! json_encode($approvedSeries) !!};
    const rejectedData = {!! json_encode($rejectedSeries) !!};

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Terverifikasi',
            data: approvedData,
            backgroundColor: '#198754',
            borderRadius: 4,
            barPercentage: 0.6,
          },
          {
            label: 'Pending',
            data: pendingData,
            backgroundColor: '#FFC107',
            borderRadius: 4,
            barPercentage: 0.6,
          },
          {
            label: 'Ditolak',
            data: rejectedData,
            backgroundColor: '#ef4444',
            borderRadius: 4,
            barPercentage: 0.6,
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              color: '#f3f4f6',
              borderDash: [5, 5]
            },
            ticks: { stepSize: 1 }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });
  </script>
@endsection