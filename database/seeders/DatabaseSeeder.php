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

        // 4. Teams (Existing Standing Teams)
        $teams = [
            ['name' => 'Antapani', 'kecamatan' => 'Antapani', 'group' => 'Grup A', 'p' => 3, 'w' => 2, 'd' => 1, 'l' => 0, 'gf' => 6, 'ga' => 2, 'gd' => 4, 'pts' => 7],
            ['name' => 'Coblong', 'kecamatan' => 'Coblong', 'group' => 'Grup A', 'p' => 3, 'w' => 2, 'd' => 0, 'l' => 1, 'gf' => 5, 'ga' => 3, 'gd' => 2, 'pts' => 6],
            ['name' => 'Lengkong', 'kecamatan' => 'Lengkong', 'group' => 'Grup A', 'p' => 3, 'w' => 1, 'd' => 0, 'l' => 2, 'gf' => 3, 'ga' => 5, 'gd' => -2, 'pts' => 3],
            ['name' => 'Andir', 'kecamatan' => 'Andir', 'group' => 'Grup A', 'p' => 3, 'w' => 0, 'd' => 1, 'l' => 2, 'gf' => 1, 'ga' => 5, 'gd' => -4, 'pts' => 1],

            ['name' => 'Sukajadi', 'kecamatan' => 'Sukajadi', 'group' => 'Grup B', 'p' => 3, 'w' => 3, 'd' => 0, 'l' => 0, 'gf' => 8, 'ga' => 1, 'gd' => 7, 'pts' => 9],
            ['name' => 'Arcamanik', 'kecamatan' => 'Arcamanik', 'group' => 'Grup B', 'p' => 3, 'w' => 1, 'd' => 1, 'l' => 1, 'gf' => 4, 'ga' => 4, 'gd' => 0, 'pts' => 4],
            ['name' => 'Cibeunying Kaler', 'kecamatan' => 'Cibeunying Kaler', 'group' => 'Grup B', 'p' => 3, 'w' => 1, 'd' => 0, 'l' => 2, 'gf' => 3, 'ga' => 6, 'gd' => -3, 'pts' => 3],
            ['name' => 'Batununggal', 'kecamatan' => 'Batununggal', 'group' => 'Grup B', 'p' => 3, 'w' => 0, 'd' => 1, 'l' => 2, 'gf' => 2, 'ga' => 6, 'gd' => -4, 'pts' => 1],
        ];

        $teamModels = [];
        foreach ($teams as $t) {
            $teamModels[$t['name']] = Team::create([
                'name' => $t['name'],
                'kecamatan' => $t['kecamatan'],
                'group_name' => $t['group'],
                'played' => $t['p'],
                'won' => $t['w'],
                'drawn' => $t['d'],
                'lost' => $t['l'],
                'goals_for' => $t['gf'],
                'goals_against' => $t['ga'],
                'goal_difference' => $t['gd'],
                'points' => $t['pts'],
            ]);
        }

        // 5. Matches
        GameMatch::create([
            'home_team_id' => $teamModels['Antapani']->id,
            'away_team_id' => $teamModels['Coblong']->id,
            'match_date' => now()->subDays(4)->setTime(15, 30),
            'venue' => 'Stadion Siliwangi Bandung',
            'home_score' => 2,
            'away_score' => 1,
            'status' => 'Selesai',
            'stage' => 'Grup A - Pekan 1',
        ]);

        GameMatch::create([
            'home_team_id' => $teamModels['Lengkong']->id,
            'away_team_id' => $teamModels['Andir']->id,
            'match_date' => now()->subDays(4)->setTime(19, 00),
            'venue' => 'Stadion Siliwangi Bandung',
            'home_score' => 2,
            'away_score' => 0,
            'status' => 'Selesai',
            'stage' => 'Grup A - Pekan 1',
        ]);

        GameMatch::create([
            'home_team_id' => $teamModels['Sukajadi']->id,
            'away_team_id' => $teamModels['Arcamanik']->id,
            'match_date' => now()->subDays(3)->setTime(15, 30),
            'venue' => 'Stadion GBLA Bandung',
            'home_score' => 3,
            'away_score' => 0,
            'status' => 'Selesai',
            'stage' => 'Grup B - Pekan 1',
        ]);

        // Upcoming Matches
        GameMatch::create([
            'home_team_id' => $teamModels['Antapani']->id,
            'away_team_id' => $teamModels['Sukajadi']->id,
            'match_date' => now()->addDays(2)->setTime(15, 30),
            'venue' => 'Stadion Siliwangi Bandung',
            'home_score' => null,
            'away_score' => null,
            'status' => 'Mendatang',
            'stage' => 'Semi Final 1',
            'notes' => 'Pertandingan Sengit Perebutan Tiket Final',
        ]);

        GameMatch::create([
            'home_team_id' => $teamModels['Coblong']->id,
            'away_team_id' => $teamModels['Arcamanik']->id,
            'match_date' => now()->addDays(3)->setTime(19, 00),
            'venue' => 'Stadion GBLA Bandung',
            'home_score' => null,
            'away_score' => null,
            'status' => 'Mendatang',
            'stage' => 'Semi Final 2',
        ]);

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
