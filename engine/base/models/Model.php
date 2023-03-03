<?php

namespace engine\base\models;

use engine\core\validator\Validator;

/**
 *  Базовый Класс Модели
 */
/// Базовый Класс Модели
class Model
{

    public const LABEL_SIGN = 0;
    public const FORMAT_SIGN = 1;
    public const REQUIRED_SIGN = 2;

    /// Список полей модели
    protected array $attributes_;
    /// Имя таблицы модели
    protected string $tableName;
    private bool $ErrorLoad = false;

    /**
     * Установить имя таблицы
     * @param $table
     */
    public function setTableName($table)
    {
        $this->tableName = $table;
    }

    public function getErrorsLoad()
    {
        return $this->ErrorLoad;
    }

    /**
     * Загрузить данные в модель из массива
     * @param $array
     * @return bool
     * @throws \Exception
     */
    public function load($array)
    {
        if (!is_array($array)) {
            throw new \Exception("Не удается загрузить данные в модель");
        }

        $class = get_called_class();
        $rules = $class::$attributeLabels;

        if (count($array) == 0) {
            return false;
        }

        foreach ($rules as $field => $v) {

            $isRequired = $this->isRequired($field);

            if ($isRequired && !isset($array[$field])) {
                $this->ErrorLoad = 'Отсутствует обязательное поле: ' . $field;
                return false;
            }

            if ($this->isValid($array, $field)) {
                $this->$field = htmlspecialchars($array[$field]);
            }
        }

        if (isset($this->id)) {
            $this->setNotNew();
        }

        return true;
    }

    private function isValid($array, $field)
    {
        $rules = $this->getRules();

        $format = $rules[$field][$this::FORMAT_SIGN];
        $value = $array[$field];

        if (isset($value) && strlen($value) != 0) {
            if (Validator::validate($format, $value)) {
                return true;
            } else {
                $this->ErrorLoad = 'Поле не соответствует формату "' . $format . '": ' . $field . ' => ' . $format;
                return false;
            }
        }

        return true;
    }

    public function isRequired($field)
    {
        $rules = $this->getRules();

        return $rules[$field][$this::REQUIRED_SIGN] === 'required';
    }

    private function getRules()
    {
        $class = get_called_class();
        return $class::$attributeLabels;
    }

    public function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = date_parse_from_format($format, $date);
        return $d['warning_count'] || $d['error_count'];
    }

    public function getFieldList($rules)
    {
        foreach ($rules as $field => $rule) {
            $fields[] = $field;
        }

        return $fields ?? [];
    }

//    /**
//     * Получение списка полей класса
//     *
//     * @return array
//     * @throws \ReflectionException
//     */
//    public function getProperty()
//    {
////        $an_array = [];
//
//        $reflection = new \ReflectionClass($this);
//        $properties = $reflection->getProperties();
//
//        foreach ($properties as $property) {
//            $property->setAccessible(true);
////            $name = $property->getName();
//
////            $an_array[$name] = $property->getValue($this);
//            if (!$property->isPublic()) {
//                $property->setAccessible(false);
//            }
//        }
//
//        $ClassName = $this->getClassName();
//
//        foreach ($properties as $key => $value) {
//            if (isset($value->class)) {
//                if ($value->class == $ClassName && $value->isPublic()) {
//                    $list[] = $value->getName();
//                }
//            }
//        }
//
//        return $list ?? [];
//    }

    /**
     * Возвращает имя текущего класса
     *
     * @return string
     */
    public function getClassName()
    {
        return get_class($this);
    }

    /**
     * Получить список полей в связанной таблице
     * @throws \engine\core\exceptions\DataBaseException
     */
    public function getTableColumns()
    {
        $columns = ModelRepository::getTableColumns($this->tableName);

        foreach ($columns as $column) {
            $this->attributes_[$column->Field] = $column;
            $this->attributes_[$column->Field]->Value = 0;
        }
    }
}
