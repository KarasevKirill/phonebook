<?php
    return [
        'baseAction' => 'index',
        'baseController' => 'contact',
        'notFound' => 'contact/not-found',
        'routes' => '^(?<controller>[a-z-]+)?/?(?<action>[a-z-]+)?/?(?<parameter>[a-z0-9/-]+)?$',
    ];