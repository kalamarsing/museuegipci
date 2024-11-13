<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Code') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once this code is deleted, all of its resources and data will be permanently deleted. Before deleting this code, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-code-deletion')"
    >{{ __('Delete Code') }}</x-danger-button>

    <x-modal name="confirm-code-deletion" :show="$errors->codeDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('code.delete', $code->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this code?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once this code is deleted, all of its resources and data will be permanently deleted.') }}
            </p>

            <div class="mt-6">
                <x-input-error :messages="$errors->codeDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Code') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
