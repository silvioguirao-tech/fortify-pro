<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user.view')->only('index');
        $this->middleware('permission:user.create')->only('create', 'store');
        $this->middleware('permission:user.edit')->only('edit', 'update', 'toggleTwoFactor', 'toggleEmailVerification');
        $this->middleware('permission:user.delete')->only('destroy');
    }

    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    public function toggleTwoFactor(User $user)
    {
        if ($user->two_factor_enabled) {
            // disable
            $user->two_factor_secret = null;
            $user->two_factor_recovery_codes = null;
            $user->two_factor_confirmed_at = null;
            $user->two_factor_enabled = false;
            $user->save();

            AdminAction::create([
                'admin_id' => auth()->id(),
                'action' => 'disable_two_factor',
                'target_type' => 'user',
                'target_id' => $user->id,
                'meta' => null,
            ]);
        } else {
            // enable minimal: generate secret and recovery codes (encrypted)
            $secret = bin2hex(random_bytes(10));
            $codes = [];
            for ($i = 0; $i < 8; $i++) {
                $codes[] = \Illuminate\Support\Str::random(10);
            }
            $user->two_factor_secret = encrypt($secret);
            $user->two_factor_recovery_codes = encrypt(json_encode($codes));
            $user->two_factor_confirmed_at = now();
            $user->two_factor_enabled = true;
            $user->save();

            AdminAction::create([
                'admin_id' => auth()->id(),
                'action' => 'enable_two_factor',
                'target_type' => 'user',
                'target_id' => $user->id,
                'meta' => null,
            ]);
        }

        return redirect()->route('admin.users.index');
    }

    public function toggleEmailVerification(User $user)
    {
        if ($user->email_verified_at) {
            $user->email_verified_at = null;
            AdminAction::create([
                'admin_id' => auth()->id(),
                'action' => 'unverify_email',
                'target_type' => 'user',
                'target_id' => $user->id,
                'meta' => null,
            ]);
        } else {
            $user->email_verified_at = now();
            AdminAction::create([
                'admin_id' => auth()->id(),
                'action' => 'verify_email',
                'target_type' => 'user',
                'target_id' => $user->id,
                'meta' => null,
            ]);
        }

        $user->save();

        return redirect()->route('admin.users.index');
    }
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        if ($request->filled('role')) {
            $user->assignRole($request->input('role'));
        }

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required'
        ]);

        $user->update($data);
        $user->syncRoles([$data['role']]);

        return redirect()->route('admin.users.index');
    }
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required'
        ]);

        $user->update($data);

        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index');
    }
}
