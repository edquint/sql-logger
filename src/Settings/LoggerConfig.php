<?php
/**
 * This file is part of Sql Logger
 *
 * (c) Edson Quintilhano
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SqlLogger\Settings;

use SqlLogger\Handlers\LoggerFileHandler;
use SqlLogger\Interfaces\LoggerInterface;

class LoggerConfig
{
    private static $writable = true;
    private static $path = '';
    private static $name = '';
    private static $handlers = [];

    /**
     * @param LoggerInterface;
     */
    public static function setHandler(LoggerInterface $handler)
    {
        self::$handlers[] = $handler;
    }

    /**
     * @return array<LoggerInterface>;
     */
    public static function getHandlers()
    {
        if (empty(self::$handlers)) {
            return [LoggerFileHandler::class];
        }

        return self::$handlers;
    }

    /**
     * @param string $path Log File Path
     */
    public static function setLogPath(string $path)
    {
        self::$path = $path;
    }

    /**
     * Log File Path
     * @return string
     */
    public static function getLogPath()
    {
        if (empty(self::$path)) {
            $basePath = realpath(__DIR__ . "/../../../../../");
            self::$path = $basePath ? $basePath . DIRECTORY_SEPARATOR . "log" : false;
        }

        return self::$path;
    }

    /**
     * @param string $name Log File Name
     */
    public static function setFileName(string $name)
    {
        self::$name = $name;
    }

    /**
     * Log File Name
     * @return string
     */
    public static function getFileName()
    {
        if (empty(self::$name)) {
            return "SqlQuery.log";
        }

        return self::$name;
    }

    /**
     * @param bool $writable Log is Writable
     */
    public static function setWritable(bool $writable)
    {
        self::$writable = $writable;
    }

    /**
     * Log is Writable
     * @return bool
     */
    public static function isWritable()
    {
        return self::$writable;
    }
}
