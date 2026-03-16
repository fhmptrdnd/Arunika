<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            User::where('id', Auth::user()->id)->update([
                'last_seen_at' => Carbon::now()
            ]);
        }

        return $next($request);
    }
}
