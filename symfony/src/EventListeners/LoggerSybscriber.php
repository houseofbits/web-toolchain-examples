<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Entity\Product;
use App\Entity\Log;
use Doctrine\ORM\Events;

class LoggerSubscriber implements EventSubscriber
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
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        /** @var EntityManager $entityManager */
        $entityManager = $args->getObjectManager();

        if ($entity instanceof Product) {
            $this->writeLog($entityManager, sprintf("Product %d removed", $entity->getId()));
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