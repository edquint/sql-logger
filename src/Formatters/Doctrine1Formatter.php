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

use SqlLogger\Interfaces\FormatterInterface;

class Doctrine1Formatter implements FormatterInterface
{
    /**
     * @param \Doctrine_Query $builder ORM builder used to build the query.
     *
     * @return string The formatted SQL string.
     */
    public static function formatter($builder)
    {
        $query = $builder->getSqlQuery();
        $valuesFilter = $builder->getParams()['where'];

        foreach ($valuesFilter as $value) {
            $query = preg_replace("/\?/", "'$value'", $query, 1);
        }

        return $query;
    }
}
