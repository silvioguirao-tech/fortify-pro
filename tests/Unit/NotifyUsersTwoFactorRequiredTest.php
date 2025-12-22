<?php

namespace Tests\Unit;

use App\Jobs\NotifyUsersTwoFactorRequired;
use App\Mail\TwoFactorRequired;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Bus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotifyUsersTwoFactorRequiredTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    public function test_job_dispatched_when_apply_two_factor(): void
    {
        Bus::fake();

        \App\Models\Setting::set('require_2fa_for_all', '1');

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)->post(route('admin.settings.apply_2fa'));

        Bus::assertDispatched(NotifyUsersTwoFactorRequired::class);
    }

    public function test_job_handles_and_queues_mails(): void
    {
        Mail::fake();

        // Create 3 users without 2fa
        User::factory()->count(3)->create(['two_factor_enabled' => false])->each(fn($u) => $u->assignRole('aluno'));

        $job = new NotifyUsersTwoFactorRequired();
        $job->handle();

        Mail::assertQueued(TwoFactorRequired::class, 3);
    }
}
