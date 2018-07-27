<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_tickets', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('count');

            $table->unsignedInteger('user');
            $table->unsignedInteger('lottery');

            $table->timestamp('sold_date')->nullable();

            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lottery')->references('id')->on('lotteries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sold_tickets');
    }
}
