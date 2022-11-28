<?php

namespace core\Src\Traits;

trait SingletonTrait
{
    private static ?self $instance = null;
//    TODO: And it?
//    public static $instance = null;

    final public static function get_instance(): self
    {
        if (self::$instance === null) {
//            echo "init ";
            self::$instance = new static();
//            echo get_class(self::$instance).'<br>';
        }
        return self::$instance;
//        TODO: What is difference? Self is current class, static is derived class
//        return static::$instance;
    }

    private function __construct() {}
    final private function __wakeup() {}
    final private function __clone() {}
}


