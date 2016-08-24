<?php
/**
 * @link    https://github.com/nnx-framework/cloner
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Cloner\Options;

use Zend\Stdlib\AbstractOptions;
use Nnx\ModuleOptions\ModuleOptionsInterface;

/**
 * Class ModuleOptions
 *
 * @package Nnx\Cloner\Options
 */
class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /**
     * @var array
     */
    private $cloners = [];

    /**
     * @return array
     */
    public function getCloners()
    {
        return $this->cloners;
    }

    /**
     * @param array $cloners
     *
     * @return $this
     */
    public function setCloners($cloners)
    {
        $this->cloners = $cloners;
        return $this;
    }

}
