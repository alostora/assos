<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifiisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifiis', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('body')->nullable();
            $table->boolean('read')->default(false);
            $table->string('type')->nullable();//[order,product,user]
            $table->integer('type_id')->nullable();//[order_id,product_id,user_id]

            $table->bigInteger("user_id")->unsigned()->nullable();
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');


            $table->bigInteger("delivery_id")->unsigned()->nullable();
            $table->foreign('delivery_id')
            ->references('id')
            ->on('deliveries')
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
        Schema::dropIfExists('notifiis');
    }
}
