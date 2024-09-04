<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sensor_id')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->string('topic');
            $table->text('received_data')->nullable();
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
        Schema::dropIfExists('device_datas');
    }
}
