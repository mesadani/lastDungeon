<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /*  Schema::create('market_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('seller_id');
            $table->unsignedInteger('character_bank_id');
            $table->unsignedInteger('idItem');
            $table->integer('amount')->default(0);
            $table->float('price');
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->integer('start');
            $table->integer('end');
            $table->datetime('activacion');
            $table->integer('visible');
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('character_inventory_id')->references('id')->on('character_inventory')->onDelete('cascade');
            $table->foreign('idItem')->references('id')->on('items')->onDelete('cascade');
        });

*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market_items');
    }
}
