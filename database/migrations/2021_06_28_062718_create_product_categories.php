<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('saree_niddle1')->nullable();
            $table->text('saree_niddle2')->nullable();
            $table->text('saree_niddle3')->nullable();
            $table->text('saree_niddle4')->nullable();
            $table->text('saree_niddle5')->nullable();
            $table->text('saree_niddle6')->nullable();
            $table->text('lace_niddle1')->nullable();
            $table->text('lace_niddle2')->nullable();
            $table->text('lace_niddle3')->nullable();
            $table->text('lace_niddle4')->nullable();
            $table->text('lace_niddle5')->nullable();
            $table->text('lace_niddle6')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_deleted')->default(1);
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
        Schema::dropIfExists('product_categories');
    }
}
