<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCoponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_copons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('dateFrom');
            $table->string('dateTo');
            $table->string('discountValue');

            $table->unsignedBigInteger('vendor_id')->nullable();

            $table->foreign('vendor_id')
            ->references('id')
            ->on('vendors')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            
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
        Schema::dropIfExists('discount_copons');
    }
}
