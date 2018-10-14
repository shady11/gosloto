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

            $table->integer('tickets_count');
            $table->integer('sold_tickets_count');
            $table->integer('returned_tickets_count');

            $table->unsignedInteger('supervisor_id')->nullable();
            $table->unsignedInteger('seller_id')->nullable();
            $table->unsignedInteger('owner_id')->nullable();
            $table->unsignedInteger('lottery_id')->nullable();

            $table->timestamp('shared_to_seller_at')->nullable();
            $table->timestamp('shared_to_supervisor_at')->nullable();
            $table->timestamp('sold_at')->nullable();
            $table->timestamp('returned_at')->nullable();

            $table->timestamps();

            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lottery_id')->references('id')->on('instant_lotteries')->onDelete('cascade');
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
