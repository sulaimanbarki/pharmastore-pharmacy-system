<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('order_id');
            $table->string('order_number');
            $table->integer('customer_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->integer('subtotal');
            $table->integer('total_discount')->nullable();
            $table->integer('tax_pct')->nullable();
            $table->integer('total_tax')->nullable();
            $table->integer('delivery_charge')->nullable();
            $table->integer('grandtotal');
            $table->tinyInteger('status');
            $table->string('payment_status');
            $table->integer('payment_id')->nullable();
            $table->string('order_by')->nullable();
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
