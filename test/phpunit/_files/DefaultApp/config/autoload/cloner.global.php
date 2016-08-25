<?php
/**
 * @year    2016
 * @link    https://github.com/nnx-framework/cloner
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Cloner\PhpUnit\TestData\DefaultApp;

use Nnx\Cloner\Cloner;

return [
    'nnx_cloner_module' => [
        'cloners' => [
            'TestCloner'     => [
                'class'     => Cloner::class,
                'relations' => [
                    'file'  => ['clonerName' => 'TestFileCloner',],
                    'files' => ['clonerName' => 'TestFileCloner',],
                ],
            ],
            'TestFileCloner' => [
                'class' => Cloner::class,
            ],
        ]
    ],
];
