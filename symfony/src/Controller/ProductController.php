<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use App\Entity\Product;
use App\Entity\Log;
use App\Form\Type\ProductType;
use App\Service\ProductCreationService;

class ProductController extends AbstractController
{
    private $title = "Product controller";

    /**
    * @Route("/products")
    */
    public function index()
    {
        /* @var $entityManager EntityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $productRepository = $entityManager->getRepository(Product::class);

        return $this->render('product/main.twig', [
            'title' => $this->title,
            'products' => $productRepository->findAll()
        ]);
    }

    /**
     * @Route("/products/add")
     */
    public function add(Request $request, ProductCreationService $productCreationService)
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Product $product */
            $product = $form->getData();

            $productCreationService->saveProduct($product);

            return $this->redirectToRoute('app_product_index');
        }

        return $this->render('product/create.twig', [
            'title' => $this->title,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/products/edit/{id}")
     */
    public function edit(Product $product, Request $request, ProductCreationService $productCreationService)
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Product $product */
            $product = $form->getData();

            $productCreationService->saveProduct($product);

            return $this->redirectToRoute('app_product_index');
        }

        return $this->render('product/edit.twig', [
            'title' => $this->title,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/products/logs")
     */
    public function logs()
    {
        /* @var $entityManager EntityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $logRepository = $entityManager->getRepository(Log::class);

        return $this->render('product/logs.twig', [
            'title' => $this->title,
            'logs' => $logRepository ->findAll()
        ]);
    }

    /**
     * @Route("/products/delete/{id}")
     */
    function delete(Product $product, ProductCreationService $productCreationService)
    {
        $productCreationService->deleteProduct($product);

        return $this->redirectToRoute('app_product_index');
    }
}