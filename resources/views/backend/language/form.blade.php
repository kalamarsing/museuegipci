<!-- resources/views/backend/language/form.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($language) ? 'Edit Language: ' . $language->name : 'Create Language' }}
            </h2>
        </div>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div id="language-form" data-language="{{ isset($language) ? json_encode($language) : 'null' }}"></div> 
                </div>
            </div>
            @if(isset($language))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('backend.language.partials.delete-form')
                    </div>
                </div>
            @endif 
        </div>
    </div>
</x-app-layout>
