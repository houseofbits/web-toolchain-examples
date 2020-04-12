<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

class ProductCreationService
{
    /** @var EntityManager  */
    private $entityManager = null;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->entityManager = $managerRegistry->getManager();
    }

    public function saveProduct(Product $product)
    {
        $product->setUpdatedAt(new \DateTime('now'));

        if (!$this->entityManager->contains($product)) {
            $product->setCreatedAt(new \DateTime('now'));
        }

        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function deleteProduct(Product $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }

}