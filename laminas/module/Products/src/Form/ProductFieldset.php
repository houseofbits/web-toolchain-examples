<?php
namespace Products\Form;

use Laminas\Form\Fieldset;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator;
use Laminas\Filter;
use Products\Entity\Product;

class ProductFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function init(){

        $this->setHydrator(new ReflectionHydrator());
        $this->setObject(new Product());

        $this->add([
            'type' => 'hidden',
            'name' => 'id',
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'name',
            'options' => [
                'label' => 'Product name',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'imageUrl',
            'options' => [
                'label' => 'Image Url',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => true,
                'filters'  => [
                    ['name' => Filter\StringTrim::class],
                ],
                'validators' => [
                    new Validator\NotEmpty(),
                ],
            ],
            'imageUrl' => [
                'required' => true,
                'filters'  => [
                    ['name' => Filter\StringTrim::class],
                ],
                'validators' => [
                    new Validator\NotEmpty(),
                    new Validator\Uri(),
                ],
            ],
        ];
    }

}