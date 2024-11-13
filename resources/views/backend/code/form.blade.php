<!-- resources/views/backend/code/form.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($code) ? 'Edit Code: ' . $code->name : 'Create Code' }}
            </h2>
        </div>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div id="code-form" data-code="{{ isset($code) ? json_encode($code) : 'null' }}"></div> 
                </div>
            </div>
            @if(isset($code))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('backend.code.partials.delete-form')
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
