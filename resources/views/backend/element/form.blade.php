<!-- resources/views/backend/element/form.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <!-- Flecha hacia atrás -->
                <a href="{{ route('element.floor.index', ['floorId' => $floor->id]) }}" class="text-blue-500 hover:text-blue-700 mr-4">
                    <i class="fas fa-arrow-left"></i> <!-- Icono de flecha hacia atrás -->
                </a>
                <!-- Mostrar el título del floor seguido del estado de creación o edición del elemento -->
                Floor: {{ $floor->getFieldValue('title') }} - 
                {{ isset($element) ? 'Edit Element: ' . $element->getFieldValue('title') : 'Create Element' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <!-- Pasar tanto el elemento como el floor al form -->
                    <div id="element-form" 
                        data-element="{{ isset($element) ? json_encode($element) : 'null' }}" 
                        data-fields="{{ isset($fields) ? json_encode($fields) : 'null' }}"
                        data-floor="{{ json_encode($floor) }}">
                    </div>
                </div>
            </div>

            @if(isset($element))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('backend.element.partials.delete-form')
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
