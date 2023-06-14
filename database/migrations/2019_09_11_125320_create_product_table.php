<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('group_id');
            $table->string('name')->unique();
            $table->string('image');
            $table->float('purchasePrice');
            $table->float('sellingPrice');
            $table->integer('storeBox');
            $table->integer('itemsNumber');
            $table->integer('itemsSaleCount')->nullable();
            $table->integer('generic_id');
            $table->integer('supplier_id');            
            $table->text('description')->nullable();
            $table->tinyInteger('status');
            $table->integer('totalPurchedItem');
            $table->date('expireDate');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('medicine_groups')->onDelete('cascade');
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
        Schema::dropIfExists('product');
    }
}
