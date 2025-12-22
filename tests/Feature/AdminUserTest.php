<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    public function test_admin_can_toggle_email_verification(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $user = User::factory()->create(['email_verified_at' => null]);

        $response = $this->actingAs($admin)->post(route('admin.users.toggle_email_verification', $user));
        $response->assertRedirect(route('admin.users.index'));

        $user->refresh();
        $this->assertNotNull($user->email_verified_at);

        // toggle off
        $response = $this->actingAs($admin)->post(route('admin.users.toggle_email_verification', $user));
        $response->assertRedirect(route('admin.users.index'));

        $user->refresh();
        $this->assertNull($user->email_verified_at);
    }

    public function test_admin_can_toggle_two_factor_for_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $user = User::factory()->create(['two_factor_enabled' => false]);

        $response = $this->actingAs($admin)->post(route('admin.users.toggle_two_factor', $user));
        $response->assertRedirect(route('admin.users.index'));

        $user->refresh();
        $this->assertTrue((bool) $user->two_factor_enabled);
        $this->assertNotNull($user->two_factor_secret);
        $this->assertNotNull($user->two_factor_recovery_codes);

        // toggle off
        $response = $this->actingAs($admin)->post(route('admin.users.toggle_two_factor', $user));
        $response->assertRedirect(route('admin.users.index'));

        $user->refresh();
        $this->assertFalse((bool) $user->two_factor_enabled);
        $this->assertNull($user->two_factor_secret);
    }
}
