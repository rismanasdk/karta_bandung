<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->enum('tipe', ['pemain', 'official']);
            $table->string('full_name');
            $table->string('nik', 16);
            $table->date('tanggal_lahir');
            $table->string('posisi')->nullable();          // untuk pemain
            $table->integer('nomor_punggung')->nullable();  // untuk pemain
            $table->string('jabatan')->nullable();          // untuk official (Pelatih, Asisten, Manajer, dll.)
            $table->string('ktp_path')->nullable();
            $table->string('kk_path')->nullable();          // Kartu Keluarga
            $table->string('pasfoto_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_members');
    }
};
