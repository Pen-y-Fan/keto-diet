<div>
    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-4 pt-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
            <x-jet-section-title>
                <x-slot name="title">{{ __('Add Food for ') . $meal->name }}</x-slot>
                <x-slot name="description">{{  __('Enter the food for your meal below') }}</x-slot>
            </x-jet-section-title>
        </div>

        <form wire:submit.prevent="submit">
            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                {{ $this->form }}
            </div>

            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                <button type="submit" class="bg-green-500 hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-300 active:bg-green-700 px-5 py-2 text-sm rounded-full font-semibold text-white">
                    <span><x-heroicon-o-document-add class="h-6 inline mr-1 text-white w-6" /></span>
                    {{ __('Add') }}
                </button>
            </div>
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50 sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                <a href="{{ route('diary', ['date' => $food->date?->format('Y-m-d'), ]) }}" class="bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 active:bg-blue-700 px-5 py-2 text-sm leading-5 rounded-full font-semibold text-white">
                    <x-heroicon-o-arrow-left class="h-4 w-4 inline mb-1" /> {{ __('Back') }}
                </a>
            </div>
        </form>
    </div>
</div>
