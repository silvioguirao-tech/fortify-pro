<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    public function test_admin_can_apply_two_factor_requirement_to_all(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // create users
        User::factory()->count(3)->create()->each(fn($u) => $u->assignRole('aluno'));

        Setting::set('require_2fa_for_all', '1');

        $response = $this->actingAs($admin)->post(route('admin.settings.apply_2fa'));
        $response->assertRedirect(route('admin.settings.index'));

        $this->assertDatabaseHas('settings', ['key' => 'require_2fa_for_all', 'value' => '1']);

        $this->assertDatabaseHas('admin_actions', ['action' => 'apply_require_2fa_to_all']);

        $this->assertEquals(3 + 1, \App\Models\User::where('two_factor_required', true)->count());
    }
}
