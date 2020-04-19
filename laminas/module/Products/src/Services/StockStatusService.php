<?php

namespace Products\Services;

use Products\Entity\Product;
use Laminas\Http\Client;

class StockStatusService
{
    const URL = 'http://nginx/product-stock-api';

    public function getStock(Product $product){
        $client = new Client(
            self::URL . '/' . $product->getName(),
            ['keepalive' => true]
        );
        $response = $client->setMethod('GET')->send();
        if ($response->getStatusCode() == 200) {
            $jsonData = json_decode($response->getBody());
            if ($jsonData) {
                return $jsonData->countAvailable ?? 0;
            }
        } else {
            return -1;
        }
        return -1;
    }

}