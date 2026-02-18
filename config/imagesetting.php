<?php

return [
    'default' => [
        'image' => [
            //  Hero Images / Banners: 1200-2000 pixels wide.
            //  Content Images: 600-1200 pixels wide.
            //  Thumbnails: 150-300 pixels wide.

            'mime_types' => 'png,jpg,jpeg,gif,webp',
            'max_size' => 500, //in KB
            'width' => 500, //in pixels
            'height' => 500, //in pixels
            'quality' => 100, // image compression quality in percentage
        ],
    ],
];
