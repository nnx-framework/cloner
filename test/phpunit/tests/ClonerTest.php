<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner\PhpUnit\Test;

use Nnx\Cloner\ClonerInterface;
use Nnx\Cloner\ClonerManagerInterface;
use Nnx\Cloner\PhpUnit\TestData\DefaultApp\TestChildObject;
use Nnx\Cloner\PhpUnit\TestData\DefaultApp\TestObject;
use Nnx\Cloner\PhpUnit\TestData\TestPaths;
use PHPUnit_Framework_TestCase;
use Zend\Test\Util\ModuleLoader;

/**
 * Class Cloner
 *
 * @package Nnx\Cloner\PhpUnit\Test
 */
class ClonerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var ModuleLoader
     */
    private $moduleLoader;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->moduleLoader = new ModuleLoader(include TestPaths::getPathToDefaultAppConfig());
    }

    /**
     * @inheritdoc
     */
    public function testGetCloner()
    {
        /** @var ClonerManagerInterface $manager */
        $manager = $this->moduleLoader->getServiceManager()->get(ClonerManagerInterface::class);
        $cloner = $manager->get('TestCloner');
        static::assertInstanceOf(\Nnx\Cloner\Cloner::class, $cloner);
    }

    public function testCloneObject()
    {
        /** @var ClonerManagerInterface $manager */
        $manager = $this->moduleLoader->getServiceManager()->get(ClonerManagerInterface::class);
        /** @var ClonerInterface $cloner */
        $cloner = $manager->get('TestCloner');

        $object = new TestObject();
        $object->setChild(new TestChildObject());
        $child = new TestChildObject();
        $child->setParent($object);
        $object->setChildren([$child]);

        $clone = clone $object;
        /** @var TestObject $clone */
        $clone = $cloner->handle($clone);

        self::assertCloneObject($object, $clone);
        self::assertCloneObject($object->getChild(), $clone->getChild());

        static::assertEquals(count($object->getChildren()), count($clone->getChildren()));
        static::assertEquals($object->getChildren(), $clone->getChildren());

        $cloneObjects = $clone->getChildren();
        foreach ($object->getChildren() as $key => $item) {
            self::assertArrayHasKey($key, $cloneObjects);
            self::assertCloneObject($item, $cloneObjects[$key]);
        }
    }

    /**
     * @param mixed $expected Исходный объект
     * @param mixed $actual   Клонированный объект
     */
    public static function assertCloneObject($expected, $actual)
    {
        static::assertEquals(get_class($expected), get_class($actual)); // одинаковые классы
        static::assertEquals($expected, $actual); // одинаковые данные
        static::assertNotEquals(spl_object_hash($expected), spl_object_hash($actual)); // разные объекты
    }
}
