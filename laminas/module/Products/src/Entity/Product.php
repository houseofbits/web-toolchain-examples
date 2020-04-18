<?php

namespace Products\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product
{
    use TimestampableTrait;

    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(type="string") 
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $imageUrl;

    /**
     * @OneToOne(targetEntity="ProductStock", inversedBy="product")
     */
    private $stock;

    public function getId()
    {
        return $this->id;
    }   
    
    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getName():? string
    {
        return $this->name;
    }

    /**
     * @param null|ProductStock $stock
     * @return Product
     */
    public function setStock(?ProductStock $stock): Product
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * @return null|ProductStock
     */
    public function getStock():? ProductStock
    {
        return $this->stock;
    }

    /**
     * @param string|null $name
     * @return Product
     */
    public function setName(?string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getImageUrl():? string
    {
        return $this->imageUrl;
    }

    /**
     * @param string|null $url
     * @return Product
     */
    public function setImageUrl(?string $url): Product
    {
        $this->imageUrl = $url;
        return $this;
    }
}