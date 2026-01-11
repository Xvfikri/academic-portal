@extends('layouts.laa')
@section('title', 'Pengaturan')

@section('content')
  <div class="space-y-6">
    <!-- INFORMASI PROFIL -->
    <div class="bg-white border rounded-2xl overflow-hidden">
      <div class="p-6">
        <h1 class="text-xl font-semibold text-slate-800">Informasi Profil</h1>
        <p class="text-sm text-slate-500 mt-1">Data profil Anda (read-only)</p>

        <!-- Avatar + Summary -->
        <div class="mt-6 flex flex-col md:flex-row md:items-center gap-6">
          <div class="w-28 h-28 rounded-full bg-emerald-50 flex items-center justify-center">
            <span class="text-3xl font-semibold text-emerald-700">AL</span>
          </div>

          <div class="flex-1">
            <div class="text-lg font-semibold text-slate-800">Admin LAA</div>
            <div class="text-slate-500">Administrator LAA</div>
            <div class="text-slate-500">NIP: 198501012010011001</div>
          </div>
        </div>

        <div class="mt-6 h-px bg-slate-200"></div>

        <!-- Form Read-only -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">
          <!-- Nama -->
          <div>
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
              <span class="text-slate-500">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" stroke-width="2" />
                </svg>
              </span>
              Nama Lengkap
            </div>
            <input value="Admin LAA" readonly
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700" />
          </div>

          <!-- NIP -->
          <div>
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
              <span class="text-slate-500">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <rect x="3" y="4" width="18" height="16" rx="2" stroke-width="2" />
                  <path d="M7 8h10" stroke-width="2" stroke-linecap="round" />
                  <path d="M7 12h6" stroke-width="2" stroke-linecap="round" />
                </svg>
              </span>
              NIP
            </div>
            <input value="198501012010011001" readonly
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700" />
          </div>

          <!-- Email -->
          <div>
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
              <span class="text-slate-500">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4V4z" />
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m4 6 8 7 8-7" />
                </svg>
              </span>
              Email
            </div>
            <input value="admin.laa@telkomuniversity.ac.id" readonly
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700" />
          </div>

          <!-- No Telepon -->
          <div>
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
              <span class="text-slate-500">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3 5.18 2 2 0 0 1 5.11 3h3a2 2 0 0 1 2 1.72c.12.9.32 1.77.59 2.6a2 2 0 0 1-.45 2.11L9.91 10.09a16 16 0 0 0 4 4l.66-.34a2 2 0 0 1 2.11-.45c.83.27 1.7.47 2.6.59A2 2 0 0 1 22 16.92z" />
                </svg>
              </span>
              No. Telepon
            </div>
            <input value="022-7564108" readonly
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700" />
          </div>

          <!-- Jabatan -->
          <div>
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
              <span class="text-slate-500">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <rect x="3" y="7" width="18" height="14" rx="2" stroke-width="2" />
                  <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke-width="2" />
                  <path d="M3 13h18" stroke-width="2" />
                </svg>
              </span>
              Jabatan
            </div>
            <input value="Administrator LAA" readonly
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700" />
          </div>

          <!-- Role -->
          <div>
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
              <span class="text-slate-500">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z" />
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 0 0-16 0" />
                </svg>
              </span>
              Role
            </div>
            <input value="Admin LAA" readonly
              class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700" />
          </div>
        </div>

        <!-- Info Box -->
        <div class="mt-6 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-blue-900">
          <span class="font-semibold">Informasi:</span>
          Profil Anda bersifat read-only dan tidak dapat diubah melalui sistem.
          Untuk perubahan data, silakan hubungi administrator sistem atau bagian Kepegawaian.
        </div>
      </div>
    </div>

    <!-- INFORMASI SISTEM -->
    <div class="bg-white border rounded-2xl p-6">
      <h2 class="text-xl font-semibold text-slate-800">Informasi Sistem</h2>
      <p class="text-sm text-slate-500 mt-1">Detail akses dan keamanan akun</p>

      <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <div class="text-sm text-slate-500">Username SSO</div>
          <div class="mt-1 font-semibold text-slate-800">admin.laa</div>
        </div>

        <div>
          <div class="text-sm text-slate-500">Terakhir Login</div>
          <div class="mt-1 font-semibold text-slate-800">2 Januari 2025, 08:30 WIB</div>
        </div>

        <div>
          <div class="text-sm text-slate-500">Status Akun</div>
          <div class="mt-2">
            <span
              class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
              Aktif
            </span>
          </div>
        </div>

        <div>
          <div class="text-sm text-slate-500">Hak Akses</div>
          <div class="mt-1 font-semibold text-slate-800">Admin LAA</div>
        </div>
      </div>
    </div>

    <!-- BANTUAN & DUKUNGAN -->
    <div class="bg-white border rounded-2xl p-6">
      <h2 class="text-2xl font-semibold text-slate-800">Bantuan & Dukungan</h2>
      <p class="text-slate-500 mt-1">Hubungi kami jika Anda memerlukan bantuan</p>

      <div class="mt-8 space-y-6">
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-xl bg-emerald-50 border flex items-center justify-center text-emerald-700">
            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4V4z" />
              <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m4 6 8 7 8-7" />
            </svg>
          </div>
          <div>
            <div class="text-lg font-semibold text-slate-800">Email Support</div>
            <a href="#" class="text-emerald-700 hover:underline">support.laa@telkomuniversity.ac.id</a>
          </div>
        </div>

        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-xl bg-emerald-50 border flex items-center justify-center text-emerald-700">
            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3 5.18 2 2 0 0 1 5.11 3h3a2 2 0 0 1 2 1.72c.12.9.32 1.77.59 2.6a2 2 0 0 1-.45 2.11L9.91 10.09a16 16 0 0 0 4 4l.66-.34a2 2 0 0 1 2.11-.45c.83.27 1.7.47 2.6.59A2 2 0 0 1 22 16.92z" />
            </svg>
          </div>
          <div>
            <div class="text-lg font-semibold text-slate-800">Telepon</div>
            <div class="text-slate-600">022-7564108 ext. 123</div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection