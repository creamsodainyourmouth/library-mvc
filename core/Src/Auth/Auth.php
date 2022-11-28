<?php

namespace core\Src\Auth;

use app\Models\Reader;
use app\Models\User;
use core\Src\Session;

class Auth
{
    //Свойство для хранения любого класса, реализующего интерфейс
    //IdentityInterface
    private static IdentityInterface $user;

    //Инициализация класса пользователя
    public static function init(IdentityInterface $user): void
    {
        self::$user = $user;
        if (self::user()) {
            self::login(self::user());
        }
    }

    //Вход пользователя по модели
    public static function login(IdentityInterface $user): void
    {
        self::$user = $user;
        $role = self::$user->get_role();
        $user_id = self::$user->get_id();
        Session::set('id', $user_id);
        Session::set('role', $role);
        if ($role === User::READER_ROLE) {
            Session::set('lib_card', Reader::get_lib_card_by_user_id($user_id));
        }
    }

    //Аутентификация пользователя и вход по учетным данным
    public static function attempt(array $credentials): bool
    {
        $user = self::$user->attempt_identity($credentials);
        if ($user) {
            self::login($user);
            return true;
        }
        return false;
    }

    //Возврат текущего аутентифицированного пользователя
    public static function user()
    {
        $id = Session::get('id') ?? 0;
        return self::$user->find_identity($id);
    }

    //Проверка является ли текущий пользователь аутентифицированным
    public static function check(): bool
    {
        if (self::user()) {
            return true;
        }
        return false;
    }

    //Выход текущего пользователя
    public static function logout(): bool
    {
        Session::clear('id');
        return true;
    }

}