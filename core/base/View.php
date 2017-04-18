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
     * @var array массив путей к css и js файлам, подключаемым в шаблоне
     */
    private $layoutFiles = [];

    /**
     * @var array массив путей к js файлам, подключенным в представлении и
     * вырезанных оттуда
     */
    private $viewScripts = [];

    /**
     * Конструктор класса View. Получет массив путей до js и css файлов, которые необходимо
     * подключить в шаблоне, из файла config/content.php
     *
     * @return void
     */
    public function __construct()
    {
        $this->layoutFiles = require_once ROOT . '/config/content.php';
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

            $content = $this->cutScripts($content);

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
    private function getLayoutStyles()
    {
        if (isset($this->layoutFiles['css'])) {

            foreach ($this->layoutFiles['css'] as $file) {

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
    private function getLayoutScripts()
    {
        if (isset($this->layoutFiles['js'])) {

            foreach ($this->layoutFiles['js'] as $file) {

                echo '<script src="/content/js/' . $file . '"></script>';

            }
        }
    }

    /**
     * Формирует и выводит ссылки на файлы js, имена которых находятся в
     * $this->staticContent
     *
     * @return void
     */
    private function getViewScripts()
    {
        if (isset($this->viewScripts[0])) {

            foreach ($this->viewScripts[0] as $file) {

                echo $file;

            }
        }
    }

    /**
     * Вырезает из страницы скрипты для того, чтобы подключить их уже после скриптов шаблона.
     * Это позволяет подключать код jQuery в любом месте страницы.
     *
     * @param string
     * @return string
     */
    private function cutScripts($content)
    {
        $pattern = '#<script.*?>.*?</script>#si';

        preg_match_all($pattern, $content, $this->viewScripts);

        if (isset($this->viewScripts)) {

            $content = preg_replace($pattern, '', $content);

        }
        return $content;
    }
}