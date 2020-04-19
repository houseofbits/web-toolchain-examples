<?php
namespace Products\Controller;

use Application\Controller\AbstractController;
use Doctrine\ORM\EntityManager;
use Laminas\Paginator\Adapter;
use Laminas\Paginator\Paginator;
use Laminas\View\Helper\PaginationControl;
use Laminas\View\Model\ViewModel;
use Products\Entity\Log;
use Doctrine\ORM\EntityRepository;

class LogsController extends AbstractController
{
    public function indexAction()
    {
        $em = $this->getServiceManager()->get(EntityManager::class);

        /** @var EntityRepository $logRepository */
        $logRepository = $em->getRepository(Log::class);

        $logs = $logRepository->findBy([], ['createdAt'=>'DESC']);

        $paginator = new Paginator(new Adapter\ArrayAdapter($logs));

        $paginator->setItemCountPerPage(10);

        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));

        $view = new ViewModel(compact('logs'));

        $view->setVariable('paginator', $paginator);
        $view->setTemplate('products/logs');

        return $view;
    }
}