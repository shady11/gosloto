<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteryEditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_editions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('number');

            $table->unsignedInteger('lottery_type');

            $table->integer('tickets_count');

            $table->boolean('active')->default(0);

            $table->timestamps();

            $table->foreign('lottery_type')->references('id')->on('lottery_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_editions');
    }
}
