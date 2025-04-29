<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'accounts';
    protected $primaryKey = 'name';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['name', 'password'];

    // Hashear con pbkdf2 cuando se guarda la contraseña
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = self::pbkdf2_hash($value, self::generateSalt($this->attributes['name'] ?? ''));
    }
    public function character()
    {
        return $this->hasOne(Character::class, 'account', 'name');
    }

    public function balance()
    {
        return $this->hasOne(UserBalance::class, 'idUser', 'id');
    }
    public function checkPassword($password)
    {

        $salt = self::generateSalt($this->name);
        $hash = self::pbkdf2_hash($password, $salt);

        return $hash === $this->password;
    }

    // Función de hashing
    private static function pbkdf2_hash($password, $salt)
    {
        $iterations = 10000;
        $key_length = 20;
        $binary_hash = hash_pbkdf2("sha1", $password, $salt, $iterations, $key_length, true);
        return strtoupper(bin2hex($binary_hash));
    }

    // Generar salt
    private static function generateSalt($user)
    {
        return "at_least_16_byte" . $user;
    }
}
