<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('baps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Creator (Pengawas)
            $table->string('mata_kuliah');
            $table->string('kode_mk');
            $table->string('ruang_ujian');
            $table->string('tahun_ajaran');
            $table->string('hari_ujian');
            $table->date('tanggal_ujian');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->integer('jumlah_peserta');
            $table->integer('jumlah_tidak_hadir');
            $table->text('catatan_peristiwa');
            $table->string('pengawas_1');
            $table->string('pengawas_2')->nullable();
            $table->string('lampiran')->nullable();
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->text('catatan_admin')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baps');
    }
};
