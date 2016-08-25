<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner\PhpUnit\Test;

use Nnx\Cloner\ClonerInterface;
use Nnx\Cloner\ClonerManagerInterface;
use Nnx\Cloner\PhpUnit\TestData\DefaultApp\TestFileObject;
use Nnx\Cloner\PhpUnit\TestData\DefaultApp\TestObject;
use Nnx\Cloner\PhpUnit\TestData\TestPaths;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class Cloner
 *
 * @package Nnx\Cloner\PhpUnit\Test
 */
class Cloner extends AbstractHttpControllerTestCase
{
    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToDefaultAppConfig()
        );
    }

    /**
     * @inheritdoc
     */
    public function testGetCloner()
    {
        /** @var ClonerManagerInterface $manager */
        $manager = $this->getApplication()->getServiceManager()->get(ClonerManagerInterface::class);
        $cloner = $manager->get('TestCloner');
        static::assertInstanceOf(\Nnx\Cloner\Cloner::class, $cloner);
    }

    public function testCloneObject()
    {
        /** @var ClonerManagerInterface $manager */
        $manager = $this->getApplication()->getServiceManager()->get(ClonerManagerInterface::class);
        /** @var ClonerInterface $cloner */
        $cloner = $manager->get('TestCloner');

        $object = new TestObject();
        $object->setFile(new TestFileObject());
        $object->setFiles([new TestFileObject()]);

        /** @var TestObject $clone */
        $clone = $cloner->cloneObject($object);

        self::assertCloneObject($object, $clone);
        self::assertCloneObject($object->getFile(), $clone->getFile());

        static::assertEquals(count($object->getFiles()), count($clone->getFiles()));
        static::assertEquals($object->getFiles(), $clone->getFiles());

        $cloneObjects = $clone->getFiles();
        foreach ($object->getFiles() as $key => $item) {
            self::assertArrayHasKey($key, $cloneObjects);
            self::assertCloneObject($item,  $cloneObjects[$key]);
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
