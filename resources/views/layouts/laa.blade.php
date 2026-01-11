<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard LAA')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50">
  <div class="min-h-screen flex flex-col">

    <!-- TOPBAR (FULL WIDTH) -->
    <header class="h-16 bg-white border-b px-6 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
            <path
              d="M7 2h10a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm0 2v16h10V4H7zm2 3h6v2H9V7zm0 4h6v2H9v-2z" />
          </svg>
        </div>

        <div>
          <div class="font-semibold text-slate-800 leading-tight">Layanan Administrasi Akademik</div>
          <div class="text-xs text-slate-500">Admin LAA</div>
        </div>
      </div>

      <div class="flex items-center gap-4">
        <!-- NOTIFIKASI DROPDOWN -->
        @php
          // Real dynamic notifications from DB (Pending BAPs as notifications for Admin)
          $notifs = \App\Models\Bap::with('user')
            ->where('status', 'PENDING')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($b) {
              return [
                'title' => 'BAP Masuk',
                'desc' => $b->mata_kuliah . ' oleh ' . ($b->user->name ?? $b->pengawas_1),
                'time' => $b->created_at->diffForHumans(),
                'status' => 'PENDING',
                'unread' => true,
              ];
            });

          $unreadCount = $notifs->count();

          $statusMap = [
            'PENDING' => ['label' => 'Pending', 'cls' => 'bg-amber-100 text-amber-800'],
            'SUCCESS' => ['label' => 'Berhasil', 'cls' => 'bg-emerald-100 text-emerald-700'],
            'REJECT' => ['label' => 'Ditolak', 'cls' => 'bg-red-100 text-red-700'],
          ];
        @endphp

        <div class="relative" id="notifWrap">
          <button id="notifBtn"
            class="w-10 h-10 rounded-full hover:bg-slate-100 flex items-center justify-center relative">
            <!-- bell icon -->
            <svg class="w-6 h-6 text-slate-800" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M18 8a6 6 0 10-12 0c0 7-3 7-3 7h18s-3 0-3-7" />
              <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13.73 21a2 2 0 01-3.46 0" />
            </svg>

            @if($unreadCount > 0)
              <span id="notifBadge"
                class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-red-500 text-white text-xs flex items-center justify-center">
                {{ $unreadCount }}
              </span>
            @endif
          </button>

          <!-- Panel dropdown -->
          <div id="notifPanel"
            class="hidden absolute right-0 mt-3 w-[420px] max-w-[90vw] bg-white rounded-2xl shadow-xl border overflow-hidden z-50">
            <!-- Header -->
            <div class="px-5 py-4 border-b">
              <div class="text-xl font-semibold text-slate-900">Notifikasi</div>
              <div class="text-slate-500">
                Anda memiliki <span id="notifUnreadText" class="font-semibold">{{ $unreadCount }}</span> notifikasi
                belum dibaca
              </div>
            </div>

            <!-- List -->
            <div class="max-h-[420px] overflow-auto" id="notifList">
              @foreach($notifs as $n)
                @php
                  $s = $statusMap[$n['status']] ?? $statusMap['PENDING'];
                @endphp

                <div
                  class="notifItem px-5 py-4 border-b last:border-b-0 flex gap-4 items-start {{ $n['unread'] ? 'bg-slate-50/60' : '' }}"
                  data-unread="{{ $n['unread'] ? '1' : '0' }}">
                  <!-- dot -->
                  <div class="mt-2 w-2.5 h-2.5 rounded-full {{ $n['unread'] ? 'bg-blue-500' : 'bg-transparent' }}"></div>

                  <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-3">
                      <div class="font-semibold text-slate-900 truncate">
                        {{ $n['title'] }}
                      </div>

                      <span
                        class="shrink-0 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $s['cls'] }}">
                        {{ $s['label'] }}
                      </span>
                    </div>

                    <div class="text-slate-500 mt-1">{{ $n['desc'] }}</div>
                    <div class="text-slate-400 mt-2">{{ $n['time'] }}</div>
                  </div>
                </div>
              @endforeach
            </div>

            <!-- Footer -->
            <button id="notifMarkAll" class="w-full py-5 text-center font-semibold text-slate-900 hover:bg-slate-50">
              Tandai semua sudah dibaca
            </button>
          </div>
        </div>

        <!-- Avatar -->
        <div class="flex items-center gap-2">
          <div
            class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-semibold">
            AL
          </div>
          <div class="text-sm">
            <div class="font-medium text-slate-800">Admin LAA</div>
          </div>
        </div>
      </div>
    </header>

    <!-- BODY: SIDEBAR + MAIN -->
    <div class="flex flex-1 min-h-0">

      <!-- SIDEBAR -->
      <aside class="w-72 bg-white border-r shrink-0">
        @php
          $linkClass = fn($active) =>
            'flex items-center gap-3 px-3 py-2 rounded-lg mt-1 ' .
            ($active
              ? 'bg-emerald-50 text-emerald-700 font-medium'
              : 'text-slate-600 hover:bg-slate-50');
        @endphp

        <nav class="p-4 text-sm">
          <!-- Dashboard -->
          <a href="{{ route('laa.dashboard') }}" class="{{ $linkClass(request()->routeIs('laa.dashboard')) }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
              <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
            </svg>
            <span>Dashboard</span>
          </a>

          <!-- Manajemen Pengawas -->
          <a href="{{ route('laa.pengawas.index') }}" class="{{ $linkClass(request()->routeIs('laa.pengawas.*')) }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M16 11c1.66 0 3-1.34 3-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zM8 11c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.95 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
            </svg>
            <span>Manajemen Pengawas</span>
          </a>

          <!-- Manajemen BAP -->
          <a href="{{ route('laa.bap.index') }}" class="{{ $linkClass(request()->routeIs('laa.bap.*')) }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M6 2h9l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm8 1.5V8h4.5L14 3.5zM7 12h10v2H7v-2zm0 4h10v2H7v-2zm0-8h7v2H7V8z" />
            </svg>
            <span>Manajemen BAP</span>
          </a>

          <!-- Rekapitulasi -->
          <a href="{{ route('laa.rekap.index') }}" class="{{ $linkClass(request()->routeIs('laa.rekap.*')) }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
              <path d="M3 3h18v2H3V3zm2 4h14v14H5V7zm2 2v10h10V9H7zm2 2h6v2H9v-2zm0 3h6v2H9v-2z" />
            </svg>
            <span>Rekapitulasi</span>
          </a>

          <!-- Pengaturan -->
          <a href="{{ route('laa.settings') }}" class="{{ $linkClass(request()->routeIs('laa.settings')) }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M19.14 12.94c.04-.31.06-.63.06-.94s-.02-.63-.06-.94l2.03-1.58a.5.5 0 0 0 .12-.64l-1.92-3.32a.5.5 0 0 0-.6-.22l-2.39.96a7.1 7.1 0 0 0-1.63-.94l-.36-2.54A.5.5 0 0 0 13.9 1h-3.8a.5.5 0 0 0-.49.42l-.36 2.54c-.58.23-1.12.54-1.63.94l-2.39-.96a.5.5 0 0 0-.6.22L2.71 7.48a.5.5 0 0 0 .12.64l2.03 1.58c-.04.31-.06.63-.06.94s.02.63.06.94L2.83 14.52a.5.5 0 0 0-.12.64l1.92 3.32c.13.22.39.3.6.22l2.39-.96c.5.4 1.05.71 1.63.94l.36 2.54c.04.24.25.42.49.42h3.8c.24 0 .45-.18.49-.42l.36-2.54c.58-.23 1.12-.54 1.63-.94l2.39.96c.22.09.47 0 .6-.22l1.92-3.32a.5.5 0 0 0-.12-.64l-2.03-1.58zM12 15.5A3.5 3.5 0 1 1 12 8a3.5 3.5 0 0 1 0 7.5z" />
            </svg>
            <span>Pengaturan</span>
          </a>

          <!-- Logout -->
          <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 17l1.41-1.41L8.83 13H21v-2H8.83l2.58-2.59L10 7l-7 7 7 7z" />
                <path d="M4 5h6V3H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6v-2H4V5z" />
              </svg>
              Logout
            </button>
          </form>
        </nav>
      </aside>

      <!-- MAIN -->
      <main class="flex-1 p-6 min-w-0">
        @yield('content')
      </main>

    </div>
  </div>
</body>

</html>