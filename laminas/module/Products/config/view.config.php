<?php

use Products\View\Helper\StockStatusHelper;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'template_map' => [
            'layout/layout'     => __DIR__ . '/../view/layout/layout.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'stockStatus' => StockStatusHelper::class,
        ],
        'factories' => [
            StockStatusHelper::class => InvokableFactory::class,
        ],
    ],
];