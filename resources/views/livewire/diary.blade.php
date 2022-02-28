<div class="p-6">
    <h2 class="text-center font-semibold text-2xl text-gray-800 leading-tight pb-2"> {{ __('Diary for ') }} {{ $day }}</h2>
    <div class="flex">
        <div class="w-1/2"></div>
        <div class="w-1/4"><p class="text-right">{{ __('Calories') }}</p></div>
        <div class="w-1/4"><p class="text-right">{{ __('Carbs') }}</p></div>
    </div>
    <div class="flex">
        <div class="w-1/2"><p class="font-semibold text-xl">Total</p></div>
        <div class="w-1/4"><p class="text-right">{{ $totalCalories }}</p></div>
        <div class="w-1/4"><p class="text-right">{{ $totalCarbs }}</p></div>
    </div>

    @if($diary)
        <div>
            <h3 class="font-semibold text-xl text-blue-900">{{ __('Breakfast') }}</h3>
            @foreach($diary as $food)
                @if( $food->meal === \App\Enum\Meal::Breakfast)
                    <div class="flex">
                        <div class="w-1/2"><p>{{ $food->name }}</p></div>
                        <div class="w-1/4"><p class="text-right">{{ $food->calories }}</p></div>
                        <div class="w-1/4"><p class="text-right">{{ $food->carbs }}</p></div>
                    </div>
                @endif
            @endforeach
            <h3 class="font-semibold text-xl text-blue-900">{{ __('Lunch') }}</h3>
            @foreach($diary as $food)
                @if( $food->meal === \App\Enum\Meal::Lunch )
                    <div class="flex">
                        <div class="w-1/2"><p>{{ $food->name }}</p></div>
                        <div class="w-1/4"><p class="text-right">{{ $food->calories }}</p></div>
                        <div class="w-1/4"><p class="text-right">{{ $food->carbs }}</p></div>
                    </div>
                @endif
            @endforeach
            <h3 class="font-semibold text-xl text-blue-900">{{ __('Dinner') }}</h3>
            @foreach($diary as $food)
                @if( $food->meal === \App\Enum\Meal::Dinner )
                    <div class="flex">
                        <div class="w-1/2"><p>{{ $food->name }}</p></div>
                        <div class="w-1/4"><p class="text-right">{{ $food->calories }}</p></div>
                        <div class="w-1/4"><p class="text-right">{{ $food->carbs }}</p></div>
                    </div>
                @endif
            @endforeach
            <h3 class="font-semibold text-xl text-blue-900">{{ __('Snack') }}</h3>
            @foreach($diary as $food)
                @if( $food->meal === \App\Enum\Meal::Snack )
                    <div class="flex">
                        <div class="w-1/2"><p>{{ $food->name }}</p></div>
                        <div class="w-1/4"><p class="text-right">{{ $food->calories }}</p></div>
                        <div class="w-1/4"><p class="text-right">{{ $food->carbs }}</p></div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
