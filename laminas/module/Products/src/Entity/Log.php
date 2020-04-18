<?php

namespace Products\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="log")
 */
class Log
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
    protected $value;

    public function getId()
    {
        return $this->id;
    }   
    
    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getValue():? string
    {
        return $this->value;
    }

    /**
     * @param string|null $name
     * @return Product
     */
    public function setValue(?string $value): Log
    {
        $this->value = $value;
        return $this;
    }
}