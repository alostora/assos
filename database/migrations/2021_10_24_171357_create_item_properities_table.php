<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemProperitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_properities', function (Blueprint $table) {
            $table->id();
            

            $table->bigInteger('main_prop_id')->unsigned()->nullable();
            $table->foreign('main_prop_id')
            ->references('id')
            ->on('properties')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            
            $table->bigInteger('item_id')->unsigned()->nullable();
            $table->foreign('item_id')
            ->references('id')
            ->on('items')
            ->onDelete('cascade')
            ->onUpdate('cascade');

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
        Schema::dropIfExists('item_properities');
    }
}
