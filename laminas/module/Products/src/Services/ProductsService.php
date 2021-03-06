<?php
namespace Products\Services;

use Doctrine\ORM\EntityManager;
use Products\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Products\Entity\ProductStock;
use Products\Listeners\ProductEventSubscriber;

class ProductsService
{
    /** @var EntityManager */
    protected $em = null;

    public function __construct(EntityManager $entityManager){
        $this->em = $entityManager;

        $this->em->getEventManager()->addEventSubscriber(new ProductEventSubscriber());
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        /** @var EntityRepository $productRepository */
        $productRepository = $this->em->getRepository(Product::class);

        return $productRepository->findAll();

    }

    /**
     * @param int $id
     * @return null|Product
     */
    public function getProduct(int $id):? Product
    {
        /** @var EntityRepository $productRepository */
        $productRepository = $this->em->getRepository(Product::class);

        /** @var Product $product */
        $product = $productRepository->find($id);

        return $product;
    }

    /**
     * @param Product $product
     */
    public function saveProduct(Product $product)
    {
        $product->setUpdatedAt(new \DateTime('now'));

        if ($product->getId()) {
            $product = $this->em->merge($product);
        }

        if (!$this->em->contains($product)) {
            $product->setCreatedAt(new \DateTime('now'));
        }

        $this->em->persist($product);
        $this->em->flush();
    }

    /**
     * @param Product $product
     */
    public function deleteProduct(Product $product)
    {
        $this->em->remove($product);
        $this->em->flush();
    }

    /**
     * @param Product $product
     * @param int $status
     * @param int|null $stockCount
     */
    public function setProductStockStatus(Product $product, int $status, ?int $stockCount = null)
    {
        $stock = null;
        if($product->getStock() instanceof ProductStock) {
            $stock = $product->getStock();
            $stock
                ->setStatus($status)
                ->setAvailableCount($stockCount);
        } else {
            $stock = new ProductStock();
            $stock->setProduct($product)
                ->setStatus($status)
                ->setAvailableCount($stockCount);
        }
        $product->setStock($stock);
        $this->em->persist($product);
        $this->em->flush();
    }

}