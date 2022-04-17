<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Food;
use Livewire\Component;

class Dashboard extends Component
{
    public string $day = '';

    /**
     * @var \Illuminate\Support\Collection<int, array{date: \Illuminate\Support\Carbon, totalCalories: mixed}>
     */
//    private \Illuminate\Support\Collection $foodPerDay;
    public \Illuminate\Support\Collection $caleriesPerDay;

    public function mount(): void
    {
        $this->day = date('l');

        $foodPerDay = Food::query()
            ->whereBetween(
                'date',
                [now()->subDays(7)->format('Y-m-d'), now()->format('Y-m-d')]
            )
            ->where('user_id', auth()->id())
            ->get()
            ->sortBy('date');

        $this->caleriesPerDay = collect(range(6, 0))->map(function ($subDay) use ($foodPerDay) {
            $date = now()->subDays($subDay);
            return [
                'date'          => $date,
                'totalCalories' => $foodPerDay
                    ->whereBetween(
                        'date',
                        [$date->format('Y-m-d'), (clone $date)->addDay()->format('Y-m-d')]
                    )
                    ->sum('calories'),
            ];
        });
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.dashboard');
    }
}
