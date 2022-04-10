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

        /** @var string $date */
        $date = Carbon::now()->format('Y-m-d');
        /** @var Collection<int, Food> $foods */
        $foods = Food::factory(3)->create([
            'user_id' => $user->id,
            'date'    => $date,
        ]);

        $firstFood = $foods->first();
        $this->assertInstanceOf(Food::class, $firstFood);

        Livewire::actingAs($user)
            ->test(Diary::class, [
                'date' => $date,
            ])
            ->assertSee($firstFood->name)
            ->assertSee($foods->sum->calories)
            ->assertSee($foods->sum->carbs)
            ->assertSet('totalCalories', $foods->sum->calories)
            ->assertSet('totalCarbs', $foods->sum->carbs);
    }

    public function testViewingTheDiaryForADateItWillNotShowFoodFromAnotherDate(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var string $todaysDate */
        $todaysDate     = Carbon::now()->format('Y-m-d');
        $yesterdaysDate = now()->subDay()->format('Y-m-d');
        /** @var Collection<int, Food> $todaysFoods */
        $todaysFoods = Food::factory(3)->create([
            'user_id' => $user->id,
            'date'    => $todaysDate,
        ]);
        /** @var Collection<int, Food> $yesterdaysFood */
        $yesterdaysFood = Food::factory(3)->create([
            'user_id' => $user->id,
            'date'    => $yesterdaysDate,
        ]);

        $firstFoodToday = $todaysFoods->first();
        $this->assertInstanceOf(Food::class, $firstFoodToday);

        $firstFoodYesterday = $yesterdaysFood->first();
        $this->assertInstanceOf(Food::class, $firstFoodYesterday);

        Livewire::actingAs($user)
            ->test(Diary::class, [
                'date' => $todaysDate,
            ])
            ->assertSee($firstFoodToday->name)
            ->assertSee($todaysFoods->sum->calories)
            ->assertSee($todaysFoods->sum->carbs)
            ->assertSet('totalCalories', $todaysFoods->sum->calories)
            ->assertSet('totalCarbs', $todaysFoods->sum->carbs)
            ->assertDontSee($yesterdaysFood);

        Livewire::actingAs($user)
            ->test(Diary::class, [
                'date' => $yesterdaysDate,
            ])
            ->assertSee($firstFoodYesterday->name)
            ->assertSet('totalCalories', $yesterdaysFood->sum->calories)
            ->assertSet('totalCarbs', $yesterdaysFood->sum->carbs)
            ->assertDontSee($firstFoodToday->name);
    }
}
