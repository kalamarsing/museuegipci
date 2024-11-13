<?php

return [
    'formats' => [
        [
            'directory' => 'small',
            'width' => 640, // Ejemplo de tamaño para móviles
            'height' => 360, // Ejemplo de tamaño para móviles
        ],
        [
            'directory' => 'small@2x',
            'width' => 1280, // Tamaño 2x para móviles (640 * 2)
            'height' => 720, // Tamaño 2x para móviles (360 * 2)
        ],
        [
            'directory' => 'medium',
            'width' => 800, // Ejemplo de tamaño para tabletas
            'height' => 600, // Ejemplo de tamaño para tabletas
        ],
        [
            'directory' => 'medium@2x',
            'width' => 1600, // Tamaño 2x para tabletas (800 * 2)
            'height' => 1200, // Tamaño 2x para tabletas (600 * 2)
        ],
        [
            'directory' => 'large',
            'width' => 1200, // Ejemplo de tamaño para vistas más grandes
            'height' => 900, // Ejemplo de tamaño para vistas más grandes
        ],
        [
            'directory' => 'large@2x',
            'width' => 2400, // Tamaño 2x para vistas más grandes (1200 * 2)
            'height' => 1800, // Tamaño 2x para vistas más grandes (900 * 2)
        ],
        [
            'directory' => 'thumbnail',
            'width' => 150, // Tamaño pequeño para miniaturas
            'height' => 150, // Tamaño pequeño para miniaturas
        ],
        [
            'directory' => 'thumbnail@2x',
            'width' => 300, // Tamaño 2x para miniaturas (150 * 2)
            'height' => 300, // Tamaño 2x para miniaturas (150 * 2)
        ],
    ],
];
