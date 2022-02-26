<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Livewire\Component;

class Weight extends Component
{
    public int $weight = 99;

    public function render(): \Illuminate\View\View
    {
        return view('livewire.weight');
    }
}
