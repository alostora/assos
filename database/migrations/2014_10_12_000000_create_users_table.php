<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('image')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('api_token')->nullable();
            $table->string('socialType')->nullable();//['google,face',.....]
            $table->text('socialToken')->unique()->nullable();
            $table->string('country')->default('sa');//[sa,kw]
            
            $table->string('deviceId')->nullable();

            $table->string('verify_token')->nullable();
            $table->string('firebase_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
