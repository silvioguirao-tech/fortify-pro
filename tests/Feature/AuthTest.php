<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    public function test_registration_assigns_aluno_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Aluno Test',
            'email' => 'aluno@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/home');

        $this->assertDatabaseHas('users', ['email' => 'aluno@test.com']);

        $user = User::where('email', 'aluno@test.com')->first();
        $this->assertTrue($user->hasRole('aluno'));
    }

    public function test_login_redirects_admin_to_admin_dashboard(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_login_redirects_user_to_home(): void
    {
        $user = User::factory()->create();
        $user->assignRole('aluno');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
    }

    public function test_admin_routes_are_protected(): void
    {
        $user = User::factory()->create();
        $user->assignRole('aluno');

        // Aluno não deve acessar rota admin
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);

        // Admin pode acessar
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_login_view_renders(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Entrar');
        $response->assertSee('Registrar');
    }

    public function test_register_view_renders(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Criar conta');
        $response->assertSee('Entrar');
    }

    public function test_forgot_password_view_renders(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response->assertSee('Esqueceu a senha');
    }

    public function test_student_profile_and_2fa_toggle(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('aluno');

        // acessa profile
        $response = $this->actingAs($user)->get('/aluno/profile');
        $response->assertStatus(200);
        $response->assertSee('Meu Perfil');
        $response->assertSee('2FA está <strong>DESATIVADA</strong>');

        // habilitar 2FA
        $response = $this->actingAs($user)->post('/aluno/profile/2fa/enable');
        $response->assertRedirect(route('aluno.profile.edit'));

        $user->refresh();
        $this->assertTrue((bool) $user->two_factor_enabled);

        // when 2FA is required but not confirmed, user is redirected to /two-factor
        $user->two_factor_enabled = false;
        $user->two_factor_required = true;
        $user->save();

        $response = $this->actingAs($user)->get('/aluno');
        $response->assertRedirect(route('two-factor'));

        // desabilitar 2FA
        $response = $this->actingAs($user)->post('/aluno/profile/2fa/disable');
        $response->assertRedirect(route('aluno.profile.edit'));

        $user->refresh();
        $this->assertFalse((bool) $user->two_factor_enabled);
    }
}

