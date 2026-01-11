@extends('layouts.pengawas')
@section('title', 'Profil Saya')

@section('content')
    <div class="space-y-6 pb-20">

        <!-- HEADER -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Profil Saya</h1>
                <p class="text-sm text-slate-500 mt-1">Informasi akun dan data pribadi Anda</p>
            </div>
        </div>

        @if(session('success'))
            <div
                class="px-4 py-3 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- INFORMASI PROFIL (READ ONLY) -->
        <div class="bg-white border rounded-2xl overflow-hidden shadow-sm">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-slate-800">Informasi Profil</h2>
                <p class="text-sm text-slate-500 mt-1">Data profil Anda (read-only)</p>

                <!-- Avatar + Summary -->
                <div class="mt-6 flex flex-col md:flex-row md:items-center gap-6">
                    <div
                        class="w-24 h-24 rounded-full bg-emerald-50 flex items-center justify-center border-2 border-emerald-100">
                        <span class="text-3xl font-bold text-emerald-700">{{ substr($user->name, 0, 2) }}</span>
                    </div>

                    <div class="flex-1">
                        <div class="text-xl font-bold text-slate-800">{{ $user->name }}</div>
                        <div class="text-slate-500 font-medium">Pengawas Ujian</div>
                        <div class="text-slate-500 text-sm mt-1">NIM: {{ $user->nip ?? '-' }}</div>
                    </div>
                </div>

                <div class="mt-6 h-px bg-slate-100"></div>

                <!-- Form Read-only -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div>
                        <div class="flex items-center gap-2 text-sm font-semibold text-slate-700 mb-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Nama Lengkap
                        </div>
                        <input value="{{ $user->name }}" readonly
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 cursor-not-allowed text-sm" />
                    </div>

                    <!-- NIP -->
                    <div>
                        <div class="flex items-center gap-2 text-sm font-semibold text-slate-700 mb-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            NIM
                        </div>
                        <input value="{{ $user->nip }}" readonly
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 cursor-not-allowed text-sm" />
                    </div>

                    <!-- Email -->
                    <div>
                        <div class="flex items-center gap-2 text-sm font-semibold text-slate-700 mb-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Email
                        </div>
                        <input value="{{ $user->email }}" readonly
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 cursor-not-allowed text-sm" />
                    </div>

                    <!-- Role -->
                    <div>
                        <div class="flex items-center gap-2 text-sm font-semibold text-slate-700 mb-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Role
                        </div>
                        <input value="Pengawas Ujian" readonly
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 cursor-not-allowed text-sm" />
                    </div>
                </div>

                <!-- Info Box -->
                <div
                    class="mt-6 rounded-xl border border-blue-100 bg-blue-50 p-4 text-blue-800 text-sm flex gap-3 items-start">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <span class="font-semibold block mb-1">Informasi:</span>
                        Profil Anda bersifat read-only. Jika terdapat kesalahan data, silakan hubungi <span
                            class="font-medium">Admin LAA</span> untuk pembaruan.
                    </div>
                </div>
            </div>
        </div>

        <!-- INFORMASI SISTEM & KEAMANAN -->
        <div class="bg-white border rounded-2xl overflow-hidden shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-slate-800">Informasi Sistem</h2>
                    <p class="text-sm text-slate-500 mt-1">Status dan keamanan akun</p>
                </div>

                <!-- Tombol Ganti Password (Optional) -->
                <a href="{{ route('pengawas.password.edit') }}"
                    class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 14l-1 1-1 1H6v-2l2-2 1-1-1-1-1-1h6zM7 7a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Ganti Password
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="text-sm text-slate-500">Status Akun</div>
                    <div class="mt-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                            Aktif
                        </span>
                    </div>
                </div>

                <div>
                    <div class="text-sm text-slate-500">Terakhir Bergabung</div>
                    <div class="mt-1 font-semibold text-slate-800">{{ $user->created_at->format('d F Y') }}</div>
                </div>

                <div>
                    <div class="text-sm text-slate-500">Statistik BAP</div>
                    <div class="mt-1 font-medium text-slate-800">
                        {{ $totalBap }} Total / <span class="text-amber-600">{{ $pendingBap }} Pending</span>
                    </div>
                </div>

                <div>
                    <div class="text-sm text-slate-500">Kontak Support</div>
                    <div class="mt-1 text-emerald-600 font-medium">user.support@telkomuniversity.ac.id</div>
                </div>
            </div>
        </div>

    </div>
@endsection