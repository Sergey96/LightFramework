<?php

namespace engine\core\validator;

use engine\App;

class Validator
{
    public static function validate($type, $value, $params = array())
    {
        $group = null;
        foreach (self::$TypeGroups as $k => $v) {
            if (array_search($type, $v) !== false) {
                $group = $k;
                break;
            }
        }
        switch ($group) {
            case 'int':
                $result = self::validateInt($value, $type);
                break;
            case 'decimal':
                $result = self::validateDecimal($value, $type);
                break;
            case 'float':
                $result = self::validateFloat($value, $type);
                break;
            case 'varchar':
                $result = self::validateChar($value, $type);
                break;
            case 'text':
                $result = self::validateText($value, $type);
                break;
            case 'datetime':
                $result = self::validateDate($value, $type);
                break;
        }
        return $result;
    }

    public static function validateInt($value, $type)
    {
        return is_int($value + 1 - 1) && self::$MYSQL_TYPES[$type]['min'] < $value && $value < self::$MYSQL_TYPES[$type]['max'];
    }

    public static function validateDecimal($value, $type)
    {
        if (self::is_decimal($value))
            return true;
    }

    public static function validateFloat($value, $type)
    {
        if (self::is_decimal($value))
            return true;
    }

    public static function validateChar($value, $type)
    {
        if (is_string($value) && strlen($value) < self::$MYSQL_TYPES[$type]['length'])
            return true;
    }

    public static function validateText($value, $type)
    {
        if (is_string($value) && strlen($value) < self::$MYSQL_TYPES[$type]['length'])
            return true;
    }

    public static function validateDate($value, $type)
    {
        switch ($type) {
            case 'datetime':
                return self::validateDateTime($value);
            case 'date':
                return self::validateDateTime($value, 'Y-m-d');
            case 'year':
                return (self::MYSQL_TYPES[$type]['min'] < $value && $value < self::MYSQL_TYPES[$type]['max']);
            case 'timestamp':
                return true;
        }
    }

    public static function validateDateTime($date, $format = 'Y-m-d H:i:s')
    {
        $d = date_parse_from_format($format, $date);
        return !($d['warning_count'] || $d['error_count']);
    }

    public static function is_decimal($val)
    {
        return preg_match('/^[0-9]+[\.]{0,1}[0-9]*$/', $val, $matches);
    }

    public static $TypeGroups = [
        'int' => ['int', 'bigint', 'tinyint', 'smallint', 'mediumint'],
        'decimal' => ['decimal', 'dec', 'numeric'],
        'float' => ['float', 'double'],
        'bool' => ['bool', 'boolean'],
        'varchar' => ['varchar', 'char'],
        'text' => ['text', 'mediumtext', 'longtext', 'tinyblob', 'blob', 'mediumblob', 'longblob'],
        'datetime' => ['datetime', 'date', 'time', 'year', 'timestamp'],
        'enum' => ['enum', 'set']
    ];


