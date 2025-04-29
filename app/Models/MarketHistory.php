<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketHistory extends Model
{
    use HasFactory;
    protected $table = 'market_history';
    public $timestamps = true;

    protected $fillable = ['idUser', 'idItem', 'nameItem', 'price', 'status'];

    public function userHistory()
    {
        return $this->belongsTo(Account::class, 'idUser', 'id');
    }

    public function itemHistory()
    {
        return $this->belongsTo(Items::class, 'idItem', 'id');
    }
}
