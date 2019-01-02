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
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('bio')->nullable();
            $table->integer('views')->default(0);
            $table->integer('created_by')->nullable();
            $table->string('name_of_company')->nullable();
            $table->string('position')->nullable();
            $table->string('sector')->nullable();
            $table->string('country_code', 2)->nullable();
            $table->enum('usertype', ['ADMIN', 'MANAGER', 'USER'])->default('USER');
            $table->boolean('is_admin')->default(0);

            $table->boolean('closed')->default(0);
            $table->text('closed_reason')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->integer('closed_by')->nullable();
            
            $table->boolean('suspended')->default(0);
            $table->text('suspended_reason')->nullable();
            $table->integer('suspended_by')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->integer('suspended_days')->nullable();
            $table->timestamp('suspended_until')->nullable();

            $table->integer('activated_by')->nullable();
            $table->timestamp('activated_at')->nullable();
            
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
