<?php
namespace Products\View\Helper;;

use Laminas\View\Helper\AbstractHelper;
use Products\Entity\ProductStock;

class StockStatusHelper extends AbstractHelper
{
    public function __invoke(?ProductStock $stock)
    {
        $out = [];

        if ($stock === null) {
           $out[] = 'Check stock';
        } else {
            if($stock->getAvailableCount() !== null){
                $out[] = sprintf('In stock: %s', $stock->getAvailableCount());
            }
        }
        return implode('<br>', $out);
    }
}