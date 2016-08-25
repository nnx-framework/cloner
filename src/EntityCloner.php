<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class EntityCloner
 *
 * @package Nnx\Cloner
 */
class EntityCloner extends Cloner
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * EntityCloner constructor.
     *
     * @param ClonerManagerInterface $clonerManager
     * @param Options\ClonerOptions  $options
     * @param ObjectManager          $objectManager
     */
    public function __construct(
        ClonerManagerInterface $clonerManager,
        Options\ClonerOptions $options,
        ObjectManager $objectManager
    ) {
        parent::__construct($clonerManager, $options);

        $this->objectManager = $objectManager;
    }

    /**
     * @param mixed                          $object
     * @param string                         $relationName
     * @param Options\Cloner\RelationOptions $options
     *
     * @return ArrayCollection|mixed
     */
    protected function handleRelation($object, $relationName, Options\Cloner\RelationOptions $options)
    {
        $cloneData = parent::handleRelation($object, $relationName, $options);
        if (is_array($cloneData)) {
            return new ArrayCollection($cloneData);
        }
        return $cloneData;
    }

    /**
     * @param mixed $object
     * @param mixed $cloneObject
     */
    protected function afterClone($object, $cloneObject)
    {
        parent::afterClone($object, $cloneObject);

        $this->getObjectManager()->detach($cloneObject);
    }

    /**
     * @return ObjectManager
     */
    protected function getObjectManager()
    {
        return $this->objectManager;
    }
}
