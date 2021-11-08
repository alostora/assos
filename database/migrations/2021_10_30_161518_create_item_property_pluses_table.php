<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPropertyPlusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_property_pluses', function (Blueprint $table) {
            $table->id();


            $table->bigInteger("sub_prop_id")->unsigned()->nullable();
            $table->foreign('sub_prop_id')
            ->references('id')
            ->on('sub_properties')
            ->onDelete('cascade')
            ->onUpdate('cascade');


            $table->bigInteger("properity_id")->unsigned()->nullable();
            $table->foreign('properity_id')
            ->references('id')
            ->on('item_properities')
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
        Schema::dropIfExists('item_property_pluses');
    }
}
