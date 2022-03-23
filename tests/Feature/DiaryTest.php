<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Livewire\Diary;
use App\Models\Food;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DiaryTest extends TestCase
{
    use RefreshDatabase;

    public function testShowsDiaryLivewireComponentWhenUserHasAuthorization(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Food::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->get(route('diary'))
            ->assertSeeLivewire('diary');
    }

    public function testDoesNotShowDiaryLivewireComponentWhenUserDoesNotHaveAuthorization(): void
    {
        Food::factory()->create();

        $this->get(route('diary'))
            ->assertDontSeeLivewire('diary')
            ->assertRedirect();
    }

    public function testShowsDiaryLivewireComponentWithTotalCaloriesAndCarbs(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Collection<int, Food> $foods */
        $foods = Food::factory(3)->create([
            'user_id' => $user->id,
            'date'    => Carbon::now()->format('Y-m-d'),
        ]);

        $firstFood = $foods->first();
        $this->assertInstanceOf(Food::class, $firstFood);

        Livewire::actingAs($user)
            ->test(Diary::class)
            ->assertSee($firstFood->name)
            ->assertSee($foods->sum->calories)
            ->assertSee($foods->sum->carbs)
            ->assertSet('totalCalories', $foods->sum->calories)
            ->assertSet('totalCarbs', $foods->sum->carbs);
    }
}
