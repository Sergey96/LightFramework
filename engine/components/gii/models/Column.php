<?php

namespace engine\components\gii\models;

/**
 * Класс - Поле таблицы в БД
 */
/// Класс - Поле таблицы в БД
class Column
{
    /// Название поля
    public $Field;
    /// Тип поля
    public $Type;
    /// Может ли поле принимать пустое значение
    public $Null;
    ///Key
    public $Key;
    /// Значение пол умолчанию
    public $Default;
    /// Extra
    public $Extra;

}