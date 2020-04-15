<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('price')->nullable();
            $table->string('status')->default('pre-order');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('pre_order_id')->nullable();
            $table->foreign('pre_order_id')
                ->references('id')
                ->on('pre_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_orders');
    }
}
