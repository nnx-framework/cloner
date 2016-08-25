<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner\PhpUnit\TestData\DefaultApp;

use Nnx\Cloner\CloneToManyTrait;

/**
 * Class TestObject
 *
 * @package Nnx\Cloner\PhpUnit\TestData\DefaultApp
 */
class TestObject
{

    use CloneToManyTrait;

    /**
     * @var TestChildObject
     */
    protected $child;

    /**
     * @var TestChildObject[]
     */
    protected $children = [];


    /**
     * Clone
     */
    public function __clone()
    {
        if (is_object($this->child)) {
            $this->child = clone $this->child;
        }

        if (is_array($this->children)) {
            $this->children = $this->cloneToMany($this->children, $this, 'parent');
        }

    }


    /**
     * @return TestChildObject
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * @param TestChildObject $child
     *
     * @return $this
     */
    public function setChild($child)
    {
        $this->child = $child;
        return $this;
    }

    /**
     * @return TestChildObject[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param TestChildObject[] $children
     *
     * @return $this
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

}