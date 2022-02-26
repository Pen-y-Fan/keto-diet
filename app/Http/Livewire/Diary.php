<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Livewire\Component;

class Diary extends Component
{
    public string $day = '';

    public function mount(): void
    {
        $this->day = date('l');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.diary');
    }
}
