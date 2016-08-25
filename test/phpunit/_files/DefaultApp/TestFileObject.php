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
class TestFileObject
{

    /**
     * @var string
     */
    protected $path;

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

}