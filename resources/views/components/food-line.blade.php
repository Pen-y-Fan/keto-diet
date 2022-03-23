<div class="flex items-center">
    <div class="w-1/2 md:w-3/4"><p>{{ $food->name }}</p></div>
    <div class="w-1/6 md:w-1/12"><p class="text-right">{{ $food->calories }}</p></div>
    <div class="w-1/6 md:w-1/12"><p class="text-right">{{ $food->carbs }}</p></div>
    <div class="w-1/6 md:w-1/12 text-center">
{{--        <button class="bg-green-300 hover:bg-green-500 focus:outline-none focus:ring focus:ring-green-200 active:bg-green-600 px-5 py-1 my-1 text-xs leading-5 rounded-full font-semibold text-gray-800" wire:click='$emit("openModal", "edit-food", {{ json_encode(["food" => $food->id]) }})'>{{ __('Edit') }}</button>--}}
        <a href="{{ route('food.edit', ["food" => $food->id]) }}" class="bg-green-300 hover:bg-green-500 focus:outline-none focus:ring focus:ring-green-200 active:bg-green-600 px-5 py-1 my-1 text-xs leading-5 rounded-full font-semibold text-gray-800">{{ __('Edit') }}</a>
    </div>
</div>
