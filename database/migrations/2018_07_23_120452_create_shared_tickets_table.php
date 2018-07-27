<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharedTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_tickets', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('count');

            $table->unsignedInteger('user');
            $table->unsignedInteger('lottery');

            $table->unsignedInteger('shared_user');

            $table->timestamps();

            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shared_user')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('shared_tickets');
    }
}
