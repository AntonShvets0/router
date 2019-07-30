<?php

class Router
{
    /**
     * @var array
     */
    public static $routes = [];

    /**
     * @param $error
     * @param $function
     * @return void
     */
    public static function Error($error, $function)
    {
        self::$routes['@' . $error] = $function;
    }

    /**
     * @param $expression
     * @param $function
     * @return void
     */
    public static function Add($expression, $function)
    {
        self::$routes[$expression] = $function;
    }

    /**
     * @param $expression
     * @return void
     */
    public static function Remove($expression)
    {
        unset(self::$routes[$expression]);
    }

    /**
     * @return void
     */
    public static function Run()
    {
        $uri = self::RemoveSlash(self::GetURI());

        foreach (self::$routes as $expression => $function) {
            $expression = self::RemoveSlash($expression);
            if (preg_match('~^' . $expression . '$~', $uri, $res)) {
                array_shift($res);
                $result = Call::Fn($function, $res);

                if (is_string($result) && mb_substr($result, 0, 1) == '@') {
                    $error = Call::Error(mb_substr($result, 1), self::$routes);
                    echo $error;
                    return;
                } else {
                    echo $result;
                    return;
                }
            }
        }

        echo Call::Error(404, self::$routes);
    }


    /**
     * @param string $uri
     * @return string
     */
    private static function RemoveSlash($uri)
    {
        if ($uri == '/') {
            return $uri;
        } else {
            $firstChar = mb_substr($uri, 0, 1);
            $lastChar = mb_substr($uri, mb_strlen($uri) - 1);

            if ($firstChar == '/') {
                $uri = mb_substr($uri, 1);
            }
            if ($lastChar == '/') {
                $uri = mb_substr($uri, 0, -1);
            }

            return $uri;
        }
    }

    /**
     * @return string
     */
    private static function GetURI()
    {
        return $_SERVER['REQUEST_URI'];
    }
}