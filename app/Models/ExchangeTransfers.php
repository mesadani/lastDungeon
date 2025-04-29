<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeTransfers extends Model
{
    use HasFactory;

    /**
     * @var int|mixed|null
     */
    public $idType;
    /**
     * @var mixed
     */
    public $idUser;
    /**
     * @var mixed
     */
    public $amount;


    protected $table = 'exchange_transfers';
    public $timestamps = true;

    protected $fillable = ['idUser', 'idType','amount'];

    public function idUser()
    {
        return $this->belongsTo(Account::class, 'idUser', 'id');
    }


}
