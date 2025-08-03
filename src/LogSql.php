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
     * @param string $rawQuery Raw Sql Query
     * @param array $queryParams Parameters for the SQL query
     * @param bool $formatter Whether to format the query for better readability
     * @return string
     */
    public static function raw(string $rawQuery, array $queryParams = [], bool $formatter = true)
    {
        $query = RawFormatter::formatter($rawQuery, $queryParams);

        return self::writeLog($query, $formatter);
    }

    /**
     * @param object $builder ORM builder used to build the query
     * @param bool $formatter Whether to format the query for better readability
     * @return string|null
     */
    public static function orm(object $builder, bool $formatter = true)
    {
        $formatterClass = FormatterFactory::getFormatter($builder);
        if (!is_null($formatterClass)) {
            $query = $formatterClass::formatter($builder);

            return self::writeLog($query, $formatter);
        }

        return null;
    }

    private static function writeLog(string $query, bool $formatter)
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
