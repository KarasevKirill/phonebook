<?php

namespace core;

class Router
{
    /**
     * @var array таблица маршрутов
     */
    private $routes = [];

    /**
     * @var array текущий маршрут
     */
    private $route = [];

    /**
     * @var array настройки маршрутизатора
     */
    private $config = [];

    /**
     * Конструктор класса Router, получает массив маршрутов из файла
     * config/routes.php
     *
     * @return void
     */
    public function __construct()
    {
        $this->config = require_once ROOT . '/config/router_config.php';
        $this->routes = require_once ROOT . '/config/routes.php';
    }

    /**
     * Пытается найти контроллер и метод, имена которых находятся в $this->route, если находит, то
     * создает экземпляр контроллера и вызывает его метод, передавая в него параметры (если есть) иначе
     * вызывает $this->notFound()
     *
     * @param string
     * @return void
     */
    public function start($url)
    {
        if ($this->searchRoute($url)) {

            $controllerName = 'controllers\\' . $this->getNormalName($this->route['controller']) . 'Controller';

            if (class_exists($controllerName)) {

                $controller = new $controllerName();

                $action = 'action' . $this->getNormalName($this->route['action']);

                if (method_exists($controller, $action)) {

                    $parameters = $this->getParameters();

                    call_user_func_array([$controller, $action], $parameters);

                    return;
                }
            }
        }
        $this->notFound();
    }

    /**
     * Подключает путь, указанный в 'notFound' в config/router_config.php
     *
     * @return void
     */
    private function notFound()
    {
        $this->start($this->config['notFound']);

        return;
    }

    /**
     * Разбивает полученный url и ищет совпадения с таблицей маршрутов, если находит, то помещает
     * имя контроллера и имя метода в $this->route и возвращает true, иначе false
     *
     * @param string
     * @return boolean
     */
    private function searchRoute($url)
    {
        foreach ($this->routes as $pattern => $route) {

            if(preg_match("#$pattern#i", $url, $matches))
            {
                // извлекаем ассоциативный массив
                foreach($matches as $key => $value)
                {
                    if(is_string($key))
                    {
                        $route[$key] = $value;
                    }
                }
                // если не указан контроллер
                if(!isset($route['controller']))
                {
                    $route['controller'] = $this->config['baseController'];
                }
                // если не указан метод
                if(!isset($route['action']))
                {
                    $route['action'] = $this->config['baseAction'];
                }
                $this->route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * Проверяет, существует ил строка с паармтерами в $this->route['parameter'], если да
     * то возвращает параметры в виде массива, иначе возвращает пустой массив
     *
     * @return array
     */
    private function getParameters()
    {
        if (isset($this->route['parameter'])) {

            return explode('/', $this->route['parameter']);

        }
        return [];
    }

    /**
     * Принимает строку с именем контроллера или экшена и возвращает её в CamelCase стиле
     *
     * @param string
     * @return string
     */
    private function getNormalName($name)
    {
        $name = str_replace('-', ' ', $name);

        $name = ucwords($name);

        return str_replace(' ', '', $name);
    }
}