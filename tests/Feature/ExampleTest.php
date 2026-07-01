<?php

use App\Models\User;

test('authenticated users can create todos through the api', function () {
    $user = User::factory()->create();

    // NOTE TO SELF:
    // Laravel disables CSRF protection automatically while running tests:
    // https://laravel.com/docs/13.x/csrf#x-csrf-token
    // That makes an explicit withoutMiddleware(VerifyCsrfToken::class) unnecessary here.
    $response = $this
        ->actingAs($user)
        ->postJson('/api/todo', [
            'todo' => 'Buy milk',
        ]);

    $response->assertCreated()
        ->assertJsonPath('title', 'Buy milk')
        ->assertJsonPath('completed', false)
        ->assertJsonPath('user_id', $user->id);

    $this->assertDatabaseHas('todos', [
        'title' => 'Buy milk',
        'completed' => false,
        'user_id' => $user->id,
    ]);
});
