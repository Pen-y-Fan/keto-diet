<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Enum\Meal;
use App\Models\Food;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Diary extends Component
{
    public array $mealDescription = [];

    public string $day = '';

    public Carbon|null $date;

    /**
     * @var \Illuminate\Database\Eloquent\Collection<int, Food>
     */
    public \Illuminate\Database\Eloquent\Collection $diary;

    public int|null $totalCalories;

    public int|null $totalCarbs;

    public function mount(): void
    {
        $this->day = Carbon::now()->englishDayOfWeek;
//        $this->date = $date ? Carbon::parse($date) : Carbon::now();
        $this->date            = Carbon::now();
        $this->mealDescription = [
            Meal::Breakfast->value => Meal::Breakfast->description(),
            Meal::Lunch->value     => Meal::Lunch->description(),
            Meal::Dinner->value    => Meal::Dinner->description(),
            Meal::Snack->value     => Meal::Snack->description(),
        ];

        /** @var User $user */
        $user                = auth()->user();
        $this->diary         = $user->foods()->forDate($this->date)->get();
        $this->totalCalories = $this->diary->sum->calories;
        $this->totalCarbs    = $this->diary->sum->carbs;
    }

    public function render(): \Illuminate\View\View
    {
        /** @phpstan-ignore-next-line */
        return view('livewire.diary');
    }
}
