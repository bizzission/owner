<?php

return [
    'enabled'    => true,
    'controller' => Railken\Amethyst\Http\Controllers\Admin\OwnablesController::class,
    'router'     => [
        'as'     => 'ownable.',
        'prefix' => '/ownables',
    ],
];
