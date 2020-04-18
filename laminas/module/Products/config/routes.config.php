<?php
namespace Products;

use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'main' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/products[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\ProductsController::class,
                        'action'     => 'index',
                    ],
                    'constraints' => [
                        'controller' => Controller\ProductsController::class,
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                ],
            ],
            'logs' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/logs[/:action][/:id]/[page/:page]',
                    'defaults' => [
                        'controller' => Controller\LogsController::class,
                        'action'     => 'index',
                        'page'  => 1,
                    ],
                    'constraints' => [
                        'controller' => Controller\LogsController::class,
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                ],
            ],
        ],
    ],
];