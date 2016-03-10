<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 255)->unique();
            $table->text('short_description');
            $table->text('description');

            $table->double('cost');
            $table->double('price');
            $table->double('special_price');
            $table->date('special_from');
            $table->date('special_to');

            $table->text('url_key');
            $table->integer('status');
            $table->integer('type');
            $table->string('related_products', 255);

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
        Schema::drop('products');
    }
}
