<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/** @phpstan-extends Factory<User> */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @noinspection PhpUndefinedClassInspection
     * @var class-string<\App\Models\User>
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, \Illuminate\Support\Carbon|string>
     */
    public function definition(): array
    {
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<User>
     */
    public function unverified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return static
     */
    public function withPersonalTeam(): self
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            /** @phpstan-ignore-next-line  */
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return [
                        'name'          => $user->name . '\'s Team',
                        'user_id'       => $user->id,
                        'personal_team' => true,
                    ];
                }),
            'ownedTeams'
        );
    }
}
