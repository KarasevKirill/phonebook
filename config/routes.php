<?php
    return [
        '^$' => ['controller' => 'contact', 'action' => 'index'],
        '^(?<controller>[a-z-]+)/?(?<action>[a-z-]+)?/?(?<parameter>[a-z0-9/-]+)?$' => [],
    ];