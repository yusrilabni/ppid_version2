<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'nip' => '123456789',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'nip' => '123456789',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'user' => [
                'id',
                'name',
                'email',
                'nip',
                'created_at',
                'updated_at',
            ],
            'token',
        ]);
    }

    /** @test */
    public function user_cannot_login_with_incorrect_credentials()
    {
        Http::fake([
            'http://apps.sinjaikab.go.id/api/pegawai/data_pegawai/*' => Http::response([
                'nip' => '123456789',
                'nama' => 'Local User',
                'password' => md5('correct-but-different-password'), // Simulate external API having a different password
            ], 200),
        ]);

        $user = User::factory()->create([
            'nip' => '123456789',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'nip' => '123456789',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function user_can_login_via_external_api_if_not_in_local_db()
    {
        Http::fake([
            'http://apps.sinjaikab.go.id/api/pegawai/data_pegawai/*' => Http::response([
                'nip' => '987654321',
                'nama' => 'External User',
                'password' => md5('password'),
            ], 200),
        ]);

        $response = $this->postJson('/api/login', [
            'nip' => '987654321',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'user' => [
                'id',
                'name',
                'email',
                'nip',
                'created_at',
                'updated_at',
            ],
            'token',
        ]);

        $this->assertDatabaseHas('users', [
            'nip' => '987654321',
            'name' => 'External User',
        ]);
    }

    /** @test */
    public function user_cannot_login_with_wrong_password_from_external_api()
    {
        Http::fake([
            'http://apps.sinjaikab.go.id/api/pegawai/data_pegawai/*' => Http::response([
                'nip' => '987654321',
                'nama' => 'External User',
                'password' => md5('password'),
            ], 200),
        ]);

        $response = $this->postJson('/api/login', [
            'nip' => '987654321',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function it_handles_external_api_failure()
    {
        Http::fake([
            'http://apps.sinjaikab.go.id/api/pegawai/data_pegawai/*' => Http::response(null, 500),
        ]);

        $response = $this->postJson('/api/login', [
            'nip' => '12345',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nip']);
    }
}
