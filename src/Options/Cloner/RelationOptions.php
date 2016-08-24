<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner\Options\Cloner;

/**
 * Class RelationOptions
 *
 * @package Nnx\Cloner\Options
 */
class RelationOptions
{
    /**
     * @var string название клонера для получения из ClonerManagerInterface
     */
    private $clonerName;

    /**
     * @return string
     */
    public function getClonerName()
    {
        return $this->clonerName;
    }

    /**
     * @param string $clonerName
     *
     * @return $this
     */
    public function setClonerName($clonerName)
    {
        $this->clonerName = $clonerName;
        return $this;
    }
}
