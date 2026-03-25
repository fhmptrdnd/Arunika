<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\PlacementResult;

class IsPlacementDone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
    
        if ($user && $user->role === 'student') {
            $sudah = PlacementResult::where('student_id', $user->id)->exists();
            if (!$sudah) {
                return redirect()->route('placement.intro');
            }
        }
    
        return $next($request);
    }
}
