<?php

return [
    'address_ru' => '',
    'address_uk' => '',
    'map_link' => '',

    'fromEmail' => '',
    'toEmail' => '',
    'phone1' => '',
    'phone2' => '',
    'phone3' => '',
    'googleMapsApiKey' => '',

    'currency_id' => 1,

    'liqpay' => [
        'public_key' => 'i#',
        'private_key' => '',
        'status_awaiting' => [2],
        'sandbox' => true,
    ],

    'file' => [
        'extensions' => 'png, jpg, jpeg, pdf, zip, rar, doc, docx, xls, xlsx',
        'maxSize' => 100*1024*1024,
        'maxFiles' => 50,
        'path' => dirname(__DIR__) . '/files',
    ],

    'image' => [
        'extensions' => 'png, jpg, jpeg',
        'path' => 'image',
        'jpeg_quality' => 85,
        'convert' => true,
        'watermark' => [
            'enabled' => true,
            'absolute' => false,
            'file' => '@webroot/img/watermark.png',
            'x' => 50,
            'y' => 70,
        ],
        'none' => '/img/photo-default.png',
        'size' => [
            'page' => [
                'width' => 600,
                'height' => 450,
                'method' => 'clip',
            ],
            'cover' => [
                'width' => 200,
                'height' => 200,
                'method' => 'crop',
                'watermark' => [
                    'enabled' => false,
                ],
            ],
            'fill' => [
                'width' => 400,
                'height' => 400,
                'method' => 'fill',
                'watermark' => [
                    'enabled' => false,
                ],
            ],
            'category' => [
                'width' => 340,
                'height' => 260,
                'method' => 'fill',
                'bg' => '#FFFFFF',
                'watermark' => [
                    'width' => 102,
                ],
                'none' => '/img/category-default.png',
            ],
            'big' => [
                'width' => 1000,
                'height' => 1000,
                'method' => 'fill',
                'bg' => '#FFFFFF',
            ],
            'normal' => [
                'width' => 450,
                'height' => 450,
                'method' => 'fill',
                'bg' => '#FFFFFF',
                'watermark' => [
                    'width' => 130,
                ],
            ],
            'small' => [
                'width' => 240,
                'height' => 240,
                'method' => 'fill',
                'bg' => '#FFFFFF',
                'watermark' => [
                    'width' => 72,
                ],
            ],
            'micro' => [
                'width' => 135,
                'height' => 135,
                'method' => 'fill',
                'bg' => '#FFFFFF',
                'watermark' => [
                    'width' => 35,
                ],
            ],
        ],
    ],

    'podbor' => [
        'horizontalLabelClass' => 'col-sm-5',
        'horizontalInputClass' => 'col-sm-7',
    ],
];
