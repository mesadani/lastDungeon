<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['name', 'password', 'created', 'lastlogin', 'online', 'banned'];

    public function characters()
    {
        return $this->hasMany(Character::class, 'account', 'name');
    }
}
