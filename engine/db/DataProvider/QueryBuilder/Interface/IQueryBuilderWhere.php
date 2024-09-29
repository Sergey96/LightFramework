<?php

namespace engine\db\DataProvider\QueryBuilder\Interface;

interface IQueryBuilderWhere
{
   public function where(string $where): IQueryBuilderWhere;
   public function and(string $and): IQueryBuilderWhere;
   public function or(string $or): IQueryBuilderWhere;
   public function all(): IQueryBuilderWhere;
   public function asArray(): IQueryBuilderWhere;
   public function One(): IQueryBuilderWhere;
   public function exe(string $class): array|false|null;
}