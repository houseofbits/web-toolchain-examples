<?php

return [
    'view_manager' => [
        'template_map' => [
            'layout/layout'     => __DIR__ . '/../view/layout/layout.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];