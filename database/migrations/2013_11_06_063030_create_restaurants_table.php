<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('description');
            $table->string('phone_number');
            $table->double('balance')->default(0.0);
            $table->longText('image')->nullable();
            $table->boolean('active')->default(1);
            $table->string('website')->default('empty');
            $table->string('email')->default('empty');
            $table->string('company_number')->nullable();
            $table->string('chamber_of_commerce')->default('empty');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')
                                                  ->on('categories')
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
        Schema::dropIfExists('providers');
    }
}
