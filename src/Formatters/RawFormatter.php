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

class RawFormatter
{
    /**
     * @param string $rawQuery Raw Sql Query.
     * @param array $queryParams Parameters for the SQL query.
     *
     * @return string The formatted SQL string.
     */
    public static function formatter($rawQuery = '', $queryParams = [])
    {
        if (!empty($queryParams)) {
            $isPositional = array_keys($queryParams) === range(0, count($queryParams) - 1);

            if ($isPositional) {
                foreach ($queryParams as $param) {
                    $replacement = self::formatValue($param);
                    $rawQuery = preg_replace('/\?/', $replacement, $rawQuery, 1);
                }
            } else {
                foreach (array_reverse($queryParams) as $key => $value) {
                    $replacement = self::formatValue($value);
                    $rawQuery = preg_replace("/(?<!:):$key\b/", $replacement, $rawQuery);
                }
            }
        }

        return $rawQuery;
    }

    private static function formatValue($value)
    {
        if (is_null($value)) {
            return 'NULL';
        } elseif (is_bool($value)) {
            return $value ? 'TRUE' : 'FALSE';
        } else {
            $escaped = str_replace("'", "''", $value);
            return "'$escaped'";
        }
    }
}
