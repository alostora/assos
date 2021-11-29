<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemPropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_props', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_item_id")->unsigned()->nullable();
            $table->foreign('order_item_id')
            ->references('id')
            ->on('order_items')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->bigInteger("item_prop_id")->unsigned()->nullable();
            $table->foreign('item_prop_id')
            ->references('id')
            ->on('item_property_pluses')
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
        Schema::dropIfExists('order_item_props');
    }
}
