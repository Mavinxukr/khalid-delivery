<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_provider', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provider_id')->unsigned()->index();
            $table->bigInteger('payment_id')->unsigned()->index();
            $table->foreign('provider_id')
                                ->references('id')
                                ->on('providers')
                                ->onDelete('cascade');
            $table->foreign('payment_id')
                                ->references('id')
                                ->on('payments')
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
        Schema::dropIfExists('payment_provider');
    }
}
