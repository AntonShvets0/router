<?php


abstract class Call
{
    /**
     * @param $error
     * @param $router_list
     * @return mixed|string
     */
    public static function Error($error, $router_list)
    {
        if (isset($router_list['@' . $error])) {
            return self::Fn($router_list['@' . $error]);
        }
        return "";
    }

    /**
     * @param $function
     * @param array $args
     * @return mixed
     */
    public static function Fn($function, $args = [])
    {
        if (is_string($function)) {
            if (strrpos($function, '@')) {
                @list($controller, $action) = explode('@', $function);

                $controller = 'Controller' . ucfirst($controller);
                $action = 'Action' . ucfirst($action);

                include_once ROOT . '/Controller/' . $controller . '.php';

                $class = new $controller;
                return call_user_func_array([$class, $action], $args);
            } else {
                return call_user_func_array($function, $args);
            }
        } else {
            return call_user_func_array($function, $args);
        }
    }
}