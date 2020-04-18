<?php
namespace Products\Form;

use Laminas\Form\Form;
use Products\Form\ProductFieldset;

class ProductForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'product',
            'type' => ProductFieldset::class,
            'options' => [
                'use_as_base_fieldset' => true,
            ]
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Add',
            ],
        ]);
    }
}