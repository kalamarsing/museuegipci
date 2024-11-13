<x-front-layout>
    <!-- Page Content -->
    <main class="min-h-screen">

        <!-- Header flotante -->
        <header class="fixed-header">
            <h1 class="header-title">{{$element->getFieldValue('title')}}</h1>
            <div class="close-button">
                <span class="close-icon">X</span>
            </div>
        </header>
@php
    $hasVideo = $element->getFieldValue('video') ? true : false;
@endphp
        <!-- Contenedor principal -->
        <div class="sections-container">
            <!-- Primer elemento: Audio -->
            
            <div class="audio-container {{!$hasVideo ? 'full-audio-container' : ''}}">
                <div class="audio-background" style="background-image: url('/storage/medias/original/{{$element->audio_image}}')">
                    <img 
                        src="/storage/images/audio_icon.png" 
                        srcset="
                            /storage/images/audio_icon.png 1x, 
                            /storage/images/audio_icon@2x.png 2x, 
                            /storage/images/audio_icon@3x.png 3x, 
                            /storage/images/audio_icon@4x.png 4x" 
                        class="audio-icon" 
                        alt="Audio Icon">
                        <div class="audio-player">
                            <audio controls>
                                <source src="/storage/files/{{ $element->getFieldValue('audio') }}" type="audio/mpeg" />
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    <!--div class="audio-player">
                        <div class="timeline">
                            <div class="progress"></div>
                        </div>
                        <div class="controls">
                            <div class="play-container">
                            <div class="toggle-play play"></div>
                            </div>
                            
                            <div class="volume-container">
                            <div class="volume-button">
                                <div class="volume icono-volumeMedium"></div>
                            </div>
                            <div class="volume-slider">
                                <div class="volume-percentage"></div>
                            </div>
                            </div>

                            <div class="time">
                            <div class="current">0:00</div>
                            <div class="divider">/</div>
                            <div class="length"></div>
                            </div>
                        </div>
                    </div-->
                </div>
            </div>  




            <!-- Franja de texto -->
            <div class="temporal-title">
                <div class="temporal-title-content">
                    <img 
                        src="/storage/images/text_icon.png" 
                        srcset="
                                /storage/images/text_icon.png 1x, 
                                /storage/images/text_icon@2x.png 2x, 
                                /storage/images/text_icon@3x.png 3x, 
                                /storage/images/text_icon@4x.png 4x" 
                        class="text-icon" 
                        alt="Text Icon">

                    <span class="text-label">Leer el texto</span>
                    <img 
                        src="/storage/images/arrow_down_icon.png" 
                        class="arrow-icon" 
                        alt="Arrow Icon" 
                        id="arrowIcon">
                </div>
            </div>

            <!-- Sección oculta -->
            <div class="hidden-section" id="hiddenSection">
                <p>Este es el contenido oculto que se muestra al hacer clic en la barra. Si el contenido es demasiado grande, se podrá desplazar.</p>
                <!-- Agrega más contenido aquí según sea necesario -->
            </div>

            <!-- Tercer elemento: Embed de YouTube -->
            <div class="youtube-element">
                <iframe src="https://www.youtube.com/embed/{{ $element->getFieldValue('video') }}" frameborder="0" allowfullscreen></iframe>
            </div>

        </div>
    </main>
</x-front-layout>


<script>
 /*  const audioPlayer = document.querySelector(".audio-player");
   const audioSrc = "/storage/files/{{ $element->getFieldValue('audio') }}"; // Ruta al archivo de audio local
   const audio = new Audio(audioSrc);

    audio.addEventListener(
        "loadeddata",
        () => {
            audioPlayer.querySelector(".time .length").textContent = getTimeCodeFromNum(audio.duration);
            audio.volume = 0.75;
        },
        false
    );

    // Click en la línea de tiempo para saltar
    const timeline = audioPlayer.querySelector(".timeline");
    timeline.addEventListener("click", e => {
        const timelineWidth = window.getComputedStyle(timeline).width;
        const timeToSeek = e.offsetX / parseInt(timelineWidth) * audio.duration;
        audio.currentTime = timeToSeek;
    }, false);

    // Click en el volumen
    const volumeSlider = audioPlayer.querySelector(".controls .volume-slider");
    volumeSlider.addEventListener('click', e => {
        const sliderWidth = window.getComputedStyle(volumeSlider).width;
        const newVolume = e.offsetX / parseInt(sliderWidth);
        audio.volume = newVolume;
        audioPlayer.querySelector(".controls .volume-percentage").style.width = newVolume * 100 + '%';
    }, false);

    // Actualiza el progreso y el tiempo
    setInterval(() => {
        const progressBar = audioPlayer.querySelector(".progress");
        progressBar.style.width = audio.currentTime / audio.duration * 100 + "%";
        audioPlayer.querySelector(".time .current").textContent = getTimeCodeFromNum(audio.currentTime);
    }, 500);

    // Alterna entre reproducir y pausar
    const playBtn = audioPlayer.querySelector(".controls .toggle-play");
    playBtn.addEventListener(
        "click",
        () => {
            if (audio.paused) {
                playBtn.classList.remove("play");
                playBtn.classList.add("pause");
                audio.play();
            } else {
                playBtn.classList.remove("pause");
                playBtn.classList.add("play");
                audio.pause();
            }
        },
        false
    );

    audioPlayer.querySelector(".volume-button").addEventListener("click", () => {
        const volumeEl = audioPlayer.querySelector(".volume-container .volume");
        audio.muted = !audio.muted;
        if (audio.muted) {
            volumeEl.classList.remove("icono-volumeMedium");
            volumeEl.classList.add("icono-volumeMute");
        } else {
            volumeEl.classList.add("icono-volumeMedium");
            volumeEl.classList.remove("icono-volumeMute");
        }
    });

    // Convierte segundos en formato de tiempo
    function getTimeCodeFromNum(num) {
        let seconds = parseInt(num);
        let minutes = parseInt(seconds / 60);
        seconds -= minutes * 60;
        const hours = parseInt(minutes / 60);
        minutes -= hours * 60;

        if (hours === 0) return `${minutes}:${String(seconds % 60).padStart(2, 0)}`;
        return `${String(hours).padStart(2, 0)}:${minutes}:${String(seconds % 60).padStart(2, 0)}`;
    }*/
</script>


<script>
    const temporalTitle = document.querySelector('.temporal-title');
    const hiddenSection = document.querySelector('.hidden-section'); // Asegúrate de que esta clase esté en tu HTML
    const arrowIcon = document.getElementById('arrowIcon');

    temporalTitle.addEventListener('click', () => {
        hiddenSection.style.display = hiddenSection.style.display === 'none' || hiddenSection.style.display === '' ? 'block' : 'none';
        arrowIcon.src = hiddenSection.style.display === 'block' ? '/storage/images/arrow_up_icon.png' : '/storage/images/arrow_down_icon.png';
    });

</script>


<script>
    // Seleccionar el botón de cerrar
    const closeButton = document.querySelector('.close-button');

    // Agregar el evento de clic al botón
    closeButton.addEventListener('click', () => {
        // Redirigir a la URL especificada
        window.location.href = "/floor/{{ $element->floor_id }}"; // Asegúrate de que esté en un formato de plantilla de Blade
    });
</script>