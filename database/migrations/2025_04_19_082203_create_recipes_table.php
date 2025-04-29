<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {/*
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('itemcraft_id');
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->string('rarity')->nullable();
            $table->text('description')->nullable();
            $table->boolean('has_variants')->default(false);
            $table->timestamps();

           // $table->foreign('idItem')->references('id')->on('items')->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
