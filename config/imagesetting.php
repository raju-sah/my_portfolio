<?php

return [
    'default' => [
        'image' => [
            //  Hero Images / Banners: 1200-2000 pixels wide.
            //  Content Images: 600-1200 pixels wide.
            //  Thumbnails: 150-300 pixels wide.

            'mime_types' => 'png,jpg,jpeg,gif,webp',
            'max_size' => 200, //in KB
            'width' => 50, //in pixels
            'height' => 50, //in pixels
            'quality' => 80, // image compression quality in percentage
        ],
    ],
];
