<?php


use core\Router;


//error_reporting(-1);

define('ROOT', __DIR__);

// получаем строку запроса
$url = strtolower(rtrim($_SERVER['QUERY_STRING'], '/'));

// автоподключение файлов классов
spl_autoload_register(function($class) {
    $file = ROOT.'/'.str_replace('\\', '/', $class).'.php';
    if(file_exists($file))
    {
        require_once $file;
    }
});

$router = new Router();
$router->start($url);
