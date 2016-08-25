<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner;

/**
 * Class CloneToManyTrait
 *
 * @package Nnx\Cloner
 */
trait CloneToManyTrait
{
    /**
     * Пример вызова:
     *      $this->array = $this->cloneToMany($this->array, $this, 'parent');
     *
     * @param $array        array|\Traversable объектов для клонирования
     * @param $parentObject object родительский объект для клонированных объектов
     * @param $parentName   string|null название связи с родительским объектом
     *
     * @return array
     */
    protected function cloneToMany($array, $parentObject = null, $parentName = null)
    {
        $newArray = [];
        foreach ($array as $item) {
            if (is_object($item)) {
                $clone = clone $item;
                if ($parentName !== null) {
                    $method = 'set' . ucfirst($parentName);
                    if (method_exists($clone, $method)) {
                        $clone->$method($parentObject);
                    }
                }
                $newArray[] = $clone;
            }
        }
        return $newArray;
    }
}