<?php
namespace Products\Job;

use Doctrine\ORM\EntityManager;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Exception;
use Products\Entity\Product;
use Products\Entity\ProductStock;
use Products\Services\ProductsService;
use Products\Services\StockStatusService;
use SlmQueue\Job\AbstractJob;
use Products\Entity\Log;

class ProductStockJob extends AbstractJob
{
    private $sm = null;

    /** @var null | EntityManager */
    private $em = null;

    /** @var null | ProductsService */
    private $ps = null;

    /** @var null | StockStatusService */
    private $sss = null;

    public function __construct(ServiceManager $sm)
    {
        $this->sm = $sm;
        $this->em = $sm->get(EntityManager::class);
        $this->ps = $sm->get(ProductsService::class);
        $this->sss = $sm->get(StockStatusService::class);
    }

    public function execute(): ?int
    {
        try{
            $data = $this->getContent();
            $productId = null;
            if(!isset($data['productId'])) {
                throw new Exception(sprintf("ProductStockJob %n productId not set", $this->getId()));
            }
            $productId = $data['productId'];

            $product = $this->ps->getProduct($productId);

            if($product instanceof Product){
                $response = $this->sss->getStock($product);

                if ($response >= 0) {
                    $this->ps->setProductStockStatus($product, ProductStock::STATUS_REQUEST_SUCCESFUL, $response);
                } else {
                    $this->ps->setProductStockStatus($product, ProductStock::STATUS_REQUEST_FAILED);
                }

            } else {
                throw new Exception(sprintf("ProductStockJob %n product not found", $productId));
            }

        } catch (Exception $e){
            $this->writeLog($e->getMessage());
            return 0;
        }
        $this->writeLog("ProductStockJob finished");
        return 1;
    }

    private function writeLog(string $value)
    {
        $logObject = new Log();
        $logObject->setValue($value);
        $logObject->setCreatedAt(new \DateTime('now'));
        $this->em->persist($logObject);
        $this->em->flush();
    }
}