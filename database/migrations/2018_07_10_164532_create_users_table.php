<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('login')->nullable();
            $table->string('avatar')->nullable();

            $table->string('name');
            $table->string('lastname');

            $table->unsignedInteger('type');

            $table->string('email')->unique();
            $table->string('password', 60)->nullable();

            $table->string('phone')->nullable();
            $table->string('address_work')->nullable();
            $table->string('address_home')->nullable();

            $table->boolean('active')->default(0);

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('type')->references('id')->on('user_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
