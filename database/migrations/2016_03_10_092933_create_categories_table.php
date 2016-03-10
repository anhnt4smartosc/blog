<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 255)->unique();
            $table->text('short_description');
            $table->text('description');

            $table->text('url_key');
            $table->integer('status');
            $table->integer('position');
            $table->integer('parent_id');
            $table->integer('num_of_products');

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
        Schema::drop('categories');
    }
}
