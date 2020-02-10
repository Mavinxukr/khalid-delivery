<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyCreditCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_credit_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('provider_id');
            $table->string('number_card')->nullable();
            $table->string('name_company')->nullable();
            $table->string('address_company')->nullable();
            $table->string('account_number_company')->nullable();
            $table->string('bank_name_company')->nullable();
            $table->string('iban_number_company')->nullable();
            $table->string('swift_number_company')->nullable();
            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
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
        Schema::dropIfExists('company_credit_cards');
    }
}
