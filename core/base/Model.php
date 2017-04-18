<?php


namespace core\base;

use core;

abstract class Model
{
    /**
     * @var object экземпляр PDO
     */
    protected $pdo;

    /**
     * @var string хранит имя таблицы с которой работает данная модель
     */
    protected $tableName;

    /**
     * Конструктор класса Model. Получает массив настроек подлючения к БД из файла
     * config/db.php и сохраняет подключение к базе в $this->pdo, а так же сохраняет
     * имя таблицы, с которой работает данная модель в $this->tableName
     *
     * @return void
     */
    public function __construct()
    {
        $this->tableName = $this->getTableName();

        $db = require_once ROOT . '/config/db.php';
        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['password']);
    }

    /**
     * Возвращает имя таблицы с которой связана текущая модель.
     * При этом CamelCase заменяется на разделение с помощью '_'
     * ItIsMyTableName => it_is_my_table_name
     *
     * @return string
     */
    protected function getTableName()
    {
        $fullName = get_called_class();

        $array = explode('\\', $fullName);

        $fullName = end($array);

        $regex = '#(?=[A-Z])#';

        return trim(strtolower(preg_replace($regex, '_', $fullName)), '_');
    }
}