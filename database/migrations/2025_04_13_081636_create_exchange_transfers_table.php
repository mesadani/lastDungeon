<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Schema::create('exchange_transfers', function (Blueprint $table) {
           $table->id();
            $table->unsignedInteger('idUser');
            $table->double('amount');
            $table->integer('idType');
            $table->foreign('idUser')->references('id')->on('accounts')->onDelete('cascade');
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_transfers');
    }
}
