<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - capstone</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
  class="min-h-screen bg-gradient-to-b from-white via-emerald-50 to-emerald-100 flex items-center justify-center p-4">
  <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-slate-100 p-8">
    <div class="flex flex-col items-center text-center gap-2 mb-6">
      <div class="w-14 h-14 rounded-full bg-emerald-600 flex items-center justify-center">
        <svg viewBox="0 0 24 24" class="w-7 h-7 text-white" fill="currentColor">
          <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zm0 13L5.5 12.5 12 9l6.5 3.5L12 16z" />
          <path d="M5 13.5V17c0 1.66 3.13 3 7 3s7-1.34 7-3v-3.5l-7 3.5-7-3.5z" />
        </svg>
      </div>

      <div class="text-emerald-700 font-semibold">Layanan Administrasi Akademik</div>
      <div class="text-slate-500 text-sm">Fakultas Rekayasa Industri</div>
      <div class="text-slate-500 text-sm">Telkom University</div>
    </div>

    @if ($errors->any())
      <div class="mb-4 rounded-lg bg-red-50 text-red-700 text-sm p-3">
        {{ $errors->first('login') ?? $errors->first() }}
      </div>
    @endif

    <form id="loginForm" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
        <input name="username" id="username" type="text" value="{{ old('username') }}" placeholder="Masukkan username"
          class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-400">
      </div>

      <div id="passwordWrap">
        <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
        <input name="password" id="password" type="password" placeholder="Masukkan password"
          class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-400">
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
        <select name="role" id="role"
          class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 outline-none focus:ring-2 focus:ring-emerald-400">
          <option value="">Pilih role</option>
          <option value="PENGAWAS">Pengawas</option>
          <option value="LAA">Staf LAA</option>
        </select>
      </div>

      <button type="submit"
        class="w-full rounded-lg bg-emerald-700 text-white py-2.5 font-semibold hover:bg-emerald-800 transition">
        Sign In
      </button>
    </form>
  </div>

  <script>
    const form = document.getElementById('loginForm');
    const role = document.getElementById('role');
    const btn = document.querySelector('button[type="submit"]');

    function syncAction() {
      if (role.value === '') {
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        form.action = "";
      } else {
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');

        if (role.value === 'LAA') {
          form.action = "{{ route('login.laa') }}";
        } else if (role.value === 'PENGAWAS') {
          form.action = "{{ route('login.pengawas') }}";
        }
      }
    }
    role.addEventListener('change', syncAction);
    syncAction();
  </script>
</body>

</html>