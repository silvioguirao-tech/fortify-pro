<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user && method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }
}
