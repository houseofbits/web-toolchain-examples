<?php

class TestEntity{
    private $id = 1;
    private $name = 'Lenovo';
    private $type = 'Laptop';
    /**
     * @return int|null
     */
    public function getId():? int
    {
        return $this->id;
    }
    /**
     * @return null|string
     */
    public function getName():? string
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getType():? string
    {
        return $this->type;
    }
}