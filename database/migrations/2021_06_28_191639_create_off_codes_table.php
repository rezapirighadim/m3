<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('off_codes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('seller_id');
            $table->integer('user_id')->nullable();
            $table->string('code');
            $table->integer('percent');
            $table->integer('max_limit')->nullable();
            $table->integer('expire_ts')->nullable();
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
        Schema::dropIfExists('off_codes');
    }
}
