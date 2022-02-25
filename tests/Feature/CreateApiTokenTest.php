<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;
use Tests\TestCase;

class CreateApiTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testApiTokensCanBeCreated(): void
    {
        if (! Features::hasApiFeatures()) {
            $this->markTestSkipped('API support is not enabled.');
        }

        /** @var User $user */
        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        Livewire::test(ApiTokenManager::class)
            ->set([
                'createApiTokenForm' => [
                    'name'        => 'Test Token',
                    'permissions' => [
                        'read',
                        'update',
                    ],
                ],
            ])
            ->call('createApiToken');

        $user = $user->fresh();
        $this->assertNotNull($user);
        $this->assertCount(1, $user->tokens);
        $firstToken = $user->tokens->first();
        $this->assertNotNull($firstToken);
        $this->assertEquals('Test Token', $firstToken->name);
        $this->assertTrue($firstToken->can('read'));
        $this->assertFalse($firstToken->can('delete'));
    }
}
