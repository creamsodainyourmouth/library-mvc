<?php

namespace app\Models;
use core\Src\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use core\Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;

    const ADMIN_ROLE = 1;
    const READER_ROLE = 0;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password'
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            Reader::create([
               'user_id' => $user->id
            ]);
            $user->name .= 'NAME';
            $user->save();
        });
    }

    public function find_identity(int $id)
    {
        // Запрос к бд
        return self::where('id', $id)->first();
    }

    public function get_id(): int
    {
        return $this->id;
    }

    public function get_role(): int
    {
        return $this->role;
    }


    public function isAdmin(): bool
    {
        $id = Session::get('id') ?? 0;
        return $this->find_identity($id)->role === self::ADMIN_ROLE;
    }

    public function attempt_identity(array $credentials)
    {
        return self::where([
            'email' => $credentials['email'],
            'password' => md5($credentials['password'])
        ])->first();
    }
}