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
     * @return mixed Объект для обработки
     */
    public function handle($object)
    {
        Assertion::isObject($object);

        $this->afterClone($object);

        foreach ($this->getOptions()->getRelations() as $relationName => $relation) {
            $this->handleRelation($object, $relationName, $relation);
        }

        return $object;
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
        return $cloner->handle($relationData);
    }

    /**
     * @param mixed $object      объект для обработки
     */
    protected function afterClone($object)
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
