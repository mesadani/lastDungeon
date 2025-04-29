<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    use HasFactory;
    protected $table = 'user_balance';
    public $timestamps = true;

    protected $fillable = ['idUser', 'balance'];

    public function idUser()
    {
        return $this->belongsTo(Account::class, 'idUser', 'id');
    }

}
