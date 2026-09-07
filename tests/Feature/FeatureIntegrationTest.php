<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureIntegrationTest extends TestCase
{
    public function test_guest_is_redirected_from_protected_routes(): void
    {
        $response = $this->get('/user/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/guru/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_user_cannot_access_guru_or_admin_routes(): void
    {
        $user = User::factory()->make([
            'id' => 999,
            'role' => 'user',
        ]);

        $this->actingAs($user)->get('/admin/dashboard')->assertRedirect('/')->assertSessionHas('error', 'Akses ditolak.');
        $this->actingAs($user)->get('/guru/dashboard')->assertRedirect('/')->assertSessionHas('error', 'Akses ditolak.');
    }
}
