<x-front-layout>
    @include('layouts.includes.frontnavigation')

    <!-- Page Content -->
    <main class="main-bk-image">
        <!-- Imagen de Cabecera -->
        @if($floor->image)
            <div class="header-image museu" id="headerImage" style="background-image: url('/storage/images/dama_de_la_casa.png');"></div>
        @endif

        <!-- Contenedor de las secciones -->
        <div class="sections-container floor-container {{$floor->image ? '' : 'no-header-image'}}">

            <!-- Mapa interactivo -->
            <div>
                <div id="image-with-pointers" 
                    data-floor="{{ json_encode($floor) }}"
                    data-pointers="{{ json_encode($pointers) }}"
                ></div>
            </div>
            <!-- Título del Floor -->
            <div class="floor-title">
                {{ $floor->getFieldValue('title') }}
            </div>

            <!-- Lista de elementos -->
            <div class="element-list">
                @foreach($pointers as $pointer)
                    <div class="element-item">
                        <!-- Puntero con número -->
                        <div class="element-pointer">
                            {{ $pointer['number'] }}
                        </div>

                        <!-- Enlace clicable -->
                        <a href="{{ $pointer['url'] }}" class="element-button">
                            {{ $pointer['title'] }}
                            @if (!empty($pointer['subtitle']))
                                <span class="element-subtitle">{{ $pointer['subtitle'] }}</span>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Botones de navegación (prev/next) -->
            <div class="navigation-buttons">
                @if($floor->prev)
                    <a href="{{ route('front.floor', ['locale' => \App::getLocale(), 'floorId' => $floor->prev->id]) }}" class="prev-button">
                        {{ $floor->prev->getFieldValue('title') }}
                    </a>
                @endif

                @if($floor->next)
                    <a href="{{ route('front.floor', ['locale' => \App::getLocale(), 'floorId' => $floor->next->id ]) }}" class="next-button">

                        {{ $floor->next->getFieldValue('title') }}
                    </a>
                @endif
            </div>

        </div>
    </main>
</x-front-layout>
