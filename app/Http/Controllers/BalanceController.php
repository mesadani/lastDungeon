<?php

namespace App\Http\Controllers;
use App\Models\Exchange;
use App\Models\UserBalance;
use Illuminate\Support\Str;
class BalanceController extends Controller
{


    function getSwap(){

        global  $USER;
        $amount = $_REQUEST['amount'];

        $key = Str::random(64);
        $echange = new Exchange();
        $echange->idUser = $USER->id;
        $echange->keyRan = Str::random(64); // Equivalente a bin2hex(random_bytes(32))
        $echange->amount = $USER['amount'];
        $echange->save();

        $this->sendJSON(array('message' => (int)$amount , 'keyRand' => $key, 'error' => false));



    }


    function swap(){

        global $PLANET, $LNG, $pricelist, $resource, $reslist, $USER, $resglobal;


        $key = $_REQUEST['trans'];
        $key = $_REQUEST['trans'];



        $row = Exchange::where('idUser', $USER->id)
            ->where('keyRan', $key)
            ->where('checkRan', 0)
            ->first();

        if($row){

            $amount = $row['amount'];
            $porcentaje = 5; // El porcentaje que deseas calcular

            $cincoPorciento = ($amount * $porcentaje) / 100;

            $darUsuario = $amount - $cincoPorciento;


// dar usuario
            // Sumar al usuario autenticado
            UserBalance::where('idUser', $USER->id)->increment('amount', $darUsuario);
// dar comision al admin

            UserBalance::where('idUser', 4)->increment('amount', $cincoPorciento);

            //updateamos la transaccion

            Exchange::where('id', $row['id'])->update([
                'keyRan' => 0,
                'checkRand' => 1,
            ]);


            \App\Tools\Exchange::setTransaction($USER['id'],'buy',$darUsuario);

            \App\Tools\Exchange::setTransaction(4,'buy',$cincoPorciento);

            $this->sendJSON(array('message' => 'ok' , 'error' => false));

        }else{

            $this->sendJSON(array('message' => 'ok' , 'error' => true));


        }

    }


}
