<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('comment');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('who_id');
            $table->unsignedBigInteger('whom_id');
            $table->double('star');
            $table->foreign('order_id')
                            ->on('orders')
                            ->references('id')
                            ->onDelete('cascade');
            $table->foreign('who_id')
                            ->on('users')
                            ->references('id')
                            ->onDelete('cascade');
            $table->foreign('whom_id')
                            ->on('providers')
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
        Schema::dropIfExists('feedback');
    }
}
