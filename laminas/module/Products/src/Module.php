<?php
declare(strict_types=1);

namespace Products;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\AutoloaderProviderInterface;
use Laminas\Config\Factory;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface
{

    /**
     * @return array
     */
    public function getConfig()
    {
        $path = __DIR__
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . 'config'
            . DIRECTORY_SEPARATOR . '*.php';

        return Factory::fromFiles(glob($path));
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . DIRECTORY_SEPARATOR . 'src',
                ],
            ],
        ];
    }
}