<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\Roles;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    // public function test_email_verification_screen_can_be_rendered(): void
    // {
    //     $user = User::factory()->create([
    //         'email_verified_at' => null,
    //     ]);

    //     $response = $this->actingAs($user)->get('/verify-email');

    //     $response->assertStatus(200);
    // }

    // public function test_email_can_be_verified(): void
    // {
    //     $role = Role::factory()->create();
    //     $user = User::factory()->create([
    //         'role_id' => $role->role_id,
    //         'email_verified_at' => null,
    //     ]);

    //     Event::fake();
    //     Event::assertNotDispatched(Verified::class);

    //     $verificationUrl = URL::temporarySignedRoute(
    //         'email.verification.verify',
    //         now()->addMinutes(60),
    //         ['id' => $user->user_id, 'hash' => sha1($user->email)]
    //     );

    //     $response = $this->get($verificationUrl);

    //     Event::assertDispatched(Verified::class, function ($e) use ($user) {
    //         return $e->user->user_id === $user->user_id;
    //     });

    //     $this->assertTrue($user->fresh()->hasVerifiedEmail());

    //     $response->assertStatus(200);

    //     $response->assertJsonStructure([
    //         'code',
    //         'message',
    //         'timestamp',
    //     ]);

    // }

    // public function test_email_is_not_verified_with_invalid_hash(): void
    // {
    //     $role = Role::factory()->create();
    //     $user = User::factory()->create([
    //         'role_id' => $role->role_id,
    //         'email_verified_at' => null,
    //     ]);

    //     $verificationUrl = URL::temporarySignedRoute(
    //         'email.verification.verify',
    //         now()->addMinutes(60),
    //         ['id' => $user->user_id, 'hash' => sha1('wrong-email')]
    //     );

    //     $this->actingAs($user)->get($verificationUrl);

    //     $this->assertFalse($user->fresh()->hasVerifiedEmail());
    // }
}
