<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawsTable extends Migration
{
    public function up()
    {
        Schema::create('draws', function (Blueprint $table) {
            $table->increments('id');

            $table->string('draw_number');
            $table->integer('length')->default(0);
            $table->unsignedInteger('lottery_id');
            $table->integer('tickets_count');

            $table->boolean('active')->default(0);
            $table->unsignedInteger('owner_id');

            $table->timestamps();

            $table->foreign('lottery_id')->references('id')->on('draw_lotteries')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('draws');
    }
}
