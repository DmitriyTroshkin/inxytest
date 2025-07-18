<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_update() {
        $user = User::factory()->create();
        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Новое имя',
            'email' => 'new@example.com',
            'age' => 35,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Новое имя',
            'email' => 'new@example.com',
            'age' => 35,
        ]);
    }

    public function test_deposit() {
        $user = User::factory()->create(['balance' => 0]);
        $response = $this->postJson("/api/users/{$user->id}/deposit", ['amount' => 100]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'balance' => 10000]);
    }

    public function test_transfer_and_overdraft() {
        $u1 = User::factory()->create(['balance' => 22500]);
        $u2 = User::factory()->create(['balance' => 54500]);

        $response = $this->postJson("/api/users/transfer", [
            'from_user_id' => $u1->id,
            'to_user_id' => $u2->id,
            'amount' => 125,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => $u1->id, 'balance' => 10000]);
        $this->assertDatabaseHas('users', ['id' => $u2->id, 'balance' => 67000]);

        // Перевод суммы больше баланса
        $response2 = $this->postJson("/api/users/transfer", [
            'from_user_id' => $u1->id,
            'to_user_id' => $u2->id,
            'amount' => 500,
        ]);
        $response2->assertStatus(500);
    }
}