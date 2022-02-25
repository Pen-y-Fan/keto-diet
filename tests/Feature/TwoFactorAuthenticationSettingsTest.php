<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TwoFactorAuthenticationForm;
use Livewire\Livewire;
use Tests\TestCase;

class TwoFactorAuthenticationSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function testTwoFactorAuthenticationCanBeEnabled(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->withSession([
            'auth.password_confirmed_at' => time(),
        ]);

        Livewire::test(TwoFactorAuthenticationForm::class)
            ->call('enableTwoFactorAuthentication');

        $user = $user->fresh();

        $this->assertNotNull($user);
        $this->assertNotNull($user->two_factor_secret);
        $this->assertCount(8, $user->recoveryCodes());
    }

    public function testRecoveryCodesCanBeRegenerated(): void
    {

        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->withSession([
            'auth.password_confirmed_at' => time(),
        ]);

        $component = Livewire::test(TwoFactorAuthenticationForm::class)
            ->call('enableTwoFactorAuthentication')
            ->call('regenerateRecoveryCodes');

        $user = $user->fresh();

        $component->call('regenerateRecoveryCodes');

        $this->assertNotNull($user);
        $this->assertCount(8, $user->recoveryCodes());

        $originalUserCodes = $user->recoveryCodes();
        $user              = $user->fresh();
        $this->assertNotNull($user);
        $this->assertCount(8, array_diff($originalUserCodes, $user->recoveryCodes()));
    }

    public function testTwoFactorAuthenticationCanBeDisabled(): void
    {

        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->withSession([
            'auth.password_confirmed_at' => time(),
        ]);

        $component = Livewire::test(TwoFactorAuthenticationForm::class)
            ->call('enableTwoFactorAuthentication');

        $user = $user->fresh();
        $this->assertNotNull($user);
        $this->assertNotNull($user->two_factor_secret);

        $component->call('disableTwoFactorAuthentication');

        $user = $user->fresh();
        $this->assertNotNull($user);
        $this->assertNull($user->two_factor_secret);
    }
}
