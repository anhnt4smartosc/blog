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
            $table->integer('parent_id')->default(0);
            //This will be update on saving product
            $table->integer('num_of_products');

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
