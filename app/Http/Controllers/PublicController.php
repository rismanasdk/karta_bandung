<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\News;
use App\Models\Team;
use App\Models\TournamentSetting;

class PublicController extends Controller
{
    public function beranda()
    {
        $settings = TournamentSetting::getSettings();
        $upcomingMatches = GameMatch::with(['homeTeam', 'awayTeam'])
            ->where('status', 'Mendatang')
            ->orderBy('match_date')
            ->take(3)
            ->get();
        $recentMatches = GameMatch::with(['homeTeam', 'awayTeam'])
            ->where('status', 'Selesai')
            ->orderByDesc('match_date')
            ->take(3)
            ->get();
        $standings = Team::orderByDesc('points')
            ->orderByDesc('goal_difference')
            ->orderByDesc('goals_for')
            ->take(6)
            ->get();
        $news = News::where('is_published', true)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('public.beranda', compact('settings', 'upcomingMatches', 'recentMatches', 'standings', 'news'));
    }

    public function tentang()
    {
        $settings = TournamentSetting::getSettings();
        return view('public.tentang', compact('settings'));
    }

    public function jadwal()
    {
        $settings = TournamentSetting::getSettings();
        $matches = GameMatch::with(['homeTeam', 'awayTeam'])
            ->orderBy('match_date')
            ->get()
            ->groupBy('stage');
        return view('public.jadwal', compact('settings', 'matches'));
    }

    public function hasilKlasemen()
    {
        $settings = TournamentSetting::getSettings();
        $finishedMatches = GameMatch::with(['homeTeam', 'awayTeam'])
            ->where('status', 'Selesai')
            ->orderByDesc('match_date')
            ->get();
        $groupA = Team::where('group_name', 'Grup A')
            ->orderByDesc('points')->orderByDesc('goal_difference')->get();
        $groupB = Team::where('group_name', 'Grup B')
            ->orderByDesc('points')->orderByDesc('goal_difference')->get();
        $standings = Team::orderByDesc('points')
            ->orderByDesc('goal_difference')
            ->orderByDesc('goals_for')
            ->get()
            ->groupBy('group_name');

        return view('public.hasil-klasemen', compact('settings', 'finishedMatches', 'standings', 'groupA', 'groupB'));
    }

    public function berita()
    {
        $settings = TournamentSetting::getSettings();
        $news = News::where('is_published', true)
            ->orderByDesc('published_at')
            ->paginate(9);
        return view('public.berita', compact('settings', 'news'));
    }

    public function beritaDetail($slug)
    {
        $settings = TournamentSetting::getSettings();
        $article = News::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $relatedNews = News::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();
        return view('public.berita-detail', compact('settings', 'article', 'relatedNews'));
    }
}
