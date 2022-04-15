<div class="p-6">
    <div class="flex items-center justify-center mb-5 px-4 py-3 bg-gray-50 text-center sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
        <h2 class="text-center font-semibold text-2xl text-gray-800 leading-tight pb-2"> {{ __('Diary for ') }} {{ $day }}</h2>
    </div>
    <div class="flex items-center justify-between px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
        <button title="{{ (clone $date)->subDay()->format('l jS \\of F') }}" wire:click="changeDate(-1)" wire:loading.attr="disabled" class="items-center text-4xl pb-5 mr-3 bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 active:bg-blue-700 px-5 py-2 text-sm leading-5 rounded-full font-semibold text-white">
            &lsaquo;&lsaquo;
        </button>
        <button title="{{ (clone $date)->addDay()->format('l jS \\of F') }}" wire:click="changeDate(+1)" wire:loading.attr="disabled" class="items-center text-4xl pb-5 bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 active:bg-blue-700 px-5 py-2 text-sm leading-5 rounded-full font-semibold text-white">
            &rsaquo;&rsaquo;
        </button>
    </div>
    <div class="mb-5 py-3 bg-gray-50 shadow sm:rounded-bl-md sm:rounded-br-md">
        <div class="flex items-center">
            <div class="w-1/2 md:w-3/4"><p class="font-semibold text-right text-xl pr-3">Total</p></div>
            <div class="w-1/6 md:w-1/12"><p class="font-semibold text-right">{{ __('Calories') }}</p></div>
            <div class="w-1/6 md:w-1/12"><p class="font-semibold text-right">{{ __('Carbs') }}</p></div>
            <div class="w-1/6 md:w-1/12"><p class="font-semibold text-right"></div>
        </div>
        <div class="flex">
            <div class="w-1/2 md:w-3/4"></div>
            <div class="w-1/6 md:w-1/12"><p class="text-right">{{ $totalCalories }}</p></div>
            <div class="w-1/6 md:w-1/12"><p class="text-right">{{ $totalCarbs }}</p></div>
            <div class="w-1/6 md:w-1/12"><p class="text-right"></div>
        </div>
    </div>

    @if($diary)
        <div>
            @foreach(\App\Enum\Meal::cases() as $meal)
                <h3 class="font-semibold text-xl text-blue-900">{{ $meal->name }}</h3>
                @foreach($diary as $food)
                    @if( $food->meal === $meal)
                        <x-food-line :food="$food" :date="$date"/>
                    @endif
                @endforeach
                <a href="{{ route('food.add', ["meal" => $meal->value, "date" => $date->format('Y-m-d')]) }}" class="bg-violet-500 hover:bg-violet-600 focus:outline-none focus:ring focus:ring-violet-300 active:bg-violet-700 px-5 py-1 my-1 text-xs leading-5 rounded-full font-semibold text-white">{{ __('Add') }}</a>
            @endforeach
        </div>
    @endif
</div>
