<?php

namespace engine\base\models;

use engine\App;
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

        $query = App::$connection->executeQuery($sql);

        if (!$query) {
            throw new Exceptions\DataBaseException(App::$connection->getErrors()[2] . ' ' . $table);
        }

        return $query->fetchAll(\PDO::FETCH_CLASS, Column::class);
    }
}
