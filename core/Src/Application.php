<?php

namespace core\Src;

use core\Src\CoreSettings;
use core\Src\ProjectSettings;
use core\Src\Route;
use core\Src\Auth\Auth;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

use Error;

class Application
{
    private CoreSettings $cs;
    private ProjectSettings $ps;
    private Route $route;
    public Capsule $db_manager;
    private Auth $auth;

    public function __construct(ProjectSettings $project_settings)
    {

        // TODO: Как быть? Я бы хотел подключить все маршруты внутри Route,
        // но он не знает, где они, знает CoreSetting.
        // 1. Создать метод Route, который бы принимал необходимые данные от Application и вызывался здесь.
        // 2. В конструктор Route передавать ссылку на CoreSetting и всю работу делать внутри Route.

        $this->cs = new CoreSettings();
        $this->ps = $project_settings;
        $this->route = Route::get_instance();
        $this->route->set_app_prefix($this->ps->get_app_prefix());

        // Создаем класс менеджера для базы данных
        $this->db_manager = new Capsule();

        // Создаем класс для аутентификации на основе настроек приложения
        $this->auth = new $this->ps->app['auth']();

        //Настройка для работы с базой данных
        $this->run_db();

        //Инициализация класса пользователя на основе настроек приложения
        $this->auth::init(new $this->ps->app['identity'] () );
    }

    public function __get($key)
    {
        switch ($key) {
            case 'cs':
                return $this->cs;
            case 'ps':
                return $this->ps;
            case 'route':
                return $this->route;
            case 'auth':
                return $this->auth;
            default:
                throw new Error('Accessing a non-existent property');
        }
    }

    public function run_db(): void
    {
        $this->db_manager->addConnection($this->ps->get_db_conf());
        $this->db_manager->setEventDispatcher(new Dispatcher(new Container()));
        $this->db_manager->setAsGlobal();
        $this->db_manager->bootEloquent();
    }

    public function run()
    {
        $this->route->map2();
    }
}