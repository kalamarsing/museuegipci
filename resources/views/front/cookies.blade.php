<x-front-layout>
    @include('layouts.includes.frontnavigation') 

    <!-- Page Content -->
    <main class="main-bk-image">
        <div class="overlay-container">
            <!-- Sección superior -->
            <div class="section-top">
                <p>
                Cookies Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam a scelerisque nunc. Maecenas malesuada, lacus sed rutrum cursus, sem leo mollis tortor, ac tincidunt risus nunc convallis dolor. Aenean lectus mauris, volutpat et neque vel, mollis varius magna. Praesent aliquam luctus eleifend. Etiam ac elit nulla. Nullam tincidunt pretium nisi, ut ultricies elit consequat in. Aliquam erat volutpat. Integer quis vulputate turpis, ut maximus urna. Aenean augue odio, laoreet nec enim et, volutpat aliquet massa. Suspendisse massa velit, tempor sed accumsan non, tristique ac arcu. Curabitur porta arcu eu libero pulvinar ornare. Donec dapibus id libero a vestibulum. Mauris in rutrum est.                </p>
            </div>

            <!-- Sección inferior -->
            <div class="section-bottom">
                <a href="/{{\App::getLocale()}}/museu" class="map-link">
                    <img 
                        src="/storage/images/map-icon.png" 
                        srcset="
                            /storage/images/map-icon.png 1x, 
                            /storage/images/map-icon@2x.png 2x, 
                            /storage/images/map-icon@3x.png 3x, 
                            /storage/images/map-icon@4x.png 4x" 
                        alt="Map Icon" 
                        class="map-icon">
                    <span>MUSEU</span>
                </a>
            </div>
        </div>
    </main>
</x-front-layout>
