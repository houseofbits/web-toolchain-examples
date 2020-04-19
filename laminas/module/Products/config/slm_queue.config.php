<?php

use Products\Job\ProductStockJob;
use Products\Factory\ProductStockJobFactory;

return [
    'slm_queue' => [
        'doctrine' => array(
            'connection' => 'doctrine.connection.orm_default',
            'table_name' => 'queue_default',
        ),
        'queue_manager' => [
            'factories' => [
                'main' => 'SlmQueueDoctrine\Factory\DoctrineQueueFactory'
            ]
        ],
        'job_manager' => [
            'factories' => [
                ProductStockJob::class => ProductStockJobFactory::class
            ]
        ]
    ]
];