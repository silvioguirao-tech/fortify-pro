<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\AdminAction;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $require2fa = (bool) Setting::get('require_2fa_for_all', '0');
        $emailVerification = (bool) Setting::get('email_verification_required', '0');

        $actions = \App\Models\AdminAction::latest()->limit(50)->get();

        return view('admin.settings.index', compact('require2fa', 'emailVerification', 'actions'));
    }

    public function update(Request $request)
    {
        $this->authorize('update', auth()->user());

        $require2fa = $request->filled('require_2fa_for_all') ? '1' : '0';
        $emailVerification = $request->filled('email_verification_required') ? '1' : '0';

        Setting::set('require_2fa_for_all', $require2fa);
        Setting::set('email_verification_required', $emailVerification);

        AdminAction::create([
            'admin_id' => $request->user()->id,
            'action' => 'update_settings',
            'target_type' => 'settings',
            'target_id' => null,
            'meta' => ['require_2fa_for_all' => $require2fa, 'email_verification_required' => $emailVerification],
        ]);

        return redirect()->route('admin.settings.index');
    }
}
