<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('card_token');
            $table->double('sum');
            $table->string('currency');
            $table->foreign('user_id')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('checkout_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('checkout_id');
            $table->unsignedBigInteger('order_id');
            $table->foreign('checkout_id')
                            ->references('id')
                            ->on('checkouts')
                            ->onDelete('cascade');
            $table->foreign('order_id')
                            ->references('id')
                            ->on('orders')
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
        Schema::dropIfExists('checkouts');
        Schema::dropIfExists('checkout_order');
    }
}
