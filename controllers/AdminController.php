<?php


namespace controllers;


use core\base\Controller;


class AdminController extends Controller
{
    /**
     * Устанавливает шаблон
     *
     * @return void
     */
    public function __construct()
    {
        $this->layout = 'layouts/main';
    }

    public function actionIndex()
    {
        echo 'Controller AdminController, action actionIndex';
    }
}