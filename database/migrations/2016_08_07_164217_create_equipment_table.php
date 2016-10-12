<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('category_id')->unsigned()->index();
            $table->integer('photo_id')->unsigned()->index();
            $table->integer('reservation_id')->unsigned()->index();
            $table->integer('stockin_id')->unsigned()->index();
            $table->string('item');
            $table->text('description');
            $table->integer('status');
            $table->boolean('consumable');
            $table->boolean('outOfStock');
            $table->boolean('hasQuantity');
            $table->boolean('hasReservation');
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
        Schema::drop('equipment');
    }
}
