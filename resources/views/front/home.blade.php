<x-front-layout>
    @include('layouts.includes.frontnavigation') 

    <!-- Page Content -->
    <main class="main-bk-image">
        <div class="overlay-container">
            <!-- Sección superior -->
            <div class="section-top">

                {!! get_dinamic_field_value('home.longText') !!}

            </div>

            <!-- Sección inferior -->
            <div class="button-museu-container ">
                <a href="/{{\App::getLocale()}}/museu" class="button-museu">
                    <img src="/storage/images/map-icon.png" 
                        srcset="
                            /storage/images/map-icon.png 1x, 
                            /storage/images/map-icon@2x.png 2x, 
                            /storage/images/map-icon@3x.png 3x, 
                            /storage/images/map-icone@4x.png 4x" 
                        alt="Icono" class="icon-museu" />
                    <span class="button-text-museu">{{get_dinamic_field_value('home.museum.btn')}}</span>
                </a>
            </div>
        </div>
    </main>
</x-front-layout>
