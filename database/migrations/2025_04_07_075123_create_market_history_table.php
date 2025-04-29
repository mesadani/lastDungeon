<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::create('market_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('idUser');
            $table->unsignedInteger('idItem');
            $table->string('nameItem
            ');
            $table->integer('price');
            $table->integer('amount')->default(0);
            $table->enum('status', ['buy', 'sold'])->default('buy');
            $table->timestamps();

            $table->foreign('idUser')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('idItem')->references('id')->on('items')->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market_history');
    }
}
