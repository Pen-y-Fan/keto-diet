<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Models\Food;
use Carbon\Carbon;
use Illuminate\View\Component;

class FoodLine extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public Food $food,
        public Carbon $date
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('components.food-line');
    }
}
