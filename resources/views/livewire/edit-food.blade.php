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
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 active:bg-blue-700 px-5 py-2 text-sm leading-5 rounded-full font-semibold text-white">
                    Submit
                </button>
            </div>
        </form>
        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
            <button wire:click="$set('confirmingFoodDeletion', true)" wire:loading.attr="disabled" class="bg-danger-500 hover:bg-danger-600 focus:outline-none focus:ring focus:ring-danger-300 active:bg-danger-700 px-5 py-2 text-sm leading-5 rounded-full font-semibold text-white">
                {{ __('Delete') }}
            </button>
        </div>
    </div>
    <!-- Delete User Confirmation Modal -->
    <x-jet-dialog-modal wire:model="confirmingFoodDeletion">
        <x-slot name="title">
            {{ __('Delete Food') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete the food? Once deleted, the calories will be permanently deleted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingFoodDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteFood" wire:loading.attr="disabled">
                {{ __('Delete Food') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
