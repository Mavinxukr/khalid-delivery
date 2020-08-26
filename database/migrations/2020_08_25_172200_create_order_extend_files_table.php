<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderExtendFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_extend_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_extend_id');
            $table->text('link');
            $table->foreign('order_extend_id')
                ->references('id')
                ->on('order_extends')
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
        Schema::dropIfExists('order_extend_files');
    }
}
