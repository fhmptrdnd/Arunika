<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Score;
use App\Models\PlacementResult;

class ParentController extends Controller
{
    // 1. BERANDA (DASHBOARD)
    public function dashboard()
    {
        $parent = Auth::user();
        // Ambil data anak-anak yang terhubung dengan orang tua ini
        $children = $parent->children;

        return view('parent.dashboard', compact('parent', 'children'));
    }

    // 2. RIWAYAT & CAPAIAN
    public function riwayat(Request $request)
    {
        $parent = Auth::user();
        $children = $parent->children;

        // Tentukan anak mana yang sedang dilihat (Default: anak pertama)
        $selectedChildId = $request->query('child_id', $children->first()->id ?? null);
        $selectedChild = $children->where('id', $selectedChildId)->first();

        // Ambil riwayat bermain/belajar terbaru anak tersebut
        $riwayat = collect();
        if ($selectedChild) {
            $riwayat = Score::where('user_id', $selectedChild->id)
                            ->orderBy('created_at', 'desc')
                            ->get();
        }

        return view('parent.riwayat', compact('children', 'selectedChild', 'riwayat'));
    }

    // 3. PERKEMBANGAN
    public function perkembangan(Request $request)
    {
        $parent = Auth::user();
        $children = $parent->children;

        // Tentukan anak mana yang sedang dilihat
        $selectedChildId = $request->query('child_id', $children->first()->id ?? null);
        $selectedChild = $children->where('id', $selectedChildId)->first();

        $placementScore = null;
        $semuaSkor = collect();
        $kognitif = [];

        if ($selectedChild) {
            // A. Mapel Utama (Placement Test)
            $placementResult = PlacementResult::where('student_id', $selectedChild->id)->first();
            $topSubjectRaw = $placementResult ? $placementResult->top_subject : null;
            $placementScore = $topSubjectRaw ? str_replace('_', ' ', ucwords($topSubjectRaw)) : null;

            // B. Mapel Lainnya (Progress)
            $semuaSkor = Score::where('user_id', $selectedChild->id)
                ->selectRaw('mapel, COUNT(DISTINCT level) as level_selesai, AVG(true_answers) as akurasi')
                ->groupBy('mapel')
                ->get();

            // C. Kognitif (Rata-rata)
            $rataKognitif = Score::where('user_id', $selectedChild->id)
                ->selectRaw('AVG(literasi) as lit, AVG(logika) as log, AVG(visual) as vis, AVG(english) as eng, AVG(numerasi) as num')
                ->first();

            $kognitif = [
                'Literasi' => ['score' => round($rataKognitif->lit ?? 0), 'color' => '#12A0D7', 'icon' => '📖'],
                'Logika'   => ['score' => round($rataKognitif->log ?? 0), 'color' => '#FBDF54', 'icon' => '🧩'],
                'Visual'   => ['score' => round($rataKognitif->vis ?? 0), 'color' => '#F04F52', 'icon' => '👁️'],
                'Bahasa'   => ['score' => round($rataKognitif->eng ?? 0), 'color' => '#6670FF', 'icon' => '💬'],
                'Numerasi' => ['score' => round($rataKognitif->num ?? 0), 'color' => '#05A660', 'icon' => '🔢'],
            ];
        }

        return view('parent.perkembangan', compact(
            'children', 'selectedChild', 'placementScore', 'semuaSkor', 'kognitif'
        ));
    }

    public function storeChild(Request $request)
    {
        $parent = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'kelas'    => 'required|string',
        ], [
            'username.unique' => 'Username ini sudah dipakai, coba tambahkan angka di belakangnya.',
            'kelas.required'  => 'Mohon pilih kelas anak Anda.'
        ]);

        $child = User::create([
            'name'        => $request->name,
            'username'    => $request->username,
            'kelas'       => $request->kelas,
            'role'        => 'student',
            'password'    => $parent->password,
            'school_name' => $parent->school_name,
            'school_code' => $parent->school_code,
            'parent_id'   => $parent->id,
        ]);

        return redirect()->back()->with('success', 'Hore! Akun anak berhasil ditambahkan.');
    }

    public function updateSchoolCode(Request $request)
    {
        $request->validate([
            'school_code' => 'required|string|max:50'
        ]);

        $parent = Auth::user();
        $newCode = strtoupper(trim($request->school_code));

        $parent->update([
            'school_code' => $newCode
        ]);

        \App\Models\User::where('parent_id', $parent->id)->update([
            'school_code' => $newCode
        ]);

        return redirect()->back()->with('success', 'Kode sekolah berhasil disimpan dan disinkronkan ke akun anak!');
    }
}
