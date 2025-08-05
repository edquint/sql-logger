<?php
/**
 * This file is part of Sql Logger
 *
 * (c) Edson Quintilhano
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use SqlLogger\LogSql;
use SqlLogger\Settings\LoggerConfig;

if (!function_exists('sql_logger')) {
    /**
     * Generates and returns a formatted SQL string from a raw SQL query or ORM object,
     * with optional parameters and configuration overrides.
     *
     * Supported inputs:
     * - Raw SQL string (with optional parameters)
     * - ORM query builder objects:
     *     - \Doctrine_Query
     *     - \Doctrine\ORM\QueryBuilder
     *     - \Doctrine\ORM\Query
     *     - \Illuminate\Database\Eloquent\Builder
     *     - \Illuminate\Database\Query\Builder
     *
     * @param string|object        $query Raw SQL string or ORM object to be logged.
     * @param array|null           $queryParams Parameters for SQL interpolation (used only with raw SQL).
     * @param array                $options {
     *     Optional settings to override behavior for this specific call.
     *
     *     @type bool $formatter Whether to format the SQL output (default: true).
     *     @type bool $save      If false, temporarily disables logging for this call.
     * }
     *
     * @return string|null The formatted SQL string, or null if the input is invalid.
     */
    function sql_logger($query, $queryParams = null, $options = []) {
        $originalWritable = LoggerConfig::isWritable();

        $formatter = isset($options['formatter']) && is_bool($options['formatter']) ? $options['formatter'] : true;
        $isWritable = isset($options['save']) && is_bool($options['save']) ? $options['save'] : $originalWritable;

        LoggerConfig::setWritable($isWritable);

        $sql = null;
        if (is_object($query)) {
            $sql = LogSql::orm($query, $formatter);
        } elseif (is_string($query)) {
            $sql = LogSql::raw($query, $queryParams, $formatter);
        }

        LoggerConfig::setWritable($originalWritable);

        return $sql;
    }
}
