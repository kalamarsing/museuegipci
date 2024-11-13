<x-front-layout>
    @include('layouts.includes.frontnavigation')

    <!-- Page Content -->
    <main class="main-bk-image">
        <!-- Imagen de Cabecera -->

            <div class="header-image museu" id="headerImage" style="background-image: url('/storage/images/dama_de_la_casa.png');"></div>


        <!-- Contenedor de las secciones -->
        <div class="sections-container">
            <!-- Sección 1 -->

            @php $i = 1; @endphp

            @foreach($floors as $floor)
                <div class="section section-{{$i}}">
                    <img src="/storage/medias/original/{{$floor->map2}}" alt="{{$floor->getFieldValue('title')}}" class="section-image">
                    @if($i == 2)
                        <div class="button-and-info">
                            <a href="{{ route('front.floor', ['locale' => \App::getLocale(), 'floorId' => $floor->id]) }}" class="section-button">
                                {{$floor->getFieldValue('title')}}
                            </a>
                            <img src="/storage/images/map-pointer-icon-red.png"
                                srcset="/storage/images/map-pointer-icon-red@2x.png 2x,
                                        /storage/images/map-pointer-icon-red@3x.png 3x,
                                        /storage/images/map-pointer-icon-red@4x.png 4x"
                                alt="Map pointer icon" class="map-pointer-icon">
                            <span class="visit-text">{{get_dinamic_field_value('museu.start.text')}}</span>
                        </div>
                    @else
                        <a href="{{ route('front.floor', ['locale' => \App::getLocale(), 'floorId' => $floor->id]) }}" class="section-button">
                            {{$floor->getFieldValue('title')}}
                        </a>
                    @endif
                </div>
                @if($i < 3)
                    <div class="section-border"></div>
                @endif
                @php $i = $i+1; @endphp
            @endforeach

        </div>
    </main>
</x-front-layout>