    public static $MYSQL_TYPES = Array(
        // INTEGER
        // byte — кол-во байт на хранение,
        // max/min — предельные значения,
        // umax/umin — беззнаковые предельные значения
        'int' => Array('byte' => 4, 'min' => -2147483648, 'max' => 2147483647, 'umin' => 0, 'umax' => 4294967295),
        'bigint' => Array('byte' => 8, 'min' => -9223372036854775808, 'max' => 9223372036854775807, 'umin' => 0, 'umax' => 18446744073709551615),
        'tinyint' => Array('byte' => 1, 'min' => -128, 'max' => 127, 'umin' => 0, 'umax' => 255),
        'smallint' => Array('byte' => 2, 'min' => -32768, 'max' => 32767, 'umin' => 0, 'umax' => 65535),
        'mediumint' => Array('byte' => 3, 'min' => -8388608, 'max' => 8388607, 'umin' => 0, 'umax' => 16777215),

        // DECIMAL   DECIMAL(M,D) m — кол-во цифр (max 65 цифр), d — сколько из них могут быть после запятой
        // min_byte/max_byte — краевые значения размера поля в байтах,
        // byte_formula — формула вычисления размерности
        // length — максимальное кол-во цифр
        'decimal' => Array('min_byte' => 2, 'max_byte' => 67, 'byte_formula' => '(D==0?(M+1):(M+2)', 'length' => 65),
        'dec' => Array('min_byte' => 2, 'max_byte' => 67, 'byte_formula' => 'D==0?(M+1):(M+2)', 'length' => 65),
        'numeric' => Array('min_byte' => 2, 'max_byte' => 67, 'byte_formula' => 'D==0?(M+1):(M+2)', 'length' => 65),

        // FLOAT DOUBLE
        // Внимание! Не храните денежные значения в этих полях!!! Деньги надо хранить — в DECIMAL
        // у FLOAT ТОЧНОСТЬ ТОЛЬКО 7 ЦИФР!!! (все остальные цифры «смазываются»)
        // у DOUBLE ТОЧНОСТЬ ТОЛЬКО 15 ЦИФР!!! (все остальные цифры «смазываются»)
        // byte — кол-во байт для хранения поля (по-умолчанию)
        // max_byte — максимальное кол-во байт для хранения
        // negative_min/negative_max — минмаксы для отрицательных чисел
        // positive_min/positive_max — минмаксы для положительных чисел
        'float' => Array('byte' => 4, 'max_byte' => 8, 'negative_min' => -3.402823466E+38, 'negative_max' => -1.175494351E-38, 'positive_min' => 1.175494351E-38, 'positive_max' => 3.402823466E+38),
        'double' => Array('byte' => 8, 'negative_min' => -1.7976931348623157E+308, 'negative_max' => -2.2250738585072014E-308, 'positive_min' => 2.2250738585072014E-308, 'positive_max' => 1.7976931348623157E+308),

        // BOOLEAN
        // сами все поймете
        'bool' => Array('byte' => 1, 'true' => 1, 'false' => 0),
        'boolean' => Array('byte' => 1, 'true' => 1, 'false' => 0),

        // VARCHAR
        // byte — кол-во байт отведенных для хранения (можно задать меньше)
        // min_byte — минимальное кол-во байт в которых может храниться поле (если длина равна 1)
        // В MYSQL 5.0.3 и выше, VARCHAR может быть до 65,535 символов!!!
        // length — максимальная длина символов в поле
        'varchar' => Array('byte' => 256, 'min_byte' => 2, 'length' => 255),
        'char' => Array('byte' => 256, 'min_byte' => 2, 'length' => 255),

        // TEXT
        // byte — кол-во байт для хранения поля
        // min_byte — минимальное кол-во байт для хранения одного символа (если длина поля равна 1)
        // length — максимальное количество символов в поле
        'tinytext' => Array('byte' => 256, 'min_byte' => 2, 'length' => 255),
        'text' => Array('byte' => 65537, 'min_byte' => 3, 'length' => 65535),
        'mediumtext' => Array('byte' => 16777218, 'min_byte' => 4, 'length' => 16777215),
        'longtext' => Array('byte' => 4294967300, 'min_byte' => 5, 'length' => 4294967296),
        'tinyblob' => Array('byte' => 256, 'min_byte' => 2, 'length' => 255),
        'blob' => Array('byte' => 65537, 'min_byte' => 3, 'length' => 65535),
        'mediumblob' => Array('byte' => 16777219, 'min_byte' => 4, 'length' => 16777215),
        'longblob' => Array('byte' => 4294967300, 'min_byte' => 5, 'length' => 4294967296),

        // DATETIME
        // byte — кол-во байт для хранения значения поля
        // mask — стандартная маска ввода значения (есть куча других вариантов, о них читайте в мануале)
        // min/max — минимальные максимальные значения дат которые сохраняют поля
        'datetime' => Array('byte' => 8, 'mask' => 'YYYY-MM-DD HH:MM:SS', 'min' => '1000-01-01 00:00:00', 'max' => '9999-12-31 23:59:59'),
        'date' => Array('byte' => 3, 'mask' => 'YYYY-MM-DD', 'min' => '1000-01-01', 'max' => '9999-12-31'),
        'time' => Array('byte' => 3, 'min' => '-838:59:59', 'max' => '838:59:59'),
        'year' => Array('byte' => 1, 'min' => 1901, 'max' => 2155),
        'timestamp' => Array('byte' => 4, 'mask' => Array(14 => 'YYYYMMDDHHMMSS', 12 => 'YYMMDDHHMMSS', 10 => 'YYMMDDHHMM', 8 => 'YYYYMMDD', 6 => 'YYMMDD', 4 => 'YYMM', 2 => 'YY'), 'min' => 1970, 'max' => 2036),

        // ENUM
        // byte — кол-во байт на хранение поля
        // max_byte — максимальное кол-во байт, которое можно достигнуть при максимальном кол-ве элементов
        // max_number_of_element — кол-во элементов, которое может содержать поле
        'enum' => Array('byte' => 1, 'max_byte' => 2, 'max_number_of_element' => 65535),
        'set' => Array('byte' => 1, 'max_byte' => 8, 'max_number_of_element' => 64)
    );

}