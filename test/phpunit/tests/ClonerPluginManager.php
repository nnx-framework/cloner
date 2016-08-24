<?php
/**
 * @link    https://github.com/nnx-framework/cloner
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Cloner\PhpUnit\Test;

use Nnx\Cloner\ClonerManagerInterface;
use Nnx\Cloner\ClonerPluginManager;
use Nnx\Cloner\PhpUnit\TestData\TestPaths;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;


/**
 * Class ClonerPluginManagerTest
 *
 * @package Nnx\Cloner\PhpUnit\Test
 */
class ClonerPluginManagerTest extends AbstractHttpControllerTestCase
{
    /**
     *
     * @return void
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Zend\Stdlib\Exception\LogicException
     */
    public function testLoadModule()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToDefaultAppConfig()
        );


        static::assertInstanceOf(ClonerPluginManager::class, $this->getApplication()->getServiceManager()->get(ClonerManagerInterface::class));
    }
}
