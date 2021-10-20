<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            
            $table->string('itemName')->nullable();
            $table->string('itemNameAr')->nullable();
            $table->text('itemDesc')->nullable();
            $table->text('itemDescAr')->nullable();
            $table->string('itemImage')->nullable();
            $table->integer('itemPrice')->default(0);
            $table->integer('dicountPrice')->default(0);

            $table->unsignedBigInteger('s_cat_id')->nullable();

            $table->foreign('s_cat_id')
            ->references('id')
            ->on('sub_categories')
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
        Schema::dropIfExists('items');
    }
}
