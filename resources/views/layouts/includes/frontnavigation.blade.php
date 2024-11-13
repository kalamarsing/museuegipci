<nav x-data="{ open: false }" class="bg-turquesa border-b border-turquesa-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 navbar-height">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center logo-container">
                    <a href="{{ route('front.home', ['locale' => \App::getLocale()]) }}">
                        <img 
                            src="/storage/images/logo_header.png" 
                            srcset="
                                /storage/images/logo_header.png 1x, 
                                /storage/images/logo_header@2x.png 2x, 
                                /storage/images/logo_header@3x.png 3x, 
                                /storage/images/logo_header@4x.png 4x" 
                            alt="Logo" > <!-- Cambia el tamaño del logo según lo necesites -->
                    </a>
                </div>

            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button class="button-hamburguer" @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-9 w-9" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

  <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="p-12" style="padding: 50px 50px 10px;"> <!-- Contenedor principal con padding -->
            <!-- Idiomas -->
            @php
                $languages = \App\Models\Language::all();
            @endphp
            <div class="flex justify-between mb-10 languages-nav-container"> <!-- Flexbox para espaciar los elementos -->
                @foreach ($languages as $lang)
                    <div class="square">
                        <a href="{{ url($lang->iso . substr(request()->getPathInfo(), 3)) }}">{{ $lang->iso }}</a>
                    </div>
                @endforeach
            </div>

            <!-- Botones -->
            <!-- Botones -->
            <div class="mb-10">
                @php
                    $floorsInHeader = \App\Models\Floor::all();
                @endphp
                @foreach ($floorsInHeader as $floorInHeader)
                    <div class="button-container">
                        <a href="{{ route('front.floor', ['locale' => \App::getLocale(), 'floorId' => $floorInHeader->id]) }}" class="button">
                            <img src="/storage/images/map-pointer-icon-white.png" 
                                srcset="
                                    /storage/images/map-pointer-icon-white.png 1x, 
                                    /storage/images/map-pointer-icon-white@2x.png 2x, 
                                    /storage/images/map-pointer-icon-white@3x.png 3x, 
                                    /storage/images/map-pointer-icon-white@4x.png 4x" 
                                alt="Icono" class="icon" />
                            <span class="button-text">{{$floorInHeader->getFieldValue('title')}}</span>
                        </a>
                    </div>
                @endforeach

                <div class="button-container">
                    <a href="/{{\App::getLocale()}}/museu" class="button">
                        <img src="/storage/images/map-icon.png" 
                            srcset="
                                /storage/images/map-icon.png 1x, 
                                /storage/images/map-icon@2x.png 2x, 
                                /storage/images/map-icon@3x.png 3x, 
                                /storage/images/map-icone@4x.png 4x" 
                            alt="Icono" class="icon" />
                        <span class="button-text">EL MUSEU</span>
                    </a>
                </div>
            </div>

            <!-- Textos -->
            <div class="mb-10">
                <div class="text-link first">
                    <span class="museum-title">{{get_dinamic_field_value('header.museu.egipci.text')}}</span>
                </div>
                <div class="text-link"><a href="https://www.museuegipci.com" class="text-link-style">www.museuegipci.com</a></div>
                <div class="text-link"><a href="mailto:info@museuegipci.com" class="text-link-style">info@museuegipci.com</a></div>
                <div class="text-link last">
                    <a href="#" class="text-link-style text-link-medium">{{get_dinamic_field_value('header.cookies.title')}}</a> · 
                    <a href="#" class="text-link-style text-link-medium">{{get_dinamic_field_value('header.avis.title')}}</a>
                </div>
            </div>
            
        </div>
    </div>

</nav>
