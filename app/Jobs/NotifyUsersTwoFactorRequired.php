<?php

namespace App\Jobs;

use App\Mail\TwoFactorRequired;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUsersTwoFactorRequired implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send mail to users who don't have confirmed 2FA
        User::where(function ($q) {
            $q->whereNull('two_factor_enabled')->orWhere('two_factor_enabled', false)->orWhereNull('two_factor_confirmed_at');
        })->chunk(200, function ($users) {
            foreach ($users as $user) {
                try {
                    Mail::to($user)->queue(new TwoFactorRequired($user));
                } catch (\Throwable $e) {
                    // swallow exceptions to avoid failing whole batch
                }
            }
        });
    }
}
