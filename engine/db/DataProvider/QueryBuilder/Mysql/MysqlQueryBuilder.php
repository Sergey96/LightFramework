<?php

namespace engine\db\DataProvider\QueryBuilder\Mysql;


use engine\db\DataProvider\QueryBuilder\Interface\IQueryBuilder;
use engine\db\DataProvider\QueryBuilder\Interface\IQueryBuilderFrom;

class MysqlQueryBuilder implements IQueryBuilder
{
    private $query;
    public function __construct($query = '')
    {
        $this->query = $query;
    }

    public function select($FieldList): IQueryBuilderFrom
    {
        $fields = $this->getStringFromArray($FieldList);
        $this->query = "SELECT $fields ";
        return new MysqlQueryBuilderFrom($this->query);
    }

    private function getStringFromArray($array)
    {
        $str = '';
        foreach ($array as $k => $v) {
            if ($k == 0) {
                $str .= $v;
            } else {
                $str .= ", $v";
            }
        }

        return $str;
    }
}