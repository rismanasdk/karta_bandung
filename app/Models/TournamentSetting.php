<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'registration_schedule',
        'tournament_dates',
        'location',
        'total_prize',
        'rules',
        'registration_status',
    ];

    public static function getSettings()
    {
        return static::first() ?? static::create([
            'name' => "KARTA.BDG Men's Football Cup 2026",
            'logo' => null,
            'registration_schedule' => '12 Oktober 2026 - 01 November 2026',
            'tournament_dates' => '30 November 2026 - 06 Desember 2026',
            'location' => 'Stadion Lodaya Bandung',
            'total_prize' => 'Rp 50.000.000 + Piala Bergilir',
            'rules' => "1. Peserta merupakan warga asli/domisili Kecamatan di Kota Bandung.\n2. Wajib melampirkan foto KTP dan Pas Foto terbaru.\n3. Usia minimal peserta adalah 18 tahun (Kategori Pria/Men's).\n4. Keputusan panitia dan wasit bersifat mutlak.",
            'registration_status' => 'Buka',
        ]);
    }
}
