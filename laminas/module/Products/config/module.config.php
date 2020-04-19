<?php
declare(strict_types=1);

namespace Products;

use Application\Controller\ControllerFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\ProductsController::class => ControllerFactory::class,
            Controller\LogsController::class => ControllerFactory::class,
            Controller\Api\ProductStockApi::class => ControllerFactory::class,
        ],
    ],
    'doctrine' => [
        'driver' => [
            'my_annotation_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Products\Entity' => 'my_annotation_driver',
                ],
            ],
        ],
        'connection' => [
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => [
                    'host'     => 'mysql',
                    'port'     => '3306',
                    'user'     => 'dummy',
                    'password' => 'dummy',
                    'dbname'   => 'dummy',
                ],
            ],
        ],
    ],
];


