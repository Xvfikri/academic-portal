@extends('layouts.pengawas')
@section('title', 'Semua Notifikasi')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Semua Notifikasi</h1>
                <p class="text-sm text-slate-500 mt-1">Riwayat lengkap aktivitas dan status BAP Anda.</p>
            </div>
            <a href="{{ route('pengawas.dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-600">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            @forelse($notifications as $notif)
                @php
                    $isApproved = $notif->status === 'APPROVED';
                    $isRejected = $notif->status === 'REJECTED';

                    // Visual logic
                    $iconColor = $isApproved ? 'text-emerald-600 bg-emerald-100' : 'text-red-600 bg-red-100';
                    $titleText = $isApproved ? 'BAP Telah Disetujui' : 'BAP Ditolak';
                    $borderClass = 'border-b border-slate-100 last:border-0';

                    // Highlight newer than 1 hour (Visual "Update per Jam")
                    $isNew = $notif->updated_at->diffInHours(now()) < 1;
                    $bgClass = $isNew ? 'bg-emerald-50/50' : 'hover:bg-slate-50';
                @endphp

                <div class="p-5 {{ $borderClass }} {{ $bgClass }} transition-colors flex gap-4 items-start relative">
                    <!-- New Indicator Dot -->
                    @if($isNew)
                        <div class="absolute top-5 right-5 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wide">Baru</span>
                        </div>
                    @endif

                    <div class="w-12 h-12 rounded-xl {{ $iconColor }} flex items-center justify-center flex-shrink-0">
                        @if($isApproved)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        @endif
                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-800">{{ $titleText }}</h3>
                        <p class="text-sm text-slate-600 mt-1">
                            Mata Kuliah: <span class="font-medium">{{ $notif->mata_kuliah }}</span>
                            ({{ \Carbon\Carbon::parse($notif->tanggal_ujian)->format('d M') }})
                        </p>
                        @if($isRejected && $notif->catatan_admin)
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-lg border border-red-100 italic">
                                "{{ $notif->catatan_admin }}"
                            </div>
                        @endif
                        <div class="text-xs text-slate-400 mt-2 flex items-center gap-2">
                            <svg class="w-3 H-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $notif->updated_at->diffForHumans() }}
                        </div>
                    </div>

                    <div class="ml-auto self-center pl-4 hidden sm:block">
                        <a href="{{ route('pengawas.bap.preview', $notif->id) }}"
                            class="px-4 py-2 rounded-lg border border-slate-200 text-sm font-medium text-slate-600 hover:bg-white hover:border-emerald-300 hover:text-emerald-700 transition-all shadow-sm">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-slate-500">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900">Tidak ada notifikasi</h3>
                    <p class="mt-1 text-sm text-slate-400">Semua aktivitas penting akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection