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

            $table->string('propertyValue')->nullable();
            $table->text('propertyDetails')->nullable();
            $table->string('propertyPrice')->nullable();

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
