<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- Título de la página -->
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <!-- Flecha hacia atrás -->
                <a href="{{ route('floor.show', ['id' => $floor->id]) }}" class="text-blue-500 hover:text-blue-700 mr-4">
                    <i class="fas fa-arrow-left"></i> <!-- Icono de flecha hacia atrás -->
                </a>
                Elements of {{ $floor->getFieldValue('title') }}
            </h2>
            <!-- Botón de Agregar Elemento -->
            <a href="{{ route('element.create', ['floorId' => $floor->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">

                + Add New Element
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Mostrar imagen si $floor->map no es null ni blanco -->
                    @if(!empty($floor->map))
                        <div class="mb-6">
                        <div id="image-with-pointers" 
                            data-floor="{{ json_encode($floor) }}"
                            data-pointers="{{ json_encode($pointers) }}"
                        ></div>
                        
                        </div>
                    @endif

                    <div id="element-table" data-floor="{{ json_encode($floor) }}"></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
