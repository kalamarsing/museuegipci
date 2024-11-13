<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Page') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once this page is deleted, all of its resources and data will be permanently deleted. Before deleting this page, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-page-deletion')"
    >{{ __('Delete Page') }}</x-danger-button>

    <x-modal name="confirm-page-deletion" :show="$errors->pageDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('page.delete', $page->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this page?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once this page is deleted, all of its resources and data will be permanently deleted.') }}
            </p>

            <div class="mt-6">
                <x-input-error :messages="$errors->pageDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Page') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
