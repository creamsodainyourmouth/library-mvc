<?php

namespace core\Src;

use app\Middlewares\Middleware;
use core\Src\CoreSettings as CS;
use core\Src\Request;
use Error;


use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\MarkBased;
use FastRoute\Dispatcher\MarkBased as Dispatcher;

use core\Src\Traits\SingletonTrait;

class Route
{
    use SingletonTrait;

    private static array $routes = [];
    private static string $app_prefix = "";
    private string $current_route = "";
    private $current_http_method;

    //Классы для использования внешнего маршрутизатора
    private RouteCollector $routeCollector;

    //Конструктор скрыт. Вызывается только один раз
    private function __construct()
    {
//        Дополнительный вызов метода приводил к дополнительному вызову конструктора!!! Т.е. 2 раза вместо 1
//        $this->load_routes();

//        Почему тут? И где вообще оно будет храниться? В единственном экземпляре Route?
        $this->routeCollector = new RouteCollector(new Std(), new MarkBased());
    }

    // Как правильно и почему. Определять префикс через метод или конструктор?
    public static function set_app_prefix(string $prefix)
    {
        self::$app_prefix = $prefix;
    }

    public static function load_routes(): void
    {
        $routes_dir = CS::get_root_routes_dir();

        // TODO: array_map remake
        foreach (array_diff(scandir($routes_dir), array('.', '..')) as $route) {
            require_once $routes_dir."/$route";
        }
    }

    //Добавляет маршрут, устанавливает его текущим и возвращает объект
    public static function add($httpMethod, string $route, array $action): self
    {
        self::get_instance()->routeCollector->addRoute($httpMethod, $route, $action);
        self::get_instance()->current_http_method = $httpMethod;
        self::get_instance()->current_route = $route;
        return self::get_instance();
    }

    //Добавляет префикс для обозначенных маршрутов
    public static function group(string $prefix, callable $callback): void
    {
        self::get_instance()->routeCollector->addGroup($prefix, $callback);
        Middleware::get_instance()->group($prefix, $callback);
    }

    public function get_url(string $url): string
    {
        return self::$app_prefix . "$url";
    }

    public function redirect(string $url): void
    {
        header("Location:" . $this->get_url($url));
    }

    //Добавление middlewares для текущего маршрута
    public function middleware(...$middlewares): self
    {
        Middleware::get_instance()->add(
            $this->current_http_method,
            $this->current_route,
            $middlewares
        );
        return $this;
    }


    // deprecated
    public function map(): void
    {
        $parsed_uri = explode('?', $_SERVER['REQUEST_URI']);
        $resource = $parsed_uri[0];
        $route = substr($resource, strlen(self::$app_prefix) + 1);
//        $route = explode('/', $route);

        // Обёртка, декоратор или так сойдет?
        if (!array_key_exists($route, self::$routes)) {
            http_response_code(404);
            echo "404<br>";
//            throw new Error(
//                "This route `$route` does not define.See project/app/Routes\n"
//            );
            return;
        }

        $controller = self::$routes[$route][0];
        $action = self::$routes[$route][1];

        if (!class_exists($controller)) {
            throw new Error(
                "Controller `$controller` does not define. See project/app/Controllers\n"
            );
        }
        if (!method_exists($controller, $action)) {
            throw new Error(
                "Action `$action` of Controller `$controller` does not define. See project/app/Controllers\n"
            );
        }

        call_user_func([new $controller, $action], new Request());
    }

    public function map2()
    {
        self::load_routes();

        // Fetch method and URI from somewhere
        $http_method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        // example.com/foo/bar?baz=2
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        $uri = substr($uri, strlen(self::$app_prefix));

        $dispatcher = new Dispatcher($this->routeCollector->getData());
        $routeInfo = $dispatcher->dispatch($http_method, $uri);

//        echo '<pre>';
//        print_r(self::get_instance());
//        echo '</pre>';


        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new Error('NOT_FOUND');
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new Error('METHOD_NOT_ALLOWED');
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = array_values($routeInfo[2]);


//                $vars[] = Middleware::get_instance()->runMiddlewares($http_method, $uri);

                //Вызываем обработку всех Middleware
                $vars[] = Middleware::get_instance()->go($http_method, $uri, new Request());

                $class = $handler[0];
                $action = $handler[1];
                call_user_func([new $class, $action], ...$vars);
                break;
        }
    }
}