<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->double('star');
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('provider_id')
                    ->references('id')
                    ->on('providers')
                    ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('company_feedback');
    }
}
