<?php


namespace Common\Logger;

/**
 * @method static void info(string $message = "", $context = [])
 * @method static void error(string $message = "", $context = [])
 * @method static void warning(string $message = "", $context = [])
 * @method static void critical(string $message = "", $context = [])
 *
 * @see \Common\Logger\Log
 */

class LoggerFacade
{
    static private ?LoggerInterface $log = null;

    public static function __callStatic($name, $arguments)
    {
        $log = self::getOrCreateFacade();

        if (method_exists($log,$name))
        {
            return $log->{$name}(...$arguments);
        }

        throw new \Exception("Method not exists in Route class",500);
    }


    private static function getOrCreateFacade(): Log
    {
        if (!self::$log)
        {
            return self::$log = new Log();
        }
        return self::$log;
    }
}