<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Livewire\EditFood;
use App\Models\Food;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class EditFoodTest extends TestCase
{
    use RefreshDatabase;

    public function testShowsEditFoodLivewireComponentWhenUserHasAuthorization(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Food $food */
        $food = Food::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->get(route('food.edit', $food))
            ->assertSeeLivewire('edit-food');
    }

    public function testDoesNotShowEditFoodLivewireComponentWhenUserDoesNotHaveAuthorization(): void
    {
        /** @var Food $food */
        $food = Food::factory()->create();

        $this->get(route('food.edit', $food))
            ->assertDontSeeLivewire('edit-food');
    }

    public function testEditFoodFormValidationWorks(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Food $food */
        $food = Food::factory()->create([
            'user_id' => $user->id,
        ]);

        Livewire::actingAs($user)
            ->test(EditFood::class, [
                'food' => $food,
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

    public function testEditingAnFoodWorksWhenUserHasAuthorization(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Food $food */
        $food = Food::factory()->create([
            'user_id' => $user->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(EditFood::class, [
                'food' => $food,
            ])
            ->set('name', 'Updated name')
            ->set('calories', '100')
            ->set('carbs', '50');

        try {
            $component->call('submit');
        } catch (\RuntimeException $e) {
            if ($e->getMessage() !== 'Session store not set on request.') {
                throw $e;
            }
            // ignore the exception as 'Livewire' test method doesn't have a session.
        }

        $component
            ->assertHasNoErrors();

        $this->assertDatabaseHas('food', [
            'id'       => $food->id,
            'name'     => 'Updated name',
            'calories' => '100',
            'carbs'    => '50',
        ]);
    }

    public function testEditingAnFoodDoesNotWorkWhenEditingAnotherUsersFood(): void
    {
        /** @var User $correctUser */
        $correctUser = User::factory()->create();
        /** @var User $badUser */
        $badUser = User::factory()->create();
        /** @var Food $food */
        $food = Food::factory()->create([
            'user_id' => $correctUser->id,
        ]);

        Livewire::actingAs($badUser)
            ->test(EditFood::class, [
                'food' => $food,
            ])
            ->set('name', 'Updated name')
            ->set('calories', '100')
            ->set('carbs', '50')
            ->call('submit')
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('food', [
            'id'       => $food->id,
            'name'     => $food->name,
            'calories' => $food->calories,
            'carbs'    => $food->carbs,
        ]);
    }

    public function testEditFoodLivewireComponentWhenUserHasAuthorizationTheUserCanDeleteTheirFood(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Food $food */
        $food = Food::factory()->create([
            'user_id' => $user->id,
        ]);
//        $this->actingAs($user);

        $this->assertDatabaseCount(Food::class, 1);

        $component = Livewire::actingAs($user)
            ->test(EditFood::class, [
                'food' => $food,
            ]);

        try {
            $component
                ->call('deleteFood');
        } catch (\RuntimeException $e) {
            if ($e->getMessage() !== 'Session store not set on request.') {
                throw $e;
            }
            // ignore the exception as 'Livewire' test method doesn't have a session.
        }

        $this->assertDatabaseCount(Food::class, 0);
    }

    public function testAnotherUserCanNotDeleteSomeoneElseFood(): void
    {
        /** @var User $foodOwner */
        $foodOwner = User::factory()->create();
        /** @var User $anotherUser */
        $anotherUser = User::factory()->create();
        /** @var Food $food */
        $food = Food::factory()->create([
            'user_id' => $foodOwner->id,
        ]);

        Livewire::actingAs($anotherUser)
            ->test(EditFood::class, [
                'food' => $food,
            ])
            ->call('deleteFood')
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('food', [
            'id'       => $food->id,
            'name'     => $food->name,
            'calories' => $food->calories,
            'carbs'    => $food->carbs,
        ]);
    }
}
