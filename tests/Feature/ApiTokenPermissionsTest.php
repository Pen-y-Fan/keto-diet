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

class ApiTokenPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function testApiTokenPermissionsCanBeUpdated(): void
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
                'managingPermissionsFor' => $token,
            ])
            ->set([
                'updateApiTokenForm' => [
                    'permissions' => [
                        'delete',
                        'missing-permission',
                    ],
                ],
            ])
            ->call('updateApiToken');

        $user = $user->fresh();
        $this->assertNotNull($user);
        $firstToken = $user->tokens->first();
        $this->assertNotNull($firstToken);
        $this->assertTrue($firstToken->can('delete'));
        $this->assertFalse($firstToken->can('read'));
        $this->assertFalse($firstToken->can('missing-permission'));
    }
}
