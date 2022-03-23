<div class="p-6">
    <div class="flex items-center justify-center mb-5 px-4 py-3 bg-gray-50 text-center sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
        <h2 class="text-center font-semibold text-2xl text-gray-800 leading-tight pb-2"> {{ __('Diary for ') }} {{ $day }}</h2>
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
                <h3 class="font-semibold text-xl text-blue-900">{{ $mealDescription[$meal->value] }}</h3>
                @foreach($diary as $food)
                    @if( $food->meal === $meal)
                        <x-food-line :food="$food" :date="$date"/>
                    @endif
                @endforeach
                <a href="{{ route('food.add', ["meal" => $meal->value, "date" => $date]) }}" class="bg-violet-500 hover:bg-violet-600 focus:outline-none focus:ring focus:ring-violet-300 active:bg-violet-700 px-5 py-1 my-1 text-xs leading-5 rounded-full font-semibold text-white">{{ __('Add') }}</a>
{{--                <button class="bg-violet-500 hover:bg-violet-600 focus:outline-none focus:ring focus:ring-violet-300 active:bg-violet-700 px-5 py-1 my-1 text-xs leading-5 rounded-full font-semibold text-white" wire:click='$emit("openModal", "add-food", {{ json_encode(["meal" => $meal, "date" => $date]) }})'>{{ __('Add') }} {{ $mealDescription[$meal->value] }}</button>--}}
            @endforeach
        </div>
    @endif
</div>
