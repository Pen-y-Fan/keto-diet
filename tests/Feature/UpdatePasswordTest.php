<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Http\Livewire\UpdatePasswordForm;
use Livewire\Livewire;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testPasswordCanBeUpdated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(UpdatePasswordForm::class)
            ->set('state', [
                'current_password'      => 'password',
                'password'              => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->call('updatePassword');

        $updatedUser = $user->refresh();
        $this->assertNotNull($updatedUser);
        $this->assertTrue(Hash::check('new-password', $updatedUser->password));
    }

    public function testCurrentPasswordMustBeCorrect(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(UpdatePasswordForm::class)
            ->set('state', [
                'current_password'      => 'wrong-password',
                'password'              => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->call('updatePassword')
            ->assertHasErrors(['current_password']);

        $updatedUser = $user->refresh();
        $this->assertNotNull($updatedUser);
        $this->assertTrue(Hash::check('password', $updatedUser->password));
    }

    public function testNewPasswordsMustMatch(): void
    {

        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(UpdatePasswordForm::class)
            ->set('state', [
                'current_password'      => 'password',
                'password'              => 'new-password',
                'password_confirmation' => 'wrong-password',
            ])
            ->call('updatePassword')
            ->assertHasErrors(['password']);

        /** @var User $updatedUser */
        $updatedUser = $user->refresh();
        $this->assertNotNull($updatedUser);
        $this->assertTrue(Hash::check('password', $updatedUser->password));
    }
}
