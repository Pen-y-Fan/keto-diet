<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enum\Meal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'name'     => $this->faker->name(),
            'calories' => $calories = random_int(1, 300),
            'carbs'    => random_int(1, $calories),
            'meal'     => array_rand(Meal::cases()),
            'user_id'  => User::factory()->create(),
            'date'     => Carbon::now()->sub('days', random_int(1, 30)),
        ];
    }
}
