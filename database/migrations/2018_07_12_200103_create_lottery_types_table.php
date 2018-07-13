<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteryTypesTable extends Migration
{
    public function up()
    {
        Schema::create('lottery_types', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->boolean('has_edition')->default(0);
            $table->boolean('active')->default(0);

            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('lottery_types');
    }
}
