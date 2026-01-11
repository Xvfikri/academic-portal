<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ganti Password</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">

  <div class="w-full max-w-md bg-white border rounded-2xl shadow-sm overflow-hidden">
    <div class="p-6 border-b text-center">
      <div class="mx-auto w-14 h-14 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-semibold text-xl">
        {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
      </div>
      <h1 class="mt-4 text-xl font-semibold text-slate-800">Ganti Password</h1>
      <p class="text-sm text-slate-500 mt-1">Demi keamanan akun, silakan ganti password terlebih dahulu</p>
    </div>

    <div class="p-6">
      @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 text-red-700 text-sm">
          <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="mb-4 px-4 py-3 rounded-xl bg-amber-50 text-amber-800 text-sm border border-amber-200">
        ⚠️ Password default hanya boleh digunakan sekali. Anda <b>wajib</b> membuat password baru sebelum melanjutkan.
      </div>

      <form method="POST" action="{{ route('pengawas.password.update') }}" class="space-y-4">
        @csrf

        <div>
          <label class="text-sm text-slate-700 font-medium">Password Baru</label>
          <input type="password" name="password" required minlength="8"
            class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 outline-none focus:ring-2 focus:ring-emerald-300"
            placeholder="Minimal 8 karakter">
        </div>

        <div>
          <label class="text-sm text-slate-700 font-medium">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" required minlength="8"
            class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 outline-none focus:ring-2 focus:ring-emerald-300"
            placeholder="Ulangi password baru">
        </div>

        <button type="submit"
          class="w-full mt-2 px-4 py-2.5 rounded-xl bg-emerald-700 text-white font-semibold hover:bg-emerald-800">
          Simpan Password Baru
        </button>
      </form>
    </div>
  </div>

</body>
</html>
