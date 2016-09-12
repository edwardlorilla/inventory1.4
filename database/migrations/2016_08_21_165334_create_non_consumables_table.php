<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNonConsumablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_consumables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item');
            $table->integer('quantity');
            $table->boolean('status');
            $table->string('name')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('non_consumables');
    }
}
