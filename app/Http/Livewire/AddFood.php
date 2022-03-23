<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Enum\Meal;
use App\Models\Food;
use Carbon\Carbon;
use Filament\Forms;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

//use LivewireUI\Modal\ModalComponent;

class AddFood extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $calories;

    /**
     * @var int
     */
    public $carbs;

    /**
     * @var Carbon
     */
    public $date;

    /**
     * @var Meal
     */
    public $meal;

    /**
     * @var Food
     */
    public ?Food $food;

    public function mount(int $meal, Carbon $date): void
    {
        $this->date = $date;
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

        $food = $this->food;
        if (! ($food instanceof Food)) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $this->form->getState();

        $food->create(
            array_merge(
                $data,
                [
                    'meal'    => $this->meal,
                    'date'    => $this->date,
                    'user_id' => auth()->id(),
                ]
            )
        );
        $this->redirect(route('diary'));
//        $this->closeModalWithEvents([
//            Diary::getName() => [
//                'addFoodEvent',
//                [
//                    $this->meal->value,
//                    $data['name'],
//                    $data['calories'],
//                    $data['carbs'],
//                ],
//            ],
//        ]);
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        /** @phpstan-ignore-next-line */
        return view('livewire.add-food');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required()
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
