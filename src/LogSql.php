<?php
/**
 * This file is part of Sql Logger
 *
 * (c) Edson Quintilhano
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SqlLogger;

use SqlLogger\Factories\FormatterFactory;
use SqlLogger\Formatters\RawFormatter;
use SqlLogger\Interfaces\LoggerInterface;
use SqlLogger\Settings\LoggerConfig;

class LogSql
{
    /**
     * Generates and returns a formatted SQL string from a raw SQL query.
     *
     * @param string $rawQuery Raw Sql Query.
     * @param array|null $queryParams Parameters for the SQL query.
     * @param bool $formatter Whether to format the query for better readability.
     *
     * @return string The formatted SQL string.
     */
    public static function raw($rawQuery, $queryParams = null, $formatter = true)
    {
        if (is_array($queryParams)) {
            $rawQuery = RawFormatter::formatter($rawQuery, $queryParams);
        }

        return self::writeLog($rawQuery, $formatter);
    }

    /**
     * Generates and returns a formatted SQL string from a ORM object.
     *
     * Supported ORM query builder objects:
     * - \Doctrine_Query
     * - \Doctrine\ORM\QueryBuilder
     * - \Doctrine\ORM\Query
     * - \Illuminate\Database\Eloquent\Builder
     * - \Illuminate\Database\Query\Builder
     *
     * @param object $builder ORM builder used to build the query.
     * @param bool $formatter Whether to format the query for better readability.
     *
     * @return string|null The formatted SQL string, or null if the input is invalid.
     */
    public static function orm($builder, $formatter = true)
    {
        $formatterClass = FormatterFactory::getFormatter($builder);
        if (!is_null($formatterClass)) {
            $query = $formatterClass::formatter($builder);

            return self::writeLog($query, $formatter);
        }

        return null;
    }

    /**
     * @param object $builder ORM builder used to build the query.
     * @param string The formatted SQL string.
     *
     * @return string The formatted SQL string.
     */
    private static function writeLog($query, $formatter)
    {
        if ($formatter) {
            $query = \SqlFormatter::format($query, false);
        }

        if (LoggerConfig::isWritable()) {
            $handlers = LoggerConfig::getHandlers();
            foreach ($handlers as $handler) {
                $classHandler = new $handler;
                if ($classHandler instanceof LoggerInterface) {
                    $classHandler->writeLog($query);
                }
            }
        }

        return $query;
    }
}
