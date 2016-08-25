<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner\PhpUnit\TestData\DefaultApp;

/**
 * Class TestFileObject
 *
 * @package Nnx\Cloner\PhpUnit\TestData\DefaultApp
 */
class TestChildObject
{

    /**
     * @var string
     */
    protected $field;

    /**
     * @var TestObject
     */
    protected $parent;

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     *
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return TestObject
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param TestObject $parent
     *
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

}