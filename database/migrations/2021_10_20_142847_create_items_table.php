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
            
            $table->text("facePage")->nullable();
            $table->text("videoLink")->nullable();
            $table->string("itemName")->nullable();
            $table->string("itemNameAr")->nullable();
            $table->text("itemDescribe")->nullable();
            $table->text("itemDescribeAr")->nullable();
            $table->string("itemImage")->nullable();
            $table->string("itemPrice")->nullable();
            $table->string("itemPriceAfterDis")->nullable();
            //$table->string("itemMainPrice")->nullable();
            $table->enum("discountType",["percent","without"])->nullable();
            $table->integer("discountValue")->default(0);
            $table->string("itemCount")->nullable();

            $table->enum("sallesAppear",["yes","no"])->default("yes");
            $table->enum("publicAppear",["yes","no"])->default("no");//will be change to ["no"] befor project start
            $table->enum("viewInBanner",["yes","no"])->default("no");//will be change to ["no"] befor project start
            //$table->enum("bannerType",[1,2,3,4])->default(1)->nullable();
            $table->enum("withProp",["hasProperty","dontHasProperty"])->default('dontHasProperty')->nullable();
            $table->integer("rate")->default(0);//average rate

            $table->string("department")->nullable();

            $table->unsignedBigInteger('sub_cat_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();

            $table->foreign('vendor_id')
            ->references('id')
            ->on('vendors')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('sub_cat_id')
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
