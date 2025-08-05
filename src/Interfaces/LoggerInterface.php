<?php
/**
 * This file is part of Sql Logger
 *
 * (c) Edson Quintilhano
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SqlLogger\Interfaces;

interface LoggerInterface
{
    /**
     * @param string $query The formatted SQL string.
     */
    public function writeLog($query);
}
