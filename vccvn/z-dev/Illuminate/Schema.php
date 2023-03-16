<?php

namespace Illuminate\Support\Facades;

use Illuminate\Database\Schema\Blueprint;

class Schema
{
    /**
     * tables
     *
     * @var Blueprint[]
     */
    public static $tables = [];

    public static function create($table, $callback)
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        static::$tables[$table] = $blueprint;
    }
    public static function table($table, $callback)
    {
        if (array_key_exists($table, static::$tables)) {
            $blueprint = new Blueprint($table);
            $callback($blueprint);
            $a = $blueprint->getData();
            foreach ($a as $c) {
                if(!in_array($c, static::$tables[$table]->data)){
                    static::$tables[$table]->data[] = $c;
                }
            }
        }
    }


    public static function get($table)
    {
        return array_key_exists($table, static::$tables) ? static::$tables[$table] : (new Blueprint($table));
    }
}
