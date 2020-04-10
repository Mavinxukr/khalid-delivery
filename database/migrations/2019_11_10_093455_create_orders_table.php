<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('place_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->string('provider_category')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('date_delivery');
            $table->string('date_delivery_from');
            $table->string('date_delivery_to');
            $table->string('callback_time')->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->bigInteger('count_clean')->nullable();
            $table->float('debt', 10, 2)->nullable();
            $table->float('paid', 10, 2)->default(0);
            $table->float('cost', 10, 2)->nullable();
            $table->enum('type_cleaning',['house','office','flat'])->nullable();
            $table->bigInteger('interval')->default(0);
            $table->mediumText('comment')->nullable();
            $table->enum('status',['wait','new','confirm','cancel','done'])->default('wait');

            $table->float('service_received', 10, 2)->nullable();
            $table->float('company_received', 10, 2)->nullable();
            $table->unsignedBigInteger('pre_order_id')->nullable();

            $table->foreign('place_id')->references('id')
                ->on('places')
                ->onDelete('cascade');
            $table->foreign('product_id')->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('provider_id')->references('id')
                ->on('providers')
                ->onDelete('cascade');

            $table->foreign('pre_order_id')
                ->references('id')
                ->on('pre_orders');
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
