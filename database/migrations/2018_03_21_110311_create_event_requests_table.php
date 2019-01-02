<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_id');
            $table->integer('to_id');
            $table->integer('event_id');
            $table->string('topic')->nullable();
            $table->enum('attending_as',['SPEAKER','DELEGATE','EXHIBITOR'])->default('DELEGATE');
            $table->boolean('approved')->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->boolean('paid')->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->double('amount_paid', 12)->default(0);
            $table->double('amount_due', 12)->default(0);

            $table->string('payment_type')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_requests');
    }
}
