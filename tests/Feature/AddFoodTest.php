<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enum\Meal;
use App\Http\Livewire\AddFood;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AddFoodTest extends TestCase
{
    use RefreshDatabase;

    public function testShowsAddFoodLivewireComponentWhenUserHasAuthorization(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $meal = Meal::Breakfast;
        $date = now();

        $this->actingAs($user)
            ->get(route('food.add', [
                'meal' => $meal->value,
                'date' => $date->format('Y-m-d'),
            ]))
            ->assertSeeLivewire('add-food');
    }

    public function testFoodCanBeAddedForAGivenDate(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $meal = Meal::Breakfast;
        $date = now()->subDays(3);

        Livewire::actingAs($user)
            ->test(AddFood::class, [
                'meal' => $meal->value,
                'date' => $date->format('Y-m-d'),
            ])
            ->set('name', 'New name')
            ->set('calories', '100')
            ->set('carbs', '50')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('food', [
            'meal'     => $meal->value,
            'name'     => 'New name',
            'calories' => '100',
            'carbs'    => '50',
        ]);
    }

    public function testDoesNotShowAddFoodLivewireComponentWhenUserDoesNotHaveAuthorization(): void
    {
        $meal = Meal::Breakfast;
        $date = now();

        $this->get(route('food.add', [
            'meal' => $meal->value,
            'date' => $date->format('Y-m-d'),
        ]))
            ->assertDontSeeLivewire('add-food')
            ->assertRedirect();
    }

    public function testAddFoodFormValidationWorks(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $meal = Meal::Breakfast;
        $date = now()->format('Y-m-d');

        Livewire::actingAs($user)
            ->test(AddFood::class, [
                'meal' => $meal->value,
                'date' => $date,
            ])
            ->set('name', '')
            ->set('calories', '')
            ->set('carbs', '')
            ->call('submit')
            ->assertHasErrors([
                'name',
                'calories',
                'carbs',
            ])
            ->assertSee('The name field is required');
    }

    public function testAddingAFoodWorksWhenUserHasAuthorization(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $meal = Meal::Breakfast;
        $date = now();

        Livewire::actingAs($user)
            ->test(AddFood::class, [
                'meal' => $meal->value,
                'date' => $date->format('Y-m-d'),
            ])
            ->set('name', 'New name')
            ->set('calories', '100')
            ->set('carbs', '50')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('food', [
            'meal'     => $meal->value,
            'name'     => 'New name',
            'calories' => '100',
            'carbs'    => '50',
        ]);
    }

    public function testAddingAFoodDoesNotWorkWhenNotAuthenticated(): void
    {
        $meal = Meal::Breakfast;
        $date = now();

        Livewire::test(AddFood::class, [
            'meal' => $meal->value,
            'date' => $date->format('Y-m-d'),
        ])
            ->set('name', 'New name')
            ->set('calories', '100')
            ->set('carbs', '50')
            ->call('submit')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
