<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $role = Role::factory()->create([
            'role_name' => 'admin'
        ]);
        $user = User::factory()->create([
            'role_id' => $role->role_id,
            'password' => '12345'
        ]);

        Log::info($user->password);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => '12345',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_api_can_authenticate(): void
    {
        $role = Role::factory()->create([
            'role_name' => 'admin'
        ]);
        $user = User::factory()->create([
            'role_id' => $role->role_id,
            'password' => 'password'
        ]);

        $response = $this->post('/api/v1/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'code',
            'message',
            'timestamp',
            'data' => [
                'token',
            ],
        ]);
    }

    public function test_users_can_not_authenticate_with_invalid_password() : void
    {
        $role = Role::factory()->create([
            'role_name' => 'admin'
        ]);
        $user = User::factory()->create([
            'role_id' => $role->role_id
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(302);
        $this->assertGuest();

    }

    public function test_users_api_can_not_authenticate_with_invalid_password(): void
    {
        $role = Role::factory()->create([
            'role_name' => 'admin'
        ]);
        $user = User::factory()->create([
            'role_id' => $role->role_id
        ]);

        $response = $this->post('/api/v1/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'code',
            'message',
            'timestamp',
        ]);
    }

    public function test_users_api_can_not_authenticate_with_invalid_username(): void
    {
        $role = Role::factory()->create([
            'role_name' => 'admin'
        ]);
        $user = User::factory()->create([
            'role_id' => $role->role_id
        ]);

        $response = $this->post('/api/v1/login', [
            'username' => 'wrong-username',
            'password' => 'password',
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'code',
            'message',
            'timestamp',
        ]);
    }

    public function test_users_api_can_not_authenticate_without_username(): void
    {
        $role = Role::factory()->create([
            'role_name' => 'admin'
        ]);
        $user = User::factory()->create([
            'role_id' => $role->role_id
        ]);

        $response = $this->post('/api/v1/login', [
            'password' => 'password',
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'code',
            'message',
            'timestamp',
            'errors',
        ]);
    }

    public function test_users_can_logout(): void
    {
        $role = Role::factory()->create([
            'role_name' => 'admin'
        ]);
        $user = User::factory()->create([
            'role_id' => $role->role_id
        ]);

        $response = $this->actingAs($user)->get('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
    public function test_users_api_can_logout(): void
    {
        $role = Role::factory()->create([
            'role_name' => 'admin'
        ]);
        $user = User::factory()->create([
            'role_id' => $role->role_id
        ]);

        $token = $user->createToken('TestToken')->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/v1/logout');

        $response->assertStatus(205);
        $response->assertJsonStructure([
            'code',
            'message',
            'timestamp',
        ]);
    }

    public function test_users_api_can_not_logout_without_token(): void
    {
        $response = $this->delete('/api/v1/logout');

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'code',
            'message',
            'timestamp',
        ]);
    }

    public function test_users_api_can_not_logout_with_invalid_token(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer invalid-token')->delete('/api/v1/logout');

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'code',
            'message',
            'timestamp',
        ]);
    }
}
