<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner\PhpUnit\TestData\DefaultApp;

/**
 * Class TestObject
 *
 * @package Nnx\Cloner\PhpUnit\TestData\DefaultApp
 */
class TestObject
{

    /**
     * @var TestFileObject
     */
    protected $file;

    /**
     * @var TestFileObject[]
     */
    protected $files = [];

    /**
     * @return TestFileObject
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param TestFileObject $file
     *
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return TestFileObject[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param TestFileObject[] $files
     *
     * @return $this
     */
    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }

}