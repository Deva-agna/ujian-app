<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_mengakses_halaman_login()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_pengujian_login_admin()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'nip_nis' => $user->nip,
            'password' => 'password',
        ]);

        // $response->assertStatus(200);
        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard/admin');
    }

    public function test_pengujian_jika_admin_gagal_login()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'nip_nis' => $user->nip,
            'password' => 'password-salah',
        ]);

        $this->assertGuest();
    }
}
