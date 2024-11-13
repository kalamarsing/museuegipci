<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($floor) ? 'Edit Floor: ' . $floor->getFieldValue('title') : 'Create Floor' }}
            </h2>
            @if(isset($floor))
                <a href="{{ route('element.floor.index', ['floorId' => $floor->id]) }}" 
                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                   View Elements
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div id="floor-form" 
                        data-floor="{{ isset($floor) ? json_encode($floor) : 'null' }}"
                        data-fields="{{ isset($fields) ? json_encode($fields) : 'null' }}"> <!-- Campos organizados -->
                    </div>
                </div>
            </div>
            @if(isset($floor))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('backend.floor.partials.delete-form')
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
