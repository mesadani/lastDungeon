<?php

namespace App\Tools;

use App\Models\ExchangeTransfers;

class Exchange
{
    static function getType($type)
    {
        switch ($type){
            case 'buyAurium':
                return 1;
                break;
            case 'sellAurium':
                return 2;
                break;
            case 'buyMarket':
                return 3;
                break;
            case 'sellMarket':
                return 4;
                break;
            case 'buyPack':
                return 5;
                break;
            case 'missions':
                return 6;
                break;
            case 'claimPack':
                return 7;
                break;

        }
    }
    static function setTransaction($idUser,$type,$amount){



        $tipo = self::getType($type);

        $transfer = new ExchangeTransfers();
        $transfer->idUser = $idUser;
        $transfer->idType = $tipo;
        $transfer->amount = $amount;
        $transfer->save();

        return response()->json(['message' => 'Transferencia registrada.']);

    }
}
