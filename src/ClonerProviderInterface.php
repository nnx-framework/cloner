<?php
/**
 * @link    https://github.com/nnx-framework/cloner
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Cloner;

/**
 * Interface ClonerProviderInterface
 *
 * @package Nnx\Cloner
 */
interface ClonerProviderInterface
{
    /**
     * @return mixed
     */
    public function getClonerConfig();
}
