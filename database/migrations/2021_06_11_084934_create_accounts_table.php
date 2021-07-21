<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('effecton');
            $table->text('accountsgroup');
            $table->text('area')->nullable();
            $table->text('city')->nullable();
            $table->text('pincode')->nullable();
            $table->text('state')->nullable();
            $table->text('panno')->nullable();
            $table->text('aadharno')->nullable();
            $table->text('gstno')->nullable();
            $table->text('balance');
            $table->text('actype');
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
        Schema::dropIfExists('accounts');
    }
}
