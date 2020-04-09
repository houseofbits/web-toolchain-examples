<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Product extends Entity
{
    protected $attributes = [
        'id' => null,
        'product_type' => null,
        'name' => null
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    /**
     * @return int|null
     */
    public function getProductType():? int
    {
        return $this->attributes['product_type'];
    }

    /**
     * @return null|string
     */
    public function getName():? string
    {
        return $this->attributes['name'];
    }

}