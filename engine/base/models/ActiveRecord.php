<?php

namespace engine\base\models;

use engine\App;
use engine\core\exceptions as Exceptions;
use engine\core\exceptions\EmptyRequiredFieldException;
use engine\core\exceptions\ErrorFieldTypeException;
use engine\core\exceptions\InvalidDataException;
use engine\core\validator\Validator;

/// Класс записи в БД
class ActiveRecord extends Model
{
    /// Связанная таблица в БД
    public $Table;
    /// Существует ли запись в таблице 0 - да, 1 - нет
    protected $isNew;
    /// Объект запроса к БД
    private $queryObj;
    /// Поля с данными, не соответствующих типов
    private $fieldsErrorType;

    /**
     * Конструктор класса
     *
     * @return void
     */
    public function __construct()
    {
        $this->isNew = 1;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function setNotNew()
    {
        return $this->isNew = 0;
    }

    /**
     * Устанавливает связь с таблицей в БД
     *
     * @return void
     */
    public function setTable($table)
    {
        $this->Table = $table;
    }

    /**
     * Сохраняет изменения модели в БД
     *
     * @param bool $validate
     * @throws Exceptions\DatabaseException
     * @throws Exceptions\EmptyRequiredFieldException
     * @throws Exceptions\InvalidDataException
     * @throws \ReflectionException
     * @throws ErrorFieldTypeException
     */
    public function save($validate = true): bool
    {
        if (!$this->validate($validate)) {
            throw new Exceptions\ErrorFieldTypeException($this->fieldsErrorType);
        }

        // Создание строки запроса для сохранения
        $Query = $this->generateQuery();
        // Создание подготовленного PDO запроса
        $stmt = self::prepare($Query);
        // Выполнение подготовленного запроса
        $stmt->execute($this->getDataAsArray($this->isNew));

        // Проверка ошибок
        $errors = $stmt->errorInfo();
        if ($errors[1]) {
            throw new Exceptions\DatabaseException($errors[2]);
        }

        return true;
    }

    public function delete()
    {
        $Query = $this->deleteSQL();
        $this->exeQuery($Query);
        $errors = $this->getErrorsDB();
        if ($errors[1])
            throw new Exceptions\DatabaseException($errors[2]);
    }

    /**
     * Генерирование INSERT - SQL запроса
     *
     * @return string
     */
    protected function insertSQL()
    {
        $fields = $this->getFieldsAsString();
        $data = $this->getFieldsForValueAsString();
        $query = "INSERT INTO " . $this->Table . " ($fields) VALUES ($data)";
        return $query;
    }

    /**
     * Генерирование UPDATE - SQL запроса
     *
     * @return string
     * @todo Исправить функцию
     */
    protected function updateSQL(): string
    {
        $fields = $this->getFieldsForUpdateAsString();
        return "UPDATE " . $this->Table . " SET  $fields WHERE id = :id";
    }

    protected function deleteSQL(): string
    {
        return "DELETE FROM " . $this->Table . " WHERE id = " . $this->id;
    }

    /**
     * Генерирует объект запроса к БД
     *
     * @return string
     * @throws \ReflectionException
     */
    protected function generateQuery(): string
    {
        if ($this->isNew) {
            return $this->insertSQL();
        } else {
            return $this->updateSQL();
        }
    }

    public function getFields(): array
    {
        $data = array();
        foreach ($this::$attributeLabels as $k => $v) {
            $data[] = $k;
        }
        return $data;
    }

    protected function getFieldsAsString(): string
    {
        $string = '';
        foreach ($this::$attributeLabels as $k => $v) {
            if ($v[2] == 'autoincrement')
                continue;
            if (strlen($string) == 0)
                $string .= "`" . $k . "`";
            else
                $string .= ", `" . $k . "`";
        }
        return $string;
    }

    protected function getFieldsForValueAsString(): string
    {
        $string = '';
        foreach ($this::$attributeLabels as $k => $v) {
            if ($v[2] == 'autoincrement')
                continue;
            if (strlen($string) == 0)
                $string .= ":$k";
            else
                $string .= ", :$k";
        }
        return $string;
    }

    protected function getFieldsForUpdateAsString(): string
    {
        $string = '';
        foreach ($this::$attributeLabels as $k => $v) {
            if ($k == 'id')
                continue;
            if (is_null($this->$k))
                continue;
            if (strlen($string) == 0)
                $string .= "$k = :$k";
            else
                $string .= ", $k = :$k";
        }
        return $string;
    }

    public function getDataAsArray($isNew): array
    {
        $data = array();
        foreach ($this::$attributeLabels as $k => $v) {
            if ($v[2] == 'autoincrement' && $isNew) {
                continue;
            }
            if (is_null($this->$k))
                continue;
            $data[$k] = $this->$k;
        }
        return $data;
    }

    /**
     * @throws InvalidDataException
     * @throws EmptyRequiredFieldException
     */
    protected function validate($validate): bool
    {
        if (!$validate) {
            return true;
        }

        foreach ($this::$attributeLabels as $field => $properties) {
            if (strlen($this->$field) == 0 && $properties[2] == 'required') {
                throw new Exceptions\EmptyRequiredFieldException($field);
            }
            if (strlen($this->$field) != 0 && !Validator::validate($properties[1], $this->$field)) {
                throw new Exceptions\InvalidDataException($field);
            }

        }
        return true;
    }

    public function getByIDs($id)
    {
        return $this->getByField('id', $id);
    }

    public function findOne($id)
    {
        $query = "SELECT * FROM " . $this->Table . " WHERE id = :id";
        $stmt = self::prepare($query);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetchAll(\PDO::FETCH_CLASS, get_class($this));

        $errors = $stmt->errorInfo();
        if ($errors[1])
            throw new Exceptions\DatabaseException($errors[2]);
        else {
            if (isset($row[0])) {
                $row[0]->isNew = 0;
                return $row[0];
            } else throw new Exceptions\ModelNotFoundException($id);
        }
    }

    protected function exeQuery($query): bool|\PDOStatement
    {
        return App::$connection->executeQuery($query);
    }

    protected static function prepare($query): bool|\PDOStatement
    {
        return App::$connection->prepare($query);
    }

    protected function getErrorsDB(): array
    {
        return App::$connection->getErrors();
    }

}
