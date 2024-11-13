<x-front-layout>
    <!-- Page Content -->
    <main class="min-h-screen">

        <header class="fixed-header">
            <div class="close-button">
                <span class="close-icon">X</span>
            </div>
        </header>

        <!-- Contenedor principal -->
        <div class="sections-container">
            <div class="youtube-element">
                <iframe src="https://www.youtube.com/embed/{{ $element->getFieldValue('video') }}" frameborder="0" allowfullscreen></iframe>
            </div>


        </div>
    </main>
</x-front-layout>


<script>
    // Seleccionar el botón de cerrar
    const closeButton = document.querySelector('.close-button');

    // Agregar el evento de clic al botón
    closeButton.addEventListener('click', () => {
        // Redirigir a la URL especificada
        window.location.href = "/{{\App::getLocale()}}/element/{{ $element->id }}"; // Asegúrate de que esté en un formato de plantilla de Blade
    });
</script>