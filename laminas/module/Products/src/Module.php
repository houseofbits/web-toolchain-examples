<?php
declare(strict_types=1);

namespace Products;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\AutoloaderProviderInterface;
use Laminas\Config\Factory;
use Laminas\Mvc\MvcEvent;

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

    /**
     * @param  MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $app->getEventManager()->attach('render', [$this, 'registerJsonStrategy'], 100);
    }

    /**
     * @param  MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function registerJsonStrategy(MvcEvent $e)
    {
        $app          = $e->getTarget();
        $locator      = $app->getServiceManager();
        $view         = $locator->get('Laminas\View\View');
        $jsonStrategy = $locator->get('ViewJsonStrategy');

        $jsonStrategy->attach($view->getEventManager(), 100);
    }
}