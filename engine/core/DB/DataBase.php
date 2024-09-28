<?php

namespace engine\core\DB;

use engine\base\models\Model;
use Exception;

/**
 * DataBase - Класс для работы с БД
 */
class DataBase extends Model
{
    private \PDO $connection;
    private bool $status;
    private array $config;

    /**
     * Конструктор класса, создает соединение с БД
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->status = false;
        $this->init();
    }

    /**
     * Инициализация
     * @throws Exception
     */
    private function init()
    {
        if ($this->status == false) {
            try {
                $opt = [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                ];

                $dsn = "pgsql:host=" . $this->config['host'] . ";dbname=" . $this->config['dbname'];

                $this->connection = new \PDO($dsn, $this->config['login'], $this->config['password'], $opt);

                $this->status = true;
            } catch (\PDOException $e) {
                throw new \Exception($e->getMessage());
            }
        }
    }

    /**
     * Выполнение произвольного SQL-запроса
     * @param $query
     * @return false|\PDOStatement
     */
    public function executeQuery($query)
    {
        return $this->connection->query($query);
    }

    /**
     * Подготовка \PDO->SQL - запроса
     * @param $query
     * @return bool|\PDOStatement
     */
    public function prepare($query)
    {
        return $this->connection->prepare($query);
    }

    /**
     * Просмотр ошибок при выполнении запросов к БД
     */
    public function getErrors()
    {
        return $this->connection->errorInfo();
    }

}
