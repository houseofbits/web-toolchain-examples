<?php

use Entities\Product;

class ProductService extends CI_Model
{
    /**
     * @param array|null $postData
     */
    public function createProduct(?array $postData)
    {
        $product = new Product();
        $product->setName($postData['name']);
        $product->setImageUrl($postData['image_url']);

        $this->doctrine->em->persist($product);
        $this->doctrine->em->flush();
    }

    /**
     * @param int $id
     */
    public function deleteProduct(int $id)
    {
        $productRepository = $this->doctrine->em->getRepository(Product::class);
        $product = $productRepository->find($id);

        if ($product instanceof Product){
            $this->doctrine->em->remove($product);
            $this->doctrine->em->flush();
        }
    }


}