<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->string('response_code');
            $table->string('transaction_id');
            $table->unsignedBigInteger('order_id');
            $table->string('auth_code');
            $table->string('transaction_title');
            $table->float('amount', 10, 2)->nullable();
            $table->string('currency');
            $table->float('net_amount', 10, 2)->nullable();
            $table->string('net_amount_currency');
            $table->float('net_amount_credited', 10, 2)->nullable();
            $table->string('net_amount_credited_currency');
            $table->timestamp('transaction_datetime');
            $table->string('force_accept_datetime');
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
        Schema::dropIfExists('transactions');
    }
}
