<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class IsRestaurant
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = Auth::user();
        
        if (!$user || !$user->isRestaurant()) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Accès non autorisé.']);
        }

        return $next($request);
    }
}