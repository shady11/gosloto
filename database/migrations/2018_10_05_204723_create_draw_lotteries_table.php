<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawLotteriesTable extends Migration
{
    public function up()
    {
        Schema::create('draw_lotteries', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->boolean('active')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('draw_lotteries');
    }
}
