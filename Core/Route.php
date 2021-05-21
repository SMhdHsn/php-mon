<?php

namespace Core;

error_reporting(E_ERROR | E_PARSE);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

use Core\Traits\{Authentication, Helper};

/**
 * @author @smhdhsn
 * 
 * @version 1.1.0
 */
class Route
{
    use Authentication, Helper;

    /**
     * Handling GET Requests.
     * 
     * @since 1.1.0
     * 
     * @param array|null $middlewares
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function get(string $route, $action, array $middlewares = null): void
    {
        if (strtok($_SERVER["REQUEST_URI"], '?') == $route) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                ! isset($middlewares) ?: self::handleMiddlewares($middlewares);

                self::response($action);
            }
            self::methodNotAllowed();
        }
    }

    /**
     * Handling POST Requests.
     * 
     * @since 1.1.0
     * 
     * @param array|null $middlewares
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function post(string $route, $action, array $middlewares = null): void
    {
        if (strtok($_SERVER["REQUEST_URI"], '?') == $route) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                ! isset($middlewares) ?: self::handleMiddlewares($middlewares);

                self::response($action);
            }
            self::methodNotAllowed();
        }
    }

    /**
     * Handling PUT Requests.
     * 
     * @since 1.1.0
     * 
     * @param array|null $middlewares
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function put(string $route, $action, array $middlewares = null): void
    {
        if (strtok($_SERVER["REQUEST_URI"], '?') == $route) {
            if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
                ! isset($middlewares) ?: self::handleMiddlewares($middlewares);

                self::response($action);
            }
            self::methodNotAllowed();
        }
    }

    /**
     * Handling DELETE Requests.
     * 
     * @since 1.1.0
     * 
     * @param array|null $middlewares
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function delete(string $route, $action, array $middlewares = null): void
    {
        if (strtok($_SERVER["REQUEST_URI"], '?') == $route) {
            if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                ! isset($middlewares) ?: self::handleMiddlewares($middlewares);

                self::response($action);
            }
            self::methodNotAllowed();
        }
    }
}