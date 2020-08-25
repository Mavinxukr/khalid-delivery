<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('deadline')->nullable();
            $table->double('count')->nullable();
            $table->string('action');
            $table->string('type')->default('output');
            $table->string('status')->default('processing');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('provider_id')->index();
            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('invoice_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('order_id')->index();
            $table->foreign('invoice_id')
                ->references('id')
                ->on('commission_invoices')
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
        Schema::dropIfExists('invoice_order');
        Schema::dropIfExists('commission_invoices');
    }
}
