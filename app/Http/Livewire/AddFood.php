<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Enum\Meal;
use App\Models\Food;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

/**
 * @property Forms\ComponentContainer $form
 */
class AddFood extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public string|Carbon $date;

    public int|Meal $meal;

    /**
     * @var ?Food
     */
    public ?Food $food;

    public function mount(int $meal, string $date): void
    {
        /** @var Carbon|false $parseDate */
        $parseDate  = Carbon::createFromFormat('Y-m-d', $date);
        $this->date = ($parseDate instanceof Carbon) ? $parseDate : now();

        $this->meal = Meal::from($meal);

        $this->food = new Food();
        /** @phpstan-ignore-next-line  */
        $this->food->date = $this->date;
        $this->food->meal = $this->meal;

        $this->form->fill([
            'name'     => $this->food->name,
            'calories' => $this->food->calories,
            'carbs'    => $this->food->carbs,
        ]);
    }

    public function submit(): void
    {
        if (! auth()->user() && ! auth()->id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        if (! ($this->food instanceof Food)) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->date = ($this->date instanceof Carbon) ? $this->date : now();

        $data = $this->form->getState();

        /** @noinspection StaticInvocationViaThisInspection */
        $this->food->create(
            array_merge(
                $data,
                [
                    'meal'    => $this->meal,
                    'date'    => $this->date,
                    'user_id' => auth()->id(),
                ]
            )
        );

        Notification::make()
            ->title('Saved successfully')
            ->body(sprintf('The food %s has been added.', $data['name']))
            ->success()
            ->seconds(5)
            ->send();

        $this->redirect(route('diary', [
            'date' => $this->date->format('Y-m-d'),
        ]));
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.add-food');
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
