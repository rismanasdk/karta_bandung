<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournament_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default("KARTA.BDG Men's Football Cup 2026");
            $table->string('logo')->nullable();
            $table->string('registration_schedule')->default('10 Oktober 2026 - 31 Oktober 2026');
            $table->string('tournament_dates')->default('10 November 2026 - 05 Desember 2026');
            $table->string('location')->default('Lapangan sepak bola Lodaya Bandung');
            $table->string('total_prize')->default('Rp 50.000.000');
            $table->text('rules')->nullable();
            $table->string('registration_status')->default('Buka'); // Buka, Tutup, Segera
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_settings');
    }
};
