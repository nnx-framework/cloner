<?php
/**
 * @link    https://github.com/nnx-framework/cloner
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Cloner;

use Nnx\ModuleOptions\ModuleConfigKeyProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Nnx\ModuleOptions\Module as ModuleOptions;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\Listener\ServiceListenerInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Module
 *
 * @package Nnx\ModuleOptions
 */
class Module implements
    ModuleConfigKeyProviderInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    DependencyIndicatorInterface,
    InitProviderInterface
{
    /**
     * Имя секции в конфиги приложения отвечающей за настройки модуля
     *
     * @var string
     */
    const CONFIG_KEY = 'nnx_cloner_module';

    /**
     * Имя модуля
     *
     * @var string
     */
    const MODULE_NAME = __NAMESPACE__;

    /**
     * @param ModuleManagerInterface $manager
     *
     * @throws \Nnx\Cloner\Exception\InvalidArgumentException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function init(ModuleManagerInterface $manager)
    {
        if (!$manager instanceof ModuleManager) {
            $errMsg = sprintf('Module manager not implement %s', ModuleManager::class);
            throw new Exception\InvalidArgumentException($errMsg);
        }

        /** @var ServiceLocatorInterface $sm */
        $sm = $manager->getEvent()->getParam('ServiceManager');

        if (!$sm instanceof ServiceLocatorInterface) {
            $errMsg = sprintf('Service locator not implement %s', ServiceLocatorInterface::class);
            throw new Exception\InvalidArgumentException($errMsg);
        }
        /** @var ServiceListenerInterface $serviceListener */
        $serviceListener = $sm->get('ServiceListener');
        if (!$serviceListener instanceof ServiceListenerInterface) {
            $errMsg = sprintf('ServiceListener not implement %s', ServiceListenerInterface::class);
            throw new Exception\InvalidArgumentException($errMsg);
        }

        $serviceListener->addServiceManager(
            ClonerManagerInterface::class,
            ClonerPluginManager::CONFIG_KEY,
            ClonerProviderInterface::class,
            'getClonerConfig'
        );
    }

    /**
     * @return string
     */
    public function getModuleConfigKey()
    {
        return self::CONFIG_KEY;
    }

    /**
     * @return array
     */
    public function getModuleDependencies()
    {
        return [
            ModuleOptions::MODULE_NAME
        ];
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/',
                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     *
     * @return array
     */
    public function getConfig()
    {
        return array_merge_recursive(
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/serviceManager.config.php',
            include __DIR__ . '/config/cloner.config.php'
        );
    }
}
