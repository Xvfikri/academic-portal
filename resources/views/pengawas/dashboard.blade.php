@extends('layouts.pengawas')
@section('title', 'Dashboard')

@section('content')
    @php
        $user = auth()->user();
        // Taking 5 recent BAPs
        $baps = \App\Models\Bap::where('user_id', $user->id)->latest()->take(5)->get();

        // Statistics
        $total = \App\Models\Bap::where('user_id', $user->id)->count();
        $verified = \App\Models\Bap::where('user_id', $user->id)->where('status', 'APPROVED')->count();
        $pending = \App\Models\Bap::where('user_id', $user->id)->where('status', 'PENDING')->count();

        // Percentage for verified
        $percentVerified = $total > 0 ? round(($verified / $total) * 100) : 0;
    @endphp

    <!-- Banner -->
    <div class="bg-[#198754] rounded-xl p-6 text-white mb-6 relative overflow-hidden shadow-sm">
        <div class="relative z-10">
            <h2 class="text-2xl font-semibold mb-1">Selamat Datang, {{ $user->name ?? 'Pengawas Ujian' }}</h2>
            <p class="text-emerald-100 mb-6">Periode Akademik: Ganjil 2025/2026</p>

            <a href="{{ route('pengawas.bap.create') }}"
                class="inline-flex items-center gap-2 bg-white text-[#198754] px-4 py-2 rounded-lg font-medium hover:bg-emerald-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Input BAP Baru
            </a>
        </div>
        <!-- Decor -->
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white/10 skew-x-12 mix-blend-overlay"></div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-slate-600 text-sm font-medium">Total BAP Disubmit</h3>
                <span class="text-slate-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg></span>
            </div>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $total }}</div>
            <div class="text-xs text-slate-500">Semester ini</div>
        </div>

        <!-- Verified -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-slate-600 text-sm font-medium">BAP Terverifikasi</h3>
                <span class="text-emerald-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg></span>
            </div>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $verified }}</div>
            <div class="text-xs text-slate-500">{{ $percentVerified }}% dari total BAP</div>
        </div>

        <!-- Pending -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-slate-600 text-sm font-medium">BAP Pending</h3>
                <span class="text-amber-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg></span>
            </div>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $pending }}</div>
            <div class="text-xs text-slate-500">Menunggu verifikasi</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h3 class="font-semibold text-lg text-slate-800 mb-1">Quick Actions</h3>
        <p class="text-sm text-slate-500 mb-4">Aksi cepat untuk memudahkan pekerjaan Anda</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('pengawas.bap.create') }}"
                class="group bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-all flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-slate-800">Input BAP Baru</div>
                    <div class="text-sm text-slate-500">Buat laporan baru</div>
                </div>
            </a>

            <a href="{{ route('pengawas.bap.index') }}"
                class="group bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-all flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-slate-800">Lihat Riwayat</div>
                    <div class="text-sm text-slate-500">BAP yang sudah disubmit</div>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent BAP -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden min-h-[300px]">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800">BAP Terbaru</h3>
            <p class="text-sm text-slate-500">Daftar BAP yang baru saja Anda submit</p>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($baps as $b)
                <div
                    class="px-6 py-4 flex flex-col md:flex-row md:items-center justify-between hover:bg-slate-50 transition-colors gap-4">
                    <div>
                        <div class="text-xs text-slate-400 mb-1 font-mono">
                            BAP-{{ date('Y', strtotime($b->created_at)) }}-{{ str_pad($b->id, 3, '0', STR_PAD_LEFT) }}</div>
                        <div class="font-medium text-slate-800">{{ $b->mata_kuliah }}</div>
                        <div class="text-sm text-slate-500 mt-0.5">{{ $b->kode_mk }}</div>
                    </div>

                    <div
                        class="text-right flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center gap-4 md:gap-1">
                        @php
                            $colors = [
                                'PENDING' => 'bg-amber-100 text-amber-700',
                                'APPROVED' => 'bg-emerald-100 text-emerald-700',
                                'REJECTED' => 'bg-red-100 text-red-700',
                            ];
                            $labels = [
                                'PENDING' => 'Pending',
                                'APPROVED' => 'Terverifikasi',
                                'REJECTED' => 'Ditolak',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$b->status] ?? 'bg-slate-100' }}">
                            {{ $labels[$b->status] ?? $b->status }}
                        </span>
                        <div class="text-xs text-slate-400">{{ $b->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center p-12 text-center text-slate-500">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <p>Belum ada BAP yang dibuat.</p>
                </div>
            @endforelse
        </div>
    </div>

@endsection