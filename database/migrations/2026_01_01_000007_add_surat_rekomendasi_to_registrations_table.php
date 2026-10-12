<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('registrations', 'surat_rekomendasi_path')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->string('surat_rekomendasi_path')->nullable()->after('kecamatan');
            });
        }
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('surat_rekomendasi_path');
        });
    }
};
