<div class="flex items-center mb-3 odd:bg-gray-50 odd:rounded-lg p-2 shadow sm:rounded-bl-md sm:rounded-br-md">
    <div class="w-1/2 md:w-3/4"><p>{{ $food->name }}</p></div>
    <div class="w-1/6 md:w-1/12"><p class="text-right">{{ $food->calories }}</p></div>
    <div class="w-1/6 md:w-1/12"><p class="text-right">{{ $food->carbs }}</p></div>
    <div class="w-1/6 md:w-1/12 text-center">
        <a href="{{ route('food.edit', ["food" => $food->id]) }}" class="items-center bg-green-300 hover:bg-green-500 focus:outline-none focus:ring focus:ring-green-200 active:bg-green-600 p-1 my-1 text-md leading-5 rounded-full font-semibold text-gray-800" title="{{ __('Edit') . ' ' . $food->name  }}">
            <div class="inline-block w-6 h-6">
                 <span>
                    <x-heroicon-o-pencil-alt class="inline text-gray-800 h-4 w-4 mx-auto items-center" />
                 </span>
            </div>
        </a>
    </div>
</div>
