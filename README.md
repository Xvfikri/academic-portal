# Sistem Berita Acara Pemeriksaan (BAP) Online - Capstone Project

**Sistem Berita Acara Pemeriksaan (BAP) Online** adalah solusi transformasi digital untuk proses administrasi ujian di lingkungan akademik. Sistem ini menggantikan proses manual berbasis kertas dengan alur kerja digital yang terintegrasi, mulai dari pengisian Berita Acara oleh pengawas ujian hingga verifikasi dan rekapitulasi data oleh pihak Layanan Administrasi Akademik (LAA).

---

## 🚀 Fitur Utama

### 1. Panel Layanan Administrasi Akademik (LAA) - Administrator
Bagi admin, sistem menyediakan kendali penuh atas data dan proses verifikasi:
- **Dashboard Analitik**: Visualisasi data statistik BAP (Total, Disetujui, Ditolak, Pending) menggunakan grafik interaktif untuk memudahkan pemantauan.
- **Manajemen Pengawas Terpusat**: Pengelolaan akun pengawas (Dosen/Staf), mencakup fitur aktivasi/non-aktifkan akun serta reset password secara aman.
- **Validasi & Verifikasi BAP**: Fitur inspeksi detail untuk setiap BAP yang masuk. Admin dapat memberikan catatan revisi jika data ditolak, yang akan muncul sebagai notifikasi bagi pengawas.
- **Eksport Laporan Fleksibel**: Menghasilkan rekapitulasi BAP dalam format **PDF** dan **Excel**. Mendukung filter berdasarkan program studi, rentang tanggal, maupun nama pengawas tertentu.

### 2. Panel Pengawas - User
Dirancang dengan antarmuka yang intuitif untuk memudahkan pengisian di lokasi ujian:
- **Digital BAP Entry**: Form pengisian data ujian yang komprehensif, mulai dari mata kuliah, ruang, hingga catatan peristiwa selama ujian berlangsung.
- **Interactive Seating Plan (Denah)**: Modul khusus untuk memetakan posisi mahasiswa di ruang ujian secara digital sesuai dengan nomor kursi.
- **Manajemen Absensi**: Pencatatan mahasiswa yang tidak hadir dengan detil NIM dan nama untuk sinkronisasi data kehadiran.
- **Sistem Notifikasi & Status**: Pengawas akan mendapatkan pembaruan status BAP secara real-time. Jika BAP ditolak, alasan penolakan dapat langsung dilihat untuk dilakukan perbaikan.
- **Keamanan Akun**: Fitur ganti password wajib saat pertama kali login dan manajemen profil pribadi.

---

## 🛠️ Stack Teknologi
Proyek ini dibangun menggunakan kombinasi teknologi modern untuk menjamin performa, keamanan, dan skalabilitas:
- **Backend Framework**: [Laravel 11](https://laravel.com/) (PHP ^8.2)
- **Frontend Engine**: Blade Template Engine dengan [Vite](https://vitejs.dev/) bundler.
- **Styling**: [Tailwind CSS](https://tailwindcss.com/) untuk desain responsif dan modern.
- **Interaktivitas**: [Alpine.js](https://alpinejs.dev/) untuk komponen frontend yang ringan.
- **Database**: MySQL/MariaDB.
- **Library Tambahan**:
  - `barryvdh/laravel-dompdf` untuk konversi dokumen ke PDF.
  - `spatie/laravel-permission` untuk manajemen otorisasi Role-Based Access Control (RBAC).
  - `chart.js` untuk penyajian statistik pada dashboard.

---

## 📊 Rancangan Database (Schema)
Sistem memiliki struktur database yang optimal untuk menangani relasi antar entitas:
- `users`: Menyimpan data LAA dan Pengawas dengan role-based authentication.
- `baps`: Tabel utama penyimpan data Berita Acara Pemeriksaan.
- `bap_absents`: Relasi *One-to-Many* dari BAP untuk daftar ketidakhadiran.
- `bap_seats`: Relasi *One-to-Many* dari BAP untuk pemetaan denah tempat duduk.
- `prodis`: Master data Program Studi untuk pengelompokan laporan.

---

## 🔄 Alur Kerja (Workflow)
1. **Login**: Pengguna masuk sesuai role (LAA/Pengawas).
2. **Setup (LAA)**: Admin LAA menyiapkan akun pengawas dan master data program studi.
3. **Execution (Pengawas)**: Pengawas mengisi BAP setelah ujian, menambahkan data denah dan absensi. Status awal adalah `DRAFT`.
4. **Submission**: Pengawas melakukan `Submit`. Status berubah menjadi `PENDING`.
5. **Review (LAA)**: Admin LAA meninjau BAP. Status dapat berubah menjadi `APPROVED` atau `REJECTED`.
6. **Notification**: Pengawas menerima notifikasi hasil verifikasi. Jika ditolak, pengawas dapat melakukan revisi.
7. **Reporting (LAA)**: Admin LAA mengekspor data yang telah diverifikasi untuk kebutuhan arsip.

---

## 📸 Tampilan Aplikasi

### Panel Administrasi (LAA)
| | |
|---|---|
| ![Login Admin](public/admin/LoginAdmin.png) | ![Dashboard Admin](public/admin/DashboardAdmin.png) |
| ![Manajemen Pengawas](public/admin/ManajemenPengawas.png) | ![Manajemen BAP](public/admin/ManajemenBAP.png) |
| ![Detail BAP](public/admin/DetailBap.png) | ![Rekap & Export](public/admin/RekapitulasidanExport.png) |

### Panel Pengawas
| | |
|---|---|
| ![Login Pengawas](public/Pengawas/LoginPengawas.png) | ![Dashboard Pengawas](public/Pengawas/DashboardPengawas.png) |
| ![Input BAP](public/Pengawas/InputBAP.png) | ![Denah Tempat Duduk](public/Pengawas/DenahTempatDuduk.png) |
| ![Preview BAP](public/Pengawas/PreviewBAP.png) | ![Notifikasi](public/Pengawas/RiwayatNotifikasi.png) |

---

## ⚙️ Cara Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/repository.git
   cd repository
   ```

2. **Instalasi Dependensi**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Konfigurasi Lingkungan**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Sesuaikan pengaturan database di file `.env`.*

4. **Migrasi & Seed Database**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

