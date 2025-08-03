<?php
/**
 * This file is part of Sql Logger
 *
 * (c) Edson Quintilhano
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SqlLogger\Factories;

use SqlLogger\Formatters\Doctrine1Formatter;
use SqlLogger\Formatters\Doctrine2Formatter;
use SqlLogger\Formatters\EloquentFormatter;
use SqlLogger\Interfaces\FormatterInterface;

class FormatterFactory
{
    /**
     * @return FormatterInterface|null
     */
    public static function getFormatter(object $builder)
    {
        if (class_exists('Doctrine_Core') && $builder instanceof \Doctrine_Query) {
            return Doctrine1Formatter::class;
        }

        if (class_exists(\Doctrine\ORM\QueryBuilder::class) && $builder instanceof \Doctrine\ORM\QueryBuilder
        || class_exists(\Doctrine\ORM\Query::class) && $builder instanceof \Doctrine\ORM\Query) {
            return Doctrine2Formatter::class;
        }

        if (class_exists(\Illuminate\Database\Eloquent\Builder::class) && $builder instanceof \Illuminate\Database\Eloquent\Builder
        || class_exists(\Illuminate\Database\Query\Builder::class) && $builder instanceof \Illuminate\Database\Query\Builder) {
            return EloquentFormatter::class;
        }

        return null;
    }
}
