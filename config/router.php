<?php
    return [
        'baseController' => 'contact',
        'baseAction' => 'index',
        'notFound' => 'contact/not-found',
        'routes' => [
            '^(?<controller>[a-z-]+)?/?(?<action>[a-z-]+)?/?(?<parameter>[a-z0-9/-]+)?$' => [],
        ],
    ];