<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('provider_id');
            $table->string('kitchen')->nullable();
            $table->string('time_delivery_mean')->nullable();
            $table->double('min_order')->default(0.0);
            $table->string('delivery_fee')->nullable();
            $table->string('tags')->nullable();
            $table->integer('rating');
            $table->integer('price_rating');
            $table->foreign('provider_id')
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
        Schema::dropIfExists('setting_providers');
    }
}
