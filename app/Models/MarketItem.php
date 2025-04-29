<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MarketItem extends Model
{
    use HasFactory;
    protected $table = 'market_items';
    public $timestamps = true;

    protected $fillable = ['seller_id', 'character_bank_id', 'price', 'status', 'idItem', 'amount'];

    public function seller()
    {
        return $this->belongsTo(Account::class, 'seller_id', 'id');
    }

    public function inventoryItem()
    {
        return $this->belongsTo(CharacaterBank::class, 'character_bank_id', 'id');
    }
}
