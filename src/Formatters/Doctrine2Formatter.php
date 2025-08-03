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

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
use SqlLogger\Interfaces\FormatterInterface;

class Doctrine2Formatter implements FormatterInterface
{
    /**
     * @param QueryBuilder|Query $builder
     */
    public static function formatter(object $builder)
    {
        if ($builder instanceof QueryBuilder) {
            $query = $builder->getQuery();
        } elseif ($builder instanceof Query) {
            $query = $builder;
        } else {
            throw new \InvalidArgumentException('Expected Doctrine\ORM\Query or Doctrine\ORM\QueryBuilder');
        }

        $sql = $query->getSQL();

        $params = [];
        foreach ($query->getParameters() as $param) {
            $value = $param->getValue();

            if (is_string($value)) {
                $value = "'" . addslashes($value) . "'";
            } elseif (is_bool($value)) {
                $value = $value ? '1' : '0';
            } elseif (is_null($value)) {
                $value = 'NULL';
            }

            $params[] = $value;
        }

        foreach ($params as $param) {
            $sql = preg_replace('/\?/', $param, $sql, 1);
        }

        return $sql;
    }
}
