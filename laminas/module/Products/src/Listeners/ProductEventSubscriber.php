<?php

namespace Products\Listeners;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Products\Entity\Product;
use Products\Entity\Log;
use Products\Entity\ProductStock;

class ProductEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            Events::postUpdate,
            Events::postRemove,
            Events::postPersist,
        );
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        /** @var EntityManager $entityManager */
        $entityManager = $args->getObjectManager();

        if ($entity instanceof Product) {
            $this->writeLog($entityManager, sprintf("Product %d updated", $entity->getId()));
        }
        if ($entity instanceof ProductStock) {
            $this->writeLog($entityManager, sprintf("ProductStock %d updated with status %d", $entity->getId(), $entity->getStatus()));
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        /** @var EntityManager $entityManager */
        $entityManager = $args->getObjectManager();

        if ($entity instanceof Product) {
            $this->writeLog($entityManager, sprintf("Product %d removed", $entity->getId()));
        }
        if ($entity instanceof ProductStock) {
            $this->writeLog($entityManager, sprintf("ProductStock %d deleted", $entity->getId()));
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        /** @var EntityManager $entityManager */
        $entityManager = $args->getObjectManager();

        if ($entity instanceof Product) {
            $this->writeLog($entityManager, sprintf("Product %d created", $entity->getId()));
        }
        if ($entity instanceof ProductStock) {
            $this->writeLog($entityManager, sprintf("ProductStock %d created with status %d", $entity->getId(), $entity->getStatus()));
        }
    }

    private function writeLog(EntityManager $em, string $value)
    {
        $logObject = new Log();
        $logObject->setValue($value);
        $logObject->setCreatedAt(new \DateTime('now'));
        $em->persist($logObject);
        $em->flush();
    }
}