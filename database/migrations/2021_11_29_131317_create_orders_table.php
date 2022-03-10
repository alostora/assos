<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderCode')->nullable();
            $table->string('status')->default('new');
            $table->string('shippingType');//[freeShipping,normalShipping,fastShipping]
            $table->string('paymentMethod');//[myFatora,cashOnDelivery]
            $table->string('total_price');
            $table->string('discountCopon')->default(0);
            $table->string('addedTax')->default(1);
            $table->string('sub_total')->default(1);
            $table->string('total')->nullable();
            $table->string('shippingValue')->default(0);
            $table->string('shippingAddress_id')->nullable();

            $table->bigInteger("user_id")->unsigned()->nullable();
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
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
        Schema::dropIfExists('orders');
    }
}
