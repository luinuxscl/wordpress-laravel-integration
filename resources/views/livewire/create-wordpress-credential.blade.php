<div>
    @if ($showButton)
        <x-button wire:click="$dispatch('openModal')">{{ __('Create WordPress Credentials') }}</x-button>
    @endif

    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl p-6 w-1/3">
                <h2 class="text-xl font-bold mb-4">{{ __('Create Credentials') }}</h2>

                <x-alert type="warning" class="mb-4">
                    {{ __('Note: For this integration to work correctly, install the plugin') }}
                    <a href="https://github.com/WP-API/Basic-Auth" target="_blank" class="underline font-semibold">
                        WP-API/Basic-Auth
                    </a>
                    {{ __('on your WordPress site.') }}
                </x-alert>

                <form wire:submit.prevent="create">
                    <div class="mb-4">
                        <label for="site_url" class="block">{{ __('URL') }}</label>
                        <x-input type="url" wire:model="site_url" class="w-full" required />
                        @error('site_url')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="username" class="block">{{ __('Username') }}</label>
                        <x-input type="text" wire:model="username" class="w-full" required />
                        @error('username')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block">{{ __('Password') }}</label>
                        <x-input type="password" wire:model="password" class="w-full" required />
                        @error('password')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4 flex items-center">
                        <x-checkbox wire:model="is_default" class="border rounded mr-2" />
                        <label for="is_default" class="block">{{ __('Set as Default') }}</label>
                        @error('is_default')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button class="btn btn-outline btn-neutral btn-sm mr-2" wire:click="$set('showModal', false)">
                            {{ __('Close') }}
                        </button>
                        <x-button type="submit" class="btn-sm">
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('openModal', () => {
                @this.set('showModal', true);
            });
        });
    </script>
</div>
