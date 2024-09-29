<?php

namespace engine\db\DataProvider\QueryBuilder\Interface;
interface IQueryBuilder
{
    public function select($FieldList): IQueryBuilderFrom;
}