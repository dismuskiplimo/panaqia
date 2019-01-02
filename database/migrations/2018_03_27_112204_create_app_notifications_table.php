<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_id')->nullable();
            $table->integer('to_id')->nullable();
            $table->integer('model_id')->nullable();
            $table->string('notification_type', 50)->nullable();
            $table->string('notification_status', 20)->nullable();
            $table->text('message')->nullable();
            $table->boolean('read')->default(0);
            $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('app_notifications');
    }
}
