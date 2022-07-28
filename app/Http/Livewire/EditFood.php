<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Food;
use Filament\Forms;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

/**
 * @property Forms\ComponentContainer $form
 */
class EditFood extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public bool $confirmingFoodDeletion = false;

    public ?Food $food;

    public function mount(Food $food): void
    {
        $this->food = $food;

        $this->form->fill([
            'name'     => $this->food->name,
            'calories' => $this->food->calories,
            'carbs'    => $this->food->carbs,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function submit()
    {
        if (! ($this->food instanceof Food)) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($this->food->user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $data = $this->form->getState();

        $returnDate = $this->food->date->format('Y-m-d');
        $this->food->update($data);

        $this->banner('Successfully saved!');
        return redirect(route('diary', [
            'date' => $returnDate,
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

        $returnDate = $this->food->date->format('Y-m-d');
        $this->food->delete();

        $this->banner('Successfully deleted!', 'danger');
        $this->redirect(route('diary', [
            'date' => $returnDate,
        ]));
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.edit-food');
    }

    /**
     * @noinspection NullPointerExceptionInspection
     */
    public function banner(string $message, string $style = 'success'): void
    {
        request()->session()->flash('flash.banner', $message);
        request()->session()->flash('flash.bannerStyle', $style);
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
