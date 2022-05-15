<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Food;
use Livewire\Component;

class Dashboard extends Component
{
    public string $day = '';

    /**
     * @var array<mixed>
     */
    public array $caleriesPerDay;

    public function mount(): void
    {
        $this->day = date('l');

        $foodPerDay = Food::query()
            ->selectRaw('sum(calories) as totalCalories, date')
            ->whereBetween(
                'date',
                [now()->subDays(6)->format('Y-m-d'), now()->format('Y-m-d')]
            )
            ->where('user_id', auth()->id())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->caleriesPerDay = collect(range(6, 0))
            ->map(function ($subDay) use ($foodPerDay) {
                $date = now()->subDays($subDay);
                return [
                    'date'          => $date->format('l'),
                    'totalCalories' => $foodPerDay
                        ->whereBetween(
                            'date',
                            [$date->format('Y-m-d'), (clone $date)->addDay()->format('Y-m-d')]
                        )
                        ->pluck('totalCalories')->first() ?? 0,
                ];
            })->toArray();
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.dashboard');
    }
}
