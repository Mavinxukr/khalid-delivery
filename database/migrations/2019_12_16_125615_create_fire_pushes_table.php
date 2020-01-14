<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirePushesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fire_pushes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('time');
            $table->string('date');
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('order_id')
                            ->on('orders')
                            ->references('id')
                            ->onDelete('cascade');
            $table->foreign('user_id')
                            ->on('users')
                            ->references('id')
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
        Schema::dropIfExists('fire_pushes');
    }
}
