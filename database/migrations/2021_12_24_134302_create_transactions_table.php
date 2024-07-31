<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('merchant_id')->nullable();
            $table->string('type')->nullable();
            $table->string('type_value')->nullable(); 
            $table->string('category_ids')->nullable();
            $table->text('all_cat_ids')->nullable();
            $table->string('package_ids')->nullable();
            $table->string('port_name')->nullable()->default(null);
            $table->string('user_ip')->nullable()->default(null);
            $table->string('authority')->nullable()->default(null);
            $table->string('order_id')->nullable()->default(null);
            $table->string('reference')->nullable()->default(null);
            $table->boolean('payed')->nullable()->default(false);
            $table->string('off_code')->nullable()->default(null);
            $table->string('off_price')->nullable()->default(null);
            $table->string('total')->nullable()->default(null);
            $table->string('total_after_off')->nullable()->default(null);
            $table->unsignedInteger('creation_time')->nullable()->default(null);
            $table->unsignedInteger('payment_time')->nullable()->default(null);
            $table->string('card_info')->nullable()->default(null);
            $table->string('card_pan')->nullable()->default(null);
            $table->string('deep_link')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
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
        Schema::dropIfExists('transactions');
    }
}
