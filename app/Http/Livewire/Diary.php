<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Food;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Diary extends Component
{
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
        $this->day  = Carbon::now()->englishDayOfWeek;
        $this->date = Carbon::now();

        /** @var User $user */
        $user                = auth()->user();
        $this->diary         = $user->foods()->forDate($this->date)->get();
        $this->totalCalories = $this->diary->sum->calories;
        $this->totalCarbs    = $this->diary->sum->carbs;
    }

    public function render(): \Illuminate\View\View
    {
        /** @phpstan-ignore-next-line  */
        return view('livewire.diary');
    }
}
