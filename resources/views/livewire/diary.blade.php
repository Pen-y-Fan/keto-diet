<div class="p-6">
    <div class="flex items-center justify-between  mb-5 px-4 py-3 bg-gray-50 text-center sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
        <button title="{{ (clone $date)->subDay()->format('l jS \\of F') }}" wire:click="changeDate(-1)" wire:loading.attr="disabled" class="items-center text-4xl pb-5 bg-blue-300 hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-100 active:bg-blue-400 px-5 py-2 text-sm leading-5 rounded-full font-semibold text-grey-800">
            &lsaquo;&lsaquo;
        </button>
        <h2 class="text-center font-semibold text-2xl text-gray-800 leading-tight pb-2"> {{ __('Diary for ') }} {{ $day }}</h2>
        <button title="{{ (clone $date)->addDay()->format('l jS \\of F') }}" wire:click="changeDate(+1)" wire:loading.attr="disabled" class="items-center text-4xl pb-5 bg-blue-300 hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-100 active:bg-blue-400 px-5 py-2 text-sm leading-5 rounded-full font-semibold text-grey-800">
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
        @foreach(\App\Enum\Meal::cases() as $meal)
            <div class="border-b border-gray-300 last:border-none pb-3">
                <h3 class="font-semibold text-xl text-blue-900 my-3">{{ $meal->name }}</h3>
                @foreach($diary as $food)
                    @if( $food->meal === $meal)
                        <x-food-line :food="$food" :date="$date"/>
                    @endif
                    @if($loop->last)
                        <div class="flex items-center  p-2">
                            <div class="w-5/6 md:w-11/12"></div>
                            <div class="w-1/6 md:w-1/12 text-center">
                                <a href="{{ route('food.add', ["meal" => $meal->value, "date" => $date->format('Y-m-d')]) }}" class="items-center text-lg bg-blue-300 hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-100 active:bg-blue-400 p-1 text-sm leading-5 rounded-full font-semibold text-grey-800" title="{{ __('Add') . ' ' . $meal->name }}">
                                    <div class="inline-block w-6 h-6">
                                        <span>
                                            &#xFF0B;{{-- full width plus sign --}}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>

                    @endif
                @endforeach
            </div>
        @endforeach
    @endif
</div>
