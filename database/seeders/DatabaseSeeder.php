<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Registration;
use App\Models\Team;
use App\Models\GameMatch;
use App\Models\News;
use App\Models\TournamentSetting;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Settings
        TournamentSetting::getSettings();

        // 2. Admin User
        $admin = User::create([
            'name' => 'Administrator Utama',
            'email' => 'admin@karta-bdg.id',
            'phone' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
        ]);

        // 3. List 30 Kecamatan se-Kota Bandung
        $kecamatanList = [
            'Andir', 'Antapani', 'Arcamanik', 'Astana Anyar', 'Babakan Ciparay',
            'Bandung Kidul', 'Bandung Kulon', 'Bandung Wetan', 'Batununggal', 'Bojongloa Kaler',
            'Bojongloa Kidul', 'Buahbatu', 'Cibeunying Kaler', 'Cibeunying Kidul', 'Cibiru',
            'Cicendo', 'Cidadap', 'Cinambo', 'Coblong', 'Gedebage',
            'Kiaracondong', 'Lengkong', 'Mandalajati', 'Panyileukan', 'Rancasari',
            'Regol', 'Sukajadi', 'Sukasari', 'Sumur Bandung', 'Ujungberung'
        ];

        $kecamatanUsers = [];
        foreach ($kecamatanList as $idx => $kec) {
            $slug = Str::slug($kec, '');
            $email = $slug . '@karta-bdg.id';

            $user = User::create([
                'name' => 'Official Kec. ' . $kec,
                'email' => $email,
                'phone' => '08' . rand(1000000000, 9999999999),
                'role' => 'user',
                'password' => Hash::make('12345678'),
            ]);

            $kecamatanUsers[$kec] = $user;
        }

        // 4. Teams & Matches dikosongkan karena data riil belum tersedia
        // Tim dan jadwal akan dibuat saat pendaftaran/verifikasi atau diinput oleh panitia/admin.

        // 6. News & Announcements
        News::create([
            'title' => 'Pendaftaran Akun 30 Kontingen Kecamatan Telah Diterbitkan',
            'slug' => Str::slug('Pendaftaran Akun 30 Kontingen Kecamatan Telah Diterbitkan'),
            'category' => 'Pengumuman',
            'summary' => 'Panitia telah menerbitkan akun resmi untuk 30 Kecamatan se-Kota Bandung. Silakan login untuk melengkapi data kontingen.',
            'content' => "<p>Panitia Pelaksana KARTA.BDG dengan bangga mengumumkan bahwa akun resmi 30 Kecamatan se-Kota Bandung telah siap. Setiap perwakilan kontingen kecamatan dapat login menggunakan email kecamatan masing-masing dengan kata sandi default <strong>12345678</strong>.</p>",
            'is_published' => true,
            'published_at' => now()->subDays(5),
            'created_by' => $admin->id,
        ]);

        News::create([
            'title' => 'Jadwal Verifikasi Dokumen & Technical Meeting',
            'slug' => Str::slug('Jadwal Verifikasi Dokumen dan Technical Meeting'),
            'category' => 'Berita',
            'summary' => 'Verifikasi dokumen berlangsung tgl 2 Nov s/d 10 Nov 2026. Technical meeting diadakan di Aula Balai Kota Bandung.',
            'content' => "<p>Verifikasi pemain berlangsung tgl 2 Nov s/d 10 Nov 2026. Technical Meeting (TM) untuk perwakilan tim akan diadakan di Aula Balai Kota Bandung.</p>",
            'is_published' => true,
            'published_at' => now()->subDays(2),
            'created_by' => $admin->id,
        ]);

        // 7. Notifications
        Notification::create([
            'user_id' => $kecamatanUsers['Antapani']->id,
            'title' => 'Pendaftaran Terverifikasi',
            'message' => 'Selamat! Berkas pendaftaran Kontingen Antapani telah disetujui oleh Panitia KARTA.BDG.',
            'type' => 'success',
            'is_read' => false, 
        ]);
    }
}
