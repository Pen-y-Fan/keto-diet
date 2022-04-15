<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Food;
use Filament\Forms;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

class EditFood extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public bool $confirmingFoodDeletion = false;

    public ?Food $food;

    public function mount(Food $food): void
    {
        $this->food = $food;

        /** @phpstan-ignore-next-line */
        $this->form->fill([
            'name'     => $this->food->name,
            'calories' => $this->food->calories,
            'carbs'    => $this->food->carbs,
        ]);
    }

    public function submit(): void
    {
        if (! ($this->food instanceof Food)) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($this->food->user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN);
        }
        /** @phpstan-ignore-next-line  */
        $data = $this->form->getState();

        $this->food->update($data);

        $this->redirect(route('diary', [
            'date' => $this->food->date->format('Y-m-d'),
        ]));
    }

    public function deleteFood(): void
    {
        if (! ($this->food instanceof Food)) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($this->food->user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->food->delete();

        $this->redirect(route('diary', [
            'date' => $this->food->date->format('Y-m-d'),
        ]));
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        /** @phpstan-ignore-next-line  */
        return view('livewire.edit-food');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required()
                ->autofocus()
                ->maxLength(255),
            Forms\Components\TextInput::make('calories')
                ->required()
                ->integer()
                ->minValue(1)
                ->maxValue(1000),
            Forms\Components\TextInput::make('carbs')
                ->required()
                ->integer()
                ->minValue(1)
                ->maxValue(1000),
        ];
    }
}
