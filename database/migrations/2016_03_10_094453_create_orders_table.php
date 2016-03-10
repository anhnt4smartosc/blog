<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('customer_id');
            $table->double('total');
            $table->double('sub_total');
            $table->double('discount');
            $table->double('tax')->default(0);

            $table->integer('state');

            $table->dateTime('created_date');
            $table->dateTime('updated_date');

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_id');
            $table->integer('customer_id');
            $table->integer('product_id');
            $table->integer('qty');

            $table->double('base_price');
            $table->double('final_price');

            $table->double('sub_total');
            $table->double('row_total');

            $table->double('discount');
            $table->double('tax')->default(0);

            $table->dateTime('created_date');
            $table->dateTime('updated_date');

            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_id');
            $table->integer('customer_id');
            $table->double('total');
            $table->double('sub_total');
            $table->double('discount');
            $table->double('tax')->default(0);

            $table->integer('state');

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
        Schema::drop('orders');
    }
}
