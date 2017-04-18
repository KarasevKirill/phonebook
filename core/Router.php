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
     * Конструктор класса Router, получает массив маршрутов из файла
     * config/routes.php
     *
     * @return void
     */
    public function __construct()
    {
        $this->routes = require_once ROOT . '/config/routes.php';
    }

    /**
     * Пытается найти контроллер и метод, имена которых находятся в $this->route, если находит, то
     * создает экземпляр контроллера и вызывает его метод, передавая в него параметры (если есть) иначе
     * возвращает ошибку 404
     *
     * @param string
     * @return void
     */
    public function start($url)
    {
        if ($this->searchRoute($url)) {

            $controller = 'controllers\\' . $this->getNormalName($this->route['controller']) . 'Controller';

            if (class_exists($controller)) {

                $controllerObject = new $controller();

                $action = 'action' . $this->getNormalName($this->route['action']);

                if (method_exists($controllerObject, $action)) {

                    $parameters = [];

                    // заполняем параметры, если они есть
                    if (isset($this->route['parameter'])) {

                        $parameters = $this->getParameters($this->route['parameter']);

                    }

                    call_user_func_array([$controllerObject, $action], $parameters);

                    return;
                }
            }
        }
        $this->notFound();
    }

    /**
     * Сообщает о том, что искомая страница не найдена
     *
     * @return void
     */
    private function notFound()
    {
        http_response_code(404);
        require_once '404.html';
        exit;
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
                // если без экшена
                if(!isset($route['action']))
                {
                    $route['action'] = 'index';
                }
                $this->route = $route;
                return true;
            }
        }

        return false;
    }

    /**
     * Принимает строку с параметрами из url и возвращает параметры в виде массива
     *
     * @param string
     * @return array
     */
    private function getParameters($parameter)
    {
        return explode('/', $parameter);
    }

    /**
     * Принимает строку с именем контроллера или экшена и возвращает её в CamelCase
     *
     * @param string
     * @return string
     */
    private function getNormalName($name)
    {
        $name = str_replace('-', ' ', $name);

        ucwords($name);

        return str_replace(' ', '', $name);
    }
}