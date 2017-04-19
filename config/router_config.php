<?php
    return [
        'notFound' => 'contact/not-found',
        'baseAction' => 'index',
        'baseController' => 'contact',
        'routes' => [
            '^(?<controller>[a-z-]+)?/?(?<action>[a-z-]+)?/?(?<parameter>[a-z0-9/-]+)?$' => [],
        ],
    ];