<?php
/**
 * This file is part of Sql Logger
 *
 * (c) Edson Quintilhano
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SqlLogger\Handlers;

use SqlLogger\Interfaces\LoggerInterface;
use SqlLogger\Settings\LoggerConfig;

class LoggerFileHandler implements LoggerInterface
{
    public function writeLog(string $query)
    {
        $path = LoggerConfig::getLogPath();

        if (!is_dir($path)) {
            trigger_error("Path {$path} does not exists.", E_USER_NOTICE);
            return;
        }

        $currentTime = date("Y-m-d H:i:s");
        $stringQuery = "[{$currentTime}] SQL Query:\n{$query}\n;\n";

        $file = $path . DIRECTORY_SEPARATOR . LoggerConfig::getFileName();

        $fp = fopen($file, "a+");

        fwrite($fp, $stringQuery);
        fclose($fp);
    }
}
