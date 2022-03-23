<div>
    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-4 pt-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
            <x-jet-section-title>
                <x-slot name="title">{{ __('Food') }}</x-slot>
                <x-slot name="description">{{  __('Enter the food for your meal below') }}</x-slot>
            </x-jet-section-title>
        </div>

        <form wire:submit.prevent="submit">
            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                {{ $this->form }}
            </div>

            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 active:bg-blue-700 px-5 py-2 text-sm leading-5 rounded-full font-semibold text-white">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
