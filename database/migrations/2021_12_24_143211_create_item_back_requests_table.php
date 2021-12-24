<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemBackRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_back_requests', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("order_id")->unsigned()->nullable();
            $table->bigInteger("order_item_id")->unsigned()->nullable();
            $table->bigInteger("user_id")->unsigned()->nullable();

            $table->foreign('order_id')
            ->references('id')
            ->on('orders')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('order_item_id')
            ->references('id')
            ->on('order_items')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('status')->default('waiting');//['waiting','accepted','refused']
            $table->string('item_back_count')->default(1);
            $table->string('reason_id')->nullable();

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
        Schema::dropIfExists('item_back_requests');
    }
}
