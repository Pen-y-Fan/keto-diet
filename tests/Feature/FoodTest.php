<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enum\Meal;
use App\Models\Food;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoodTest extends TestCase
{
    use RefreshDatabase;

    public function testFoodCanBeCreated(): void
    {
        /** @var Food $food */
        $food = Food::factory()->create();

        $this->assertDatabaseHas(
            'food',
            [
                'id'       => $food->id,
                'name'     => $food->name,
                'calories' => $food->calories,
                'carbs'    => $food->carbs,
                'meal'     => $food->meal,
                'user_id'  => $food->user_id,
                'date'     => $food->date->format('Y-m-d'),
            ]
        );
    }

    public function testFoodBelongsToAUser(): void
    {
        /** @var User $fred */
        $fred = User::factory()->create([
            'email' => 'fred@example.com',
        ]);

        /** @var Food $food */
        $food = Food::factory()->create(
            [
                'user_id' => $fred,
            ]
        );

        $this->assertDatabaseHas(
            'food',
            [
                'id'       => $food->id,
                'name'     => $food->name,
                'calories' => $food->calories,
                'carbs'    => $food->carbs,
                'meal'     => $food->meal,
                'user_id'  => $fred->id,
                'date'     => $food->date->format('Y-m-d'),
            ]
        );

        $this->assertSame($fred->id, $food->user->id);
    }

    /**
     * @throws \Exception
     */
    public function testAUserCanAddFood(): void
    {
        /** @var User $fred */
        $fred = User::factory()->create();

        $fred->foods()->create([
            'name'     => 'nice grub',
            'calories' => $calories = random_int(1, 300),
            'carbs'    => random_int(1, $calories),
            'meal'     => array_rand(Meal::cases()),
            'date'     => Carbon::now()->sub('days', random_int(1, 30)),
        ]);

        $food = Food::first();

        $this->assertNotNull($food);
        $this->assertNotNull($fred);
        $this->assertSame($fred->id, $food->user->id);
        $this->assertInstanceOf(Collection::class, $fred->foods);
        $this->assertInstanceOf(Food::class, $fred->foods->first());
        $this->assertNotNull($fred->foods->first()->name);
        $this->assertSame($fred->foods->first()->name, $food->name);
        $this->assertSame('nice grub', $food->name);
    }

    /**
     * @throws \Exception
     */
    public function testAFoodCanBeForADay(): void
    {
        /** @var User $fred */
        $fred = User::factory()->create([
            'email' => 'fred@example.com',
        ]);

        /** @var Collection<int, Food> $food */
        $food = Food::factory(2)->create(
            [
                'user_id' => $fred,
                'date'    => Carbon::now()->toDateString(),
            ]
        );

        /** @var Collection<int, Food> $todayFoods */
        $todayFoods = $fred->foods()
            ->forDate(Carbon::now())
            ->get();

        $this->assertCount(2, $todayFoods);

        $this->assertSame($food[0]->name, $todayFoods[0]->name);
        $this->assertSame($food[1]->name, $todayFoods[1]->name);
    }

    /**
     * @throws \Exception
     */
    public function testAUserCanOnlySeeTheirFoods(): void
    {
        /** @var User $fred */
        $fred = User::factory()->create([
            'email' => 'fred@example.com',
        ]);

        /** @var User $jane */
        $jane = User::factory()->create([
            'email' => 'jane@example.com',
        ]);

        /** @var Collection<int, Food> $fredFoods */
        $fredFoods = Food::factory(2)->create(
            [
                'user_id' => $fred,
            ]
        );

        /** @var Collection<int, Food> $janeFoods */
        $janeFoods = Food::factory(3)->create(
            [
                'user_id' => $jane,
            ]
        );

        $getFredFoods = $fred->foods()->get();
        $getJaneFoods = $jane->foods()->get();

        $this->assertSame(5, Food::count('id'));
        $this->assertCount(2, $getFredFoods);
        $this->assertCount(3, $getJaneFoods);

        $this->assertSame($janeFoods[0]->name, $getJaneFoods[0]->name);
        $this->assertSame($fredFoods[0]->name, $getFredFoods[0]->name);
        $this->assertNotSame($fredFoods[0]->name, $getJaneFoods[0]->name);
    }
}
