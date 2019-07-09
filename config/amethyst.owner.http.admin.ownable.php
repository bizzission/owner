<?php

return [
    'enabled'    => true,
    'controller' => Amethyst\Http\Controllers\Admin\OwnablesController::class,
    'router'     => [
        'as'     => 'ownable.',
        'prefix' => '/ownables',
    ],
];
