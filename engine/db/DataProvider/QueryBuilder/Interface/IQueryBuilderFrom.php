<?php

namespace engine\db\DataProvider\QueryBuilder\Interface;

interface IQueryBuilderFrom
{
    public function from($table): IQueryBuilderWhere;
}