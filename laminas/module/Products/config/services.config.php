<?php
namespace Products;

use Products\Services\ProductsService;
use Interop\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

return [
    'service_manager' => [
        'factories' => [
            ProductsService::class => function(ContainerInterface $container) {
                $em = $container->get(EntityManager::class);
                return new ProductsService($em);
            },
        ],
    ],
];
