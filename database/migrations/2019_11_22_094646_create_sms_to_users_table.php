<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_to_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('body');
            $table->longText('log')->nullable();
            $table->string('status');
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')
                                    ->references('id')
                                    ->on('providers');
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
        Schema::dropIfExists('sms_to_users');
    }
}
