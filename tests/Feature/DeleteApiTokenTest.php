<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteApiTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testApiTokensCanBeDeleted(): void
    {
        if (! Features::hasApiFeatures()) {
            $this->markTestSkipped('API support is not enabled.');
        }

        /** @var User $user */
        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        $token = $user->tokens()->create([
            'name'      => 'Test Token',
            'token'     => Str::random(40),
            'abilities' => ['create', 'read'],
        ]);

        Livewire::test(ApiTokenManager::class)
            ->set([
                /** @phpstan-ignore-next-line  */
                'apiTokenIdBeingDeleted' => $token->id,
            ])
            ->call('deleteApiToken');

        $user = $user->fresh();
        $this->assertNotNull($user);
        $this->assertCount(0, $user->tokens);
    }
}
