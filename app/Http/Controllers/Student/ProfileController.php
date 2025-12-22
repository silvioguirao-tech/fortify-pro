<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('aluno.profile', compact('user'));
    }

    public function enableTwoFactor(Request $request)
    {
        $user = $request->user();

        // Minimal local 2FA enabling for MVP: set a pseudo-secret, recovery codes and mark confirmed
        if (!$user->two_factor_enabled) {
            $user->two_factor_secret = bin2hex(random_bytes(10));
            $codes = [];
            for ($i = 0; $i < 8; $i++) {
                $codes[] = Str::random(10);
            }
            $user->two_factor_recovery_codes = json_encode($codes);
            $user->two_factor_confirmed_at = now();
            $user->two_factor_enabled = true;
            $user->save();
        }

        return redirect()->route('aluno.profile.edit')->with('status', '2fa-enabled');
    }

    public function disableTwoFactor(Request $request)
    {
        $user = $request->user();

        if ($user->two_factor_enabled) {
            $user->two_factor_secret = null;
            $user->two_factor_recovery_codes = null;
            $user->two_factor_confirmed_at = null;
            $user->two_factor_enabled = false;
            $user->save();
        }

        return redirect()->route('aluno.profile.edit')->with('status', '2fa-disabled');
    }
}
