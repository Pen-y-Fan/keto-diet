<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Enum\Meal;
use App\Models\Food;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Diary extends Component
{
    public array $mealDescription = [];

    public string $day = '';

    public Carbon|string|bool|null $date;

    /**
     * @var \Illuminate\Database\Eloquent\Collection<int, Food>
     */
    public \Illuminate\Database\Eloquent\Collection $diary;

    public int|null $totalCalories;

    public int|null $totalCarbs;

    public function mount(string $date): void
    {
        $this->date = Carbon::createFromFormat('Y-m-d', $date);
        if (! ($this->date instanceof Carbon)) {
            $this->date = now();
        }

        $this->mealDescription = [
            Meal::Breakfast->value => Meal::Breakfast->description(),
            Meal::Lunch->value     => Meal::Lunch->description(),
            Meal::Dinner->value    => Meal::Dinner->description(),
            Meal::Snack->value     => Meal::Snack->description(),
        ];

        $this->configureForDate();
    }

    public function render(): \Illuminate\View\View
    {
        /** @phpstan-ignore-next-line */
        return view('livewire.diary');
    }

    public function changeDate(int $days): void
    {
        $this->date = ($this->date instanceof Carbon) ? $this->date->addDays($days) : now();

        $this->configureForDate();
    }

    private function configureForDate(): void
    {
        $this->date = ($this->date instanceof Carbon) ? $this->date : now();

        $this->day = $this->date->format('l jS \\of F Y');

        /** @var User $user */
        $user                = auth()->user();
        $this->diary         = $user->foods()->forDate($this->date)->get();
        $this->totalCalories = $this->diary->sum->calories;
        $this->totalCarbs    = $this->diary->sum->carbs;
    }
}
