<?php


namespace core\base;


abstract class Controller
{
    /**
     * @var string путь к шаблону в формате folder/file
     */
    protected $layout;

    /**
     * @var string заголовок страницы
     */
    protected $title;

    /**
     * Определяет AJAX запрос
     *
     * @return boolean
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Создает экземпляр представления, устанавливает шаблон, устанавливает заголовок страницы,
     * если он был установлен в контроллере, и запускает метод render() у представления
     *
     * @param string путь до представления в формате folder/file
     * @param array данные, которые необходимо отобразить в представлении
     * @return void
     */
    public function render($viewPath, $data = null)
    {
        $view = new View();

        $view->layout = $this->layout;

        $view->title = isset($this->title) ? $this->title : null;

        $view->render($viewPath, $data);
    }

    /**
     * Редирект в пределах сайта
     *
     * @param string путь по которому нужно перейти
     * @return void
     */
    public function redirect($path)
    {
        $path = ltrim($path, '/');

        header('Location: /' . $path);
    }
}