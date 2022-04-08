<?php


namespace Core\Route\Middleware;


use Core\Route\Router;

trait MiddlewareFriend
{
    private array $__friends = array(Router::class);

    public function __get($key)
    {
        $trace = debug_backtrace();
        if(isset($trace[1]['class']) && in_array($trace[1]['class'], $this->__friends)) {
            return $this->$key;
        }

        // normal __get() code here

        trigger_error('Cannot access private property ' . __CLASS__ . '::$' . $key, E_USER_ERROR);
    }

    public function __set($key, $value)
    {
        $trace = debug_backtrace();
        if(isset($trace[1]['class']) && in_array($trace[1]['class'], $this->__friends)) {
            return $this->$key = $value;
        }

        // normal __set() code here

        trigger_error('Cannot access private property ' . __CLASS__ . '::$' . $key, E_USER_ERROR);
    }
}