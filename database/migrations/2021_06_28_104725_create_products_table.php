<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name', 100);
            $table->text('code')->nullable();
            $table->unsignedBigInteger('categories');
            $table->bigInteger('price');
            $table->text('description')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('is_deleted')->default(1);
            $table->timestamps();
            $table->foreign('categories')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
