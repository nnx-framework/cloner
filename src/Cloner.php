<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner;

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
     * @param ClonerInterface       $clonerManager
     * @param Options\ClonerOptions $options
     */
    public function __construct(ClonerInterface $clonerManager, Options\ClonerOptions $options)
    {
        $this->clonerManager = $clonerManager;
        $this->options = $options;
    }

    /**
     * @param mixed
     *
     * @return mixed
     * @throws \Nnx\Cloner\Exception\InvalidArgumentException
     * @throws \Nnx\Cloner\Exception\SetterNotFoundException
     */
    public function cloneObject($object)
    {
        if (!is_object($object)) {
            throw new Exception\InvalidArgumentException('Excepted object');
        }

        $cloneObject = clone $object;
        $this->afterClone($object, $cloneObject);

        foreach ($this->options->getRelations() as $relationName => $relation) {
            $cloneRelation = $this->handleRelation($object, $relationName, $relation);

            $relationSetter = 'set' . ucfirst($relationName);
            if (!method_exists($cloneObject, $relationSetter)) {
                throw new Exception\SetterNotFoundException(
                    sprintf('Not found setter %s in %s', $relationSetter, get_class($cloneObject))
                );
            }
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
     * @throws \Nnx\Cloner\Exception\GetterNotFoundException
     */
    protected function handleRelation($object, $relationName, Options\Cloner\RelationOptions $options)
    {
        $relationName = 'get' . ucfirst($relationName);
        if (!method_exists($object, $relationName)) {
            throw new Exception\GetterNotFoundException(
                sprintf('Not found getter %s in %s', $relationName, get_class($object))
            );
        }

        $relationData = $object->$relationName();
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
