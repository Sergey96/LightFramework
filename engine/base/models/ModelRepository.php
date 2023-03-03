<?php

namespace engine\base\models;

use engine\WebApp;
use engine\core\exceptions as Exceptions;
use engine\components\gii\models\Column;

/**
 *  Базовый Класс Модели
 */
/// Базовый Класс Модели
class ModelRepository
{
    /**
     * Получить список полей в связанной таблице
     * @param $table
     * @return
     * @throws Exceptions\DataBaseException
     */
    public static function getTableColumns($table)
    {
        $sql = "SHOW COLUMNS FROM `$table`";

        $query = WebApp::$connection->executeQuery($sql);

        if (!$query) {
            throw new Exceptions\DataBaseException(WebApp::$connection->getErrors()[2] . ' ' . $table);
        }

        return $query->fetchAll(\PDO::FETCH_CLASS, Column::class);
    }
}
