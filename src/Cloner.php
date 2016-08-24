<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner;

use Assert\Assertion;

/**
 * Class Cloner
 *
 * @package Nnx\Cloner
 */
class Cloner implements ClonerInterface
{

    /**
     * @var ClonerManagerInterface
     */
    private $clonerManager;

    /**
     * @var Options\ClonerOptions
     */
    private $options;

    /**
     * Cloner constructor.
     *
     * @param ClonerManagerInterface       $clonerManager
     * @param Options\ClonerOptions $options
     */
    public function __construct(ClonerManagerInterface $clonerManager, Options\ClonerOptions $options)
    {
        $this->clonerManager = $clonerManager;
        $this->options = $options;
    }

    /**
     * @param mixed
     *
     * @return mixed
     */
    public function cloneObject($object)
    {
        Assertion::isObject($object);

        $cloneObject = clone $object;
        $this->afterClone($object, $cloneObject);

        foreach ($this->options->getRelations() as $relationName => $relation) {
            $cloneRelation = $this->handleRelation($object, $relationName, $relation);

            $relationSetter = 'set' . ucfirst($relationName);
            Assertion::methodExists($relationSetter, $object);

            $cloneObject->$relationSetter($cloneRelation);
        }

        return $cloneObject;
    }

    /**
     * @param mixed                          $object
     * @param string                         $relationName
     * @param Options\Cloner\RelationOptions $options
     *
     * @return mixed
     */
    protected function handleRelation($object, $relationName, Options\Cloner\RelationOptions $options)
    {
        $relationGetter = 'get' . ucfirst($relationName);
        Assertion::methodExists($relationGetter, $object);

        $relationData = $object->$relationGetter();
        if ($relationData === null) {
            return null;
        }
        $cloneData = null;
        if (is_array($relationData)
            || $relationData instanceof \Traversable
        ) {
            $cloneData = [];
            foreach ($relationData as $data) {
                if ($relationArchiverResult = $this->getRelationClonerResult($options->getClonerName(), $data)) {
                    $cloneData[] = $relationArchiverResult;
                }
            }
        } else {
            $cloneData = $this->getRelationClonerResult($options->getClonerName(), $relationData);
        }
        return $cloneData;
    }

    /**
     * @param string $clonerName
     * @param mixed  $relationData
     *
     * @return mixed
     */
    protected function getRelationClonerResult($clonerName, $relationData)
    {
        $cloner = $this->getClonerManager()->get($clonerName);
        return $cloner->cloneObject($relationData);
    }

    /**
     * @param mixed $object      Исходный объект
     * @param mixed $cloneObject Склонированный объект
     */
    protected function afterClone($object, $cloneObject)
    {
    }

    /**
     * @return ClonerManagerInterface
     */
    protected function getClonerManager()
    {
        return $this->clonerManager;
    }

    /**
     * @return Options\ClonerOptions
     */
    protected function getOptions()
    {
        return $this->options;
    }
}
