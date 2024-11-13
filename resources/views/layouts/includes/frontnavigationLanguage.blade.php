<nav class="bg-turquesa border-b border-turquesa-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 navbar-height">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center logo-container">
                    <a href="/">
                        <img 
                            src="/storage/images/logo_header.png" 
                            srcset="
                                /storage/images/logo_header.png 1x, 
                                /storage/images/logo_header@2x.png 2x, 
                                /storage/images/logo_header@3x.png 3x, 
                                /storage/images/logo_header@4x.png 4x" 
                            alt="Logo">
                    </a>
                </div>
            </div>

            <!-- Botón Idiomes -->
            <div class="flex items-center">
                <a href="/" class="idiomes-button">
                    {{get_dinamic_field_value('header.idiomes.btn')}}
                </a>
            </div>
        </div>
    </div>
</nav>
