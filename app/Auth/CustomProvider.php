<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;
use App\Models\User;

class CustomUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        return User::find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return User::where('id', $identifier)->where('remember_token', $token)->first();
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
        $user->save();
    }

    public function retrieveByCredentials(array $credentials)
    {
        return User::where('email', $credentials['email'])->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $inputPassword = $credentials['password'];
        $salt = "at_least_16_byte" . $user->email; // O el campo que usas para $user
        $inputHash = $this->pbkdf2_hash($inputPassword, $salt);

        return $inputHash === $user->password;
    }

    private function pbkdf2_hash($password, $salt)
    {
        $iterations = 10000;
        $key_length = 20;
        $binary_hash = hash_pbkdf2("sha1", $password, $salt, $iterations, $key_length, true);
        return strtoupper(bin2hex($binary_hash));
    }
}
