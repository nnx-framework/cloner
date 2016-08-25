<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ClonerOptions
 *
 * @package Nnx\Cloner\Options
 */
class ClonerOptions extends AbstractOptions
{

    /**
     * @var string создаваемый класс клонера
     */
    protected $class;

    /**
     * @var Cloner\RelationOptions[]
     */
    protected $relations = [];

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return Cloner\RelationOptions[]
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * @param array $relations
     *
     * @return $this
     */
    public function setRelations($relations)
    {
        foreach ($relations as $name => $options) {
            $this->relations[$name] = new Cloner\RelationOptions($options);
        }
        return $this;
    }
}
