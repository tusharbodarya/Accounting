<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->text('accountype');
            $table->text('fromaccount');
            $table->text('RcptPymt');
            $table->text('toaccount');
            $table->text('ammount');
            $table->text('date');
            $table->text('income_type');
            $table->text('income_method');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
