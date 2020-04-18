<?php
declare(strict_types=1);

namespace Products\Controller;

use Application\Controller\AbstractController;
use Doctrine\ORM\EntityRepository;
use Laminas\Http\Request;
use Laminas\View\Model\ViewModel;
use Products\Entity\Product;
use Products\Form\ProductForm;
use Products\Services\ProductsService;

class ProductsController extends AbstractController
{
    public function indexAction()
    {
        $ps = $this->getServiceManager()->get(ProductsService::class);

        $products = $ps->getAll();

        $view = new ViewModel(compact('products'));

        $view->setTemplate('products/list');

        return $view;
    }

    public function addAction()
    {
        $formEdit = false;

        /** @var ProductsService $ps */
        $ps = $this->getServiceManager()->get(ProductsService::class);

        /** @var Request $request */
        $request   = $this->getRequest();

        $formManager = $this->getServiceManager()->get('FormElementManager');

        $view = new ViewModel();

        /** @var ProductForm $form */
        $form = $formManager->get(ProductForm::class);

        $view->setVariables(compact('form','formEdit'));

        $form->setData($request->getPost());

        $view->setTemplate('products/add');

        if ($request->isPost() && $form->isValid()) {

            /** @var Product $product */
            $product = $form->getData();

            if ($product instanceof Product) {

                $ps->saveProduct($product);

                $this->flashMessenger()->addMessage(sprintf('New product "%s" created', $product->getName()));

                return $this->redirect()->toRoute('main');
            }
        }

        return $view;
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id');
        if (! $id) {
            return $this->redirect()->toRoute('main');
        }

        $formEdit = true;

        /** @var ProductsService $ps */
        $ps = $this->getServiceManager()->get(ProductsService::class);

        $product = $ps->getProduct(intval($id));

        /** @var Request $request */
        $request   = $this->getRequest();

        $formManager = $this->getServiceManager()->get('FormElementManager');

        $view = new ViewModel();

        /** @var ProductForm $form */
        $form = $formManager->get(ProductForm::class);

        $form->bind($product);

        $view->setVariables(compact('form', 'formEdit'));

        $form->setData($request->getPost());

        $view->setTemplate('products/add');

        if ($request->isPost() && $form->isValid()) {

            /** @var Product $product */
            $product = $form->getData();

            if ($product instanceof Product) {

                $ps->saveProduct($product);

                $this->flashMessenger()->addMessage(sprintf('Product "%s" saved', $product->getName()));

                return $this->redirect()->toRoute('main');
            }
        }

        return $view;
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        if (! $id) {
            return $this->redirect()->toRoute('main');
        }

        /** @var ProductsService $ps */
        $ps = $this->getServiceManager()->get(ProductsService::class);

        $product = $ps->getProduct(intval($id));
        if($product instanceof Product) {
            $ps->deleteProduct($product);

            $this->flashMessenger()->addMessage(sprintf('Product "%s" deleted', $product->getName()));
        }

        return $this->redirect()->toRoute('main');
    }
}
