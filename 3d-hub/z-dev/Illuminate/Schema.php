<?php

namespace Illuminate\Support\Facades;

use Illuminate\Database\Schema\Blueprint;

class Schema {
    public static $tables = [];

    public static function create($table, $callback)
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        static::$tables[$table] = $blueprint;
    }

    public static function get($table)
    {
        return array_key_exists($table, static::$tables) ? static::$tables[$table] : (new Blueprint($table));
    }
}