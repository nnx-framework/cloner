<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner\PhpUnit\Test;

use Nnx\Cloner\ClonerManagerInterface;
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

}