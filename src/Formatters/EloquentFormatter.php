<?php
/**
 * This file is part of Sql Logger
 *
 * (c) Edson Quintilhano
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SqlLogger\Formatters;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use SqlLogger\Interfaces\FormatterInterface;

class EloquentFormatter implements FormatterInterface
{
    /**
     * @param EloquentBuilder|QueryBuilder $builder ORM builder used to build the query.
     *
     * @return string The formatted SQL string.
     */
    public static function formatter($builder)
    {
        $sql = $builder->toSql();
        $bindings = $builder->getBindings();

        foreach ($bindings as $binding) {
            if (is_string($binding)) {
                $binding = "'".addslashes($binding)."'";
            } elseif (is_null($binding)) {
                $binding = 'NULL';
            } elseif (is_bool($binding)) {
                $binding = $binding ? '1' : '0';
            }
            $sql = preg_replace('/\?/', $binding, $sql, 1);
        }

        return $sql;
    }
}
