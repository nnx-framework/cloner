<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner;

use Assert\Assertion;
use Nnx\Cloner\Options\ModuleOptions;
use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * Class ClonerAbstractFactory
 *
 * @package Nnx\Cloner
 */
class ClonerAbstractFactory implements AbstractFactoryInterface
{

    /**
     * @var array|null
     */
    private $clonersConfig;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return bool
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Assert\AssertionFailedException
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $serviceManager = $serviceLocator instanceof AbstractPluginManager
            ? $serviceLocator->getServiceLocator() : $serviceLocator;

        if ($this->clonersConfig === null) {
            $this->clonersConfig = $this->getClonersConfig($serviceManager);
        }
        if (array_key_exists($requestedName, $this->clonersConfig)) {
            if (array_key_exists('class', $this->clonersConfig[$requestedName])) {
                $class = Cloner::class;
                return is_a($this->clonersConfig[$requestedName]['class'], $class, true);
            } else {
                return true;
            }
        }
        return false;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return mixed
     * @throws \Assert\AssertionFailedException
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        Assertion::isArray($this->clonersConfig[$requestedName]);
        $options = new Options\ClonerOptions($this->clonersConfig[$requestedName]);

        Assertion::isInstanceOf($serviceLocator, ClonerManagerInterface::class);
        Assertion::isInstanceOf($options, Options\ClonerOptions::class);
        $class = $options->getClass();
        return new $class(
            $serviceLocator,
            $options
        );
    }

    /**
     * @param ServiceLocatorInterface $serviceManager
     *
     * @return array
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Assert\AssertionFailedException
     */
    private function getClonersConfig(ServiceLocatorInterface $serviceManager)
    {
        /** @var ModuleOptionsPluginManagerInterface $moduleOptionsManager */
        $moduleOptionsManager = $serviceManager->get(ModuleOptionsPluginManagerInterface::class);
        Assertion::isInstanceOf($moduleOptionsManager, ModuleOptionsPluginManagerInterface::class);

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $moduleOptionsManager->get(ModuleOptions::class);
        Assertion::isInstanceOf($moduleOptions, ModuleOptions::class);

        return $moduleOptions->getCloners();
    }
}
