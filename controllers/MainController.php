<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 19.04.2017
 * Time: 20:15
 */

namespace controllers;


use core\base\Controller;

class MainController extends Controller
{
    public function actionIndex($a, $b, $c)
    {
        echo $a + $b + $c;
    }
}