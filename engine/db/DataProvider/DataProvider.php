<?php

namespace engine\db\DataProvider;

use engine\App;
use engine\core\DB\DataBase;
use engine\db\DataProvider\Interface\IDataProvider;
use engine\db\DataProvider\QueryBuilder\Mysql\MysqlQueryBuilder;
use engine\db\DataProvider\QueryBuilder\Psql\PsqlQueryBuilder;
use engine\db\DataProvider\QueryBuilder\Interface\IQueryBuilder;
use engine\db\DataProvider\QueryBuilder\Interface\IQueryBuilderFrom;

class DataProvider implements IDataProvider
{
    private IQueryBuilder $builder;

    public function __construct($query = '')
    {
        if (App::$connection->getType() === DataBase::DATABASE_TYPE_MYSQL) {
            $this->builder = new MysqlQueryBuilder($query);
        } else {
            $this->builder = new PsqlQueryBuilder($query);
        }
    }

    public function select($FieldList): IQueryBuilderFrom
    {
        return $this->builder->select($FieldList);
    }
}