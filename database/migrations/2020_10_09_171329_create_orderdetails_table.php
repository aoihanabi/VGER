<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreignId('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->decimal('subtotal', 8, 2)->comment('Precio del producto por la cantidad');
            $table->string('status', 1)->default('A')->comment('A:Activo I:Inactivo');
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
        Schema::dropIfExists('orderdetails');
    }
}
