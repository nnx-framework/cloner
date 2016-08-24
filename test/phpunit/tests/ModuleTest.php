<?php
/**
 * @link    https://github.com/nnx-framework/cloner
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Cloner\PhpUnit\Test;

use Nnx\Cloner\PhpUnit\TestData\TestPaths;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Nnx\Cloner\Module;


/**
 * Class ModuleTest
 *
 * @package Nnx\ModuleOptions\PhpUnit\Test
 */
class ModuleTest extends AbstractHttpControllerTestCase
{
    /**
     *
     * @return void
     * @throws \Zend\Stdlib\Exception\LogicException
     */
    public function testLoadModule()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToDefaultAppConfig()
        );

        $this->assertModulesLoaded([Module::MODULE_NAME]);
    }
}
