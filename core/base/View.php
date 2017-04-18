<?php


namespace core\base;


class View
{
    /**
     * @var string заголовок страницы
     */
    public $title;

    /**
     * @var string путь к шаблону
     */
    public $layout;

    /**
     * @var array массив путей к css и js файлам
     */
    private $staticContent = [];

    /**
     * Конструктор класса View. Получет массив путей до js и css файлов, которые необходимо
     * подключить в шаблоне, из файла config/content.php
     *
     * @return void
     */
    public function __construct()
    {
        $this->staticContent = require_once ROOT . '/config/content.php';
    }

    /**
     * Подключает шаблон и представление
     *
     * @param string путь до представления в формате folder/file
     * @param array данные, которые необходимо отобразить в представлении
     * @return void
     */
    public function render($viewPath, $data = null)
    {
        // путь к представлению
        $viewFile = ROOT . '/views/' . $viewPath . '.php';

        // путь к шаблону
        $layoutFile = ROOT . '/views/' . $this->layout . '.php';

        // отправляем представление в переменную $content
        ob_start();

        // извлекаем данные
        if (is_array($data)) {
            extract($data);
        }

        if (is_file($viewFile)) {

            require_once $viewFile;

        } else {

            echo '<p>Страница <b>' . $viewFile . '</b> не найдена!</p>';

        }

        $content = ob_get_clean();

        if (is_file($layoutFile)) {

            require_once $layoutFile;

        } else {

            echo '<p>Шаблон <b>' . $layoutFile . '</b> не найден!</p>';

        }

    }

    /**
     * Формирует и выводит ссылки на файлы css, имена которых находятся в
     * $this->staticContent
     *
     * @return void
     */
    private function getStyles()
    {
        if (isset($this->staticContent['css'])) {

            foreach ($this->staticContent['css'] as $file) {

                echo '<link rel="stylesheet" type="text/css" href="/content/css/' . $file . '">';

            }
        }
    }

    /**
     * Формирует и выводит ссылки на файлы js, имена которых находятся в
     * $this->staticContent
     *
     * @return void
     */
    private function getScripts()
    {
        if (isset($this->staticContent['js'])) {

            foreach ($this->staticContent['js'] as $file) {

                echo '<script src="/content/js/' . $file . '"></script>';

            }
        }
    }
}