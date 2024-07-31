<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->tinyInteger('active')->default(0);
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->integer('email_verified_at')->unsigned()->nullable();
            $table->string('phone')->nullable();
            $table->integer('phone_verified_at')->unsigned()->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('role')->nullable();
            $table->string('level')->nullable();
            $table->integer('expire_time')->unsigned()->nullable();
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
        Schema::dropIfExists('users');
    }
}
