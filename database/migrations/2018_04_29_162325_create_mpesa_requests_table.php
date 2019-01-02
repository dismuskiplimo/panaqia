<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpesaRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_requests', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('user_id');
            $table->integer('event_id');
            
            $table->string('MerchantRequestID')->nullable();
            $table->string('CheckoutRequestID')->nullable();
            $table->string('ResultDesc')->nullable();
            $table->string('ResultCode')->nullable();

            $table->integer('amount')->default(0);
            $table->boolean('queried')->default(0);
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
        Schema::dropIfExists('mpesa_requests');
    }
}
