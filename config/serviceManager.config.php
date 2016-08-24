<?php
/**
 * @link    https://github.com/nnx-framework/cloner
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Cloner;

return [
    'service_manager' => [
        'invokables'         => [
            ClonerManagerInterface::class => ClonerPluginManager::class
        ],
        'factories'          => [

        ],
        'abstract_factories' => [

        ]
    ],
];
