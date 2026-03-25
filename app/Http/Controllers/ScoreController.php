<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'xp' => 'required|integer',
                'true_answers' => 'required|integer',
                'mapel' => 'required|string',
                'kelas' => 'required|string',
                'level' => 'required',
            ]);

            Score::create([
                'user_id' => Auth::id() ?? 1,
                'xp' => $data['xp'],
                'true_answers' => $data['true_answers'],
                'mapel' => $data['mapel'],
                'kelas' => $data['kelas'],
                // 'level' => $data['level'],
                'level' => $data['level'],
                'literasi' => $request->literasi,
                'logika' => $request->logika,
                'visual' => $request->visual,
                'english' => $request->english,
                'numerasi' => $request->numerasi,
            ]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
