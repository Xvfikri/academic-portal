<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Dashboard Pengawas')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-50 font-sans text-slate-900">

  {{-- 
     =======================================================
     LOGIC PHP SEDERHANA (VIEW COMPOSER)
     =======================================================
     Di aplikasi nyata, logika ini sebaiknya dipindah ke 
     AppServiceProvider atau ViewComposer agar lebih rapi.
  --}}
  @php
    $u = auth()->user();
    $name = $u?->name ?? 'Pengawas Ujian';
    
    // Ambil 2 huruf pertama dari nama untuk avatar
    $initials = collect(explode(' ', trim($name)))
      ->filter()
      ->take(2)
      ->map(fn($w) => strtoupper(mb_substr($w,0,1)))
      ->implode('');
    $initials = $initials ?: 'PU';

    // Helper class untuk link sidebar active/inactive
    $linkClass = fn($active) =>
      'flex items-center gap-3 px-3 py-2 rounded-xl mt-1 text-sm transition-colors duration-200 ' .
      ($active
        ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm border border-emerald-100'
        : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900');

    // Dynamic User Notifications (Approved/Rejected BAPs)
    $notif = \App\Models\Bap::where('user_id', auth()->id())
                ->whereIn('status', ['APPROVED', 'REJECTED'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function($b){
                    $title = $b->status == 'APPROVED' ? 'BAP Disetujui' : 'BAP Ditolak';
                    $style = $b->status == 'APPROVED' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700';
                    $badge = $b->status == 'APPROVED' ? 'Sukses' : 'Info';
                    return [
                        'title' => $title,
                        'meta'  => $b->mata_kuliah . ' (' . $b->tanggal_ujian->format('d M') . ')',
                        'time'  => $b->updated_at->diffForHumans(),
                        'badge' => $badge,
                        'badgeStyle' => $style,
                    ];
                });
    $unread = $notif->count();
  @endphp

  <div class="min-h-screen flex flex-col">

    <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-30 shadow-sm">
      
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-emerald-600 flex items-center justify-center text-white shadow-emerald-200 shadow-md">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/>
          </svg>
        </div>
        <div class="leading-tight">
          <div class="font-bold text-slate-800 text-sm md:text-base">Layanan Administrasi</div>
          <div class="text-xs text-slate-500 font-medium">Portal Pengawas Ujian</div>
        </div>
      </div>

      <div class="flex items-center gap-4">
        
        <div class="relative">
          <button id="btnNotif" class="w-10 h-10 rounded-full hover:bg-slate-100 flex items-center justify-center relative transition-colors">
            <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            @if($unread > 0)
              <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-red-500 border-2 border-white"></span>
            @endif
          </button>

          <div id="notifPanel" class="hidden absolute right-0 mt-3 w-80 md:w-96 bg-white border border-slate-100 rounded-2xl shadow-xl overflow-hidden z-50 origin-top-right transition-all">
            <div class="p-4 border-b bg-slate-50/50 flex justify-between items-center">
              <span class="font-semibold text-slate-800">Notifikasi</span>
              <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-medium">{{ $unread }} Baru</span>
            </div>
            <div class="max-h-[300px] overflow-y-auto custom-scrollbar">
              @foreach($notif as $n)
                <div class="px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition cursor-pointer group">
                  <div class="flex items-start gap-3">
                    <div class="mt-1 w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0"></div>
                    <div class="flex-1 min-w-0">
                      <div class="flex items-center justify-between gap-2 mb-0.5">
                        <span class="font-medium text-sm text-slate-800 truncate">{{ $n['title'] }}</span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full {{ $n['badgeStyle'] }}">{{ $n['badge'] }}</span>
                      </div>
                      <p class="text-xs text-slate-500 truncate">{{ $n['meta'] }}</p>
                      <p class="text-[10px] text-slate-400 mt-1">{{ $n['time'] }}</p>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="p-2 bg-slate-50 text-center">
              <a href="{{ route('pengawas.notifications.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Lihat Semua Notifikasi</a>
            </div>
          </div>
        </div>

        <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
          <div class="text-right hidden md:block">
            <div class="text-sm font-semibold text-slate-800">{{ $name }}</div>
            <div class="text-xs text-slate-500">NIM. {{ auth()->user()->nip ?? '12345678' }}</div>
          </div>
          <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold border-2 border-white shadow-sm ring-1 ring-slate-100">
            {{ $initials }}
          </div>
        </div>
      </div>
    </header>

    <div class="flex flex-1 min-h-0 overflow-hidden">

      <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col flex-shrink-0">
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
          
          <a href="{{ route('pengawas.dashboard') }}" class="{{ $linkClass(request()->routeIs('pengawas.dashboard')) }}">
            <svg class="w-5 h-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard</span>
          </a>

          <a href="{{ route('pengawas.bap.create') }}" class="{{ $linkClass(request()->routeIs('pengawas.bap.create')) }}">
            <svg class="w-5 h-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Input BAP</span>
          </a>

          <a href="{{ route('pengawas.bap.index') }}" class="{{ $linkClass(request()->routeIs('pengawas.bap.index')) }}">
            <svg class="w-5 h-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Riwayat BAP</span>
          </a>

          <div class>
             
             <a href="{{ route('pengawas.profil') }}" class="{{ $linkClass(request()->routeIs('pengawas.profil*')) }}">
              <svg class="w-5 h-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              <span>Profil Saya</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="block">
              @csrf
              <button class="w-full flex items-center gap-3 px-3 py-2 rounded-xl mt-1 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                <svg class="w-5 h-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
              </button>
            </form>
          </div>

        </nav>
      </aside>

      <main class="flex-1 bg-slate-50 p-4 md:p-8 overflow-y-auto min-w-0">
        <div class="max-w-6xl mx-auto">
           @yield('content')
        </div>
      </main>

    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const btn = document.getElementById('btnNotif');
      const panel = document.getElementById('notifPanel');

      if(btn && panel) {
        // Toggle click
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          panel.classList.toggle('hidden');
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
          if (!panel.contains(e.target) && !btn.contains(e.target)) {
            panel.classList.add('hidden');
          }
        });

        // Close on Esc key
        document.addEventListener('keydown', (e) => {
          if(e.key === 'Escape') panel.classList.add('hidden');
        });
      }
    });
  </script>
</body>
</html>