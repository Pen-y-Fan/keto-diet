<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function testCurrentProfileInformationIsAvailable(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $component = Livewire::test(UpdateProfileInformationForm::class);

        $this->assertEquals($user->name, $component->state['name']);
        $this->assertEquals($user->email, $component->state['email']);
    }

    public function testProfileInformationCanBeUpdated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', [
                'name'  => 'Test Name',
                'email' => 'test@example.com',
            ])
            ->call('updateProfileInformation');

        $user = $user->fresh();
        $this->assertNotNull($user);
        $this->assertEquals('Test Name', $user->name);
        $this->assertEquals('test@example.com', $user->email);
    }
}
