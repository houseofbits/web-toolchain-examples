<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;
use App\Entities\Product;

class Products extends ResourceController
{
    protected $modelName = ProductModel::class;
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->asArray()->findAll());
    }

    public function update($id = null)
    {
        try {
            $product = new Product();
            $product->fill($this->request->getJSON(true));

            if ($this->model->save($product) === false) {
                return $this->respond(['formErrors' => $this->model->errors()]);
            }

        } catch (\ReflectionException $e){
            return $this->respond($e);
        }

        return $this->index();
    }

    public function create()
    {
        try {
            if ($this->model->save($this->request->getJSON(true)) === false) {
                return $this->respond(['formErrors'=>$this->model->errors()]);
            }
        } catch (\ReflectionException $e){
            return $this->respond($e);
        }

        return $this->index();
    }

    public function delete($id = null)
    {
        $products = $this->request->getJSON(true);

        if (!empty($products)) {
            foreach ($products as $product) {
                $this->model->delete($product['id']);
            }
        }

        return $this->index();
    }

}