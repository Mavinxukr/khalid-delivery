<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('description');
            $table->string('type')->default('ingredient');
            $table->double('price')->nullable()->default(0);
            $table->binary('image')->nullable();
            $table->integer('rating')->nullable();
            $table->boolean('has_ingredients')->default(false);
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->bigInteger('weight')->nullable();
            $table->boolean('active')->default(true);
            $table->string('query')->nullable();
            $table->text('weight_info')->nullable();
            $table->enum('answer_type', ['count', 'boolean', 'boolean&count'])->nullable();
            $table->foreign('parent_id')->references('id')
                                                ->on('products')
                                                ->onDelete('cascade');
            $table->foreign('provider_id')->references('id')
                                                    ->on('providers')
                                                    ->onDelete('cascade');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')
                                                    ->on('product_categories')
                                                    ->onDelete('cascade');
            $table->unsignedBigInteger('util_id')->nullable();
            $table->foreign('util_id')->references('id')
                ->on('utils')
                ->onDelete('cascade');
            $table->text('what_is_included')->nullable();
            $table->text('what_is_not_included')->nullable();
            $table->text('info_pay')->nullable();
            $table->boolean('sort_most_selling')->nullable();
            $table->boolean('sort_appetizers')->nullable();
            $table->boolean('sort_sales')->nullable();
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
        Schema::dropIfExists('menus');
    }
}
