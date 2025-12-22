<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

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
}
