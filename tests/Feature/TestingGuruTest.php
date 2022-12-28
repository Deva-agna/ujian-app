<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestingGuruTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mengakses_halaman_list_guru()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'nip_nis' => $user->nip,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response =  $this->get('/guru');
        $response->assertStatus(200);
    }

    public function test_mengakses_halaman_tambah_guru()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'nip_nis' => $user->nip,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response =  $this->get('/guru/create');
        $response->assertStatus(200);
    }

    public function test_melakukan_penambahan_data_guru()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'nip_nis' => $user->nip,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->post('/guru/store', [
            'nama' => 'Deva Agna',
            'nip' => '062017106787',
            'email' => 'devaagna0909@gmail.com',
            'password' => 'password',
            'tanggal_lahir' => time(),
            'no_telpon' => '',
            'jenis_kelamin' => '',
            'alamat' => '',
            'image' => '',
        ]);
        $response->assertSessionHas('sukses');
        $response->assertRedirect(route('guru'));
    }

    public function test_melakukan_penambahan_data_guru_tetapi_data_tidak_valid()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'nip_nis' => $user->nip,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->post('/guru/store', [
            'nama' => 'Deva Agna',
            'nip' => '',
            'email' => 'devaagna0909@gmail.com',
            'password' => 'password',
            'tanggal_lahir' => time(),
            'no_telpon' => '',
            'jenis_kelamin' => '',
            'alamat' => '',
            'image' => '',
        ]);

        $response->assertSessionHasErrors('nip');
    }
}
