<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->string('variant_name');
            $table->text('variant_description')->nullable();
            $table->string('variant_image')->nullable();
            $table->string('stat_bonus_type')->nullable();
            $table->integer('stat_bonus_value')->default(0);
            $table->float('critical_bonus')->default(0);
            $table->integer('defense_bonus')->default(0);
            $table->integer('damage_bonus')->default(0);
            $table->float('success_chance')->default(100);
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes_variants');
    }
}
