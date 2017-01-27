<?php

namespace FatFramework;
 
class Registry
{
    /**
     * @var array
     */
    protected static $items = array();

    /**
     * @param $key
     * @return mixed|null
     */

    public static function get($key)
    {
        return isset(self::$items[$key]) ? self::$items[$key] : null;
    }

    /**
     * @param $key
     * @param $object
     */
    public static function set($key, $object)
    {
        self::$items[$key]=$object;
    }
}