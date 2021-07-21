<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleChallansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_challans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('orderid');
            $table->unsignedBigInteger('accountid');
            $table->text('invoicetype');
            $table->text('challannum')->nullable();
            $table->date('orderdate')->nullable();
            $table->date('orderduedate')->nullable();
            $table->text('taxformate');
            $table->text('discountformate');
            $table->text('notes')->nullable();
            $table->text('productarray');
            $table->text('totaltax')->nullable();
            $table->text('totaldiscount')->nullable();
            $table->text('total');
            $table->boolean('is_deleted')->default(1);
            $table->timestamps();
            $table->foreign('accountid')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_challans');
    }
}
