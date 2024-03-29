<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Teste la création d'un utilisateur avec des données valides.
     *
     * @return void
     */
    public function test_register_user_with_valid_data()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure(['user', 'token']);
    }

    /**
     * Teste la connexion d'un utilisateur avec des identifiants valides.
     *
     * @return void
     */
    public function test_login_user_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * Teste la déconnexion d'un utilisateur authentifié.
     *
     * @return void
     */
    public function test_logout_authenticated_user()
    {
        $user = User::factory()->create();

        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);
    }
}
