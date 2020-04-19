<?php

namespace Products\Controller\Api;

use Application\Controller\AbstractController;
use Laminas\View\Model\ViewModel;

use Laminas\View\Model\JsonModel;

class ProductStockApi extends AbstractController
{
    private $data = [
        'Phone' => 23,
        'Chair' => 6,
        'Laptop' => 3,
        'Mouse' => 16
    ];

    public function requestAction()
    {
        $return = [
            'countAvailable' => 0
        ];

        $name = $this->params()->fromRoute('productName');

        if ($name && isset($this->data[$name])) {
            $return['countAvailable'] = $this->data[$name];
        }

        return new JsonModel($return);
    }
}