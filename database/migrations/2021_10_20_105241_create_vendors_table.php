<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('vendor_image')->nullable();
            $table->string('vendor_logo')->nullable();
            $table->string('password')->nullable();
            $table->string('address')->nullable();
            $table->string('api_token')->nullable();
            $table->string('firebase_token')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
