<?php
namespace Products;

use Laminas\ServiceManager\Factory\InvokableFactory;
use Products\Services\ProductsService;
use Products\Services\StockStatusService;
use Interop\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

return [
    'service_manager' => [
        'factories' => [
            ProductsService::class => function(ContainerInterface $container) {
                $em = $container->get(EntityManager::class);
                return new ProductsService($em);
            },
            StockStatusService::class => InvokableFactory::class,
        ],
    ],
];
