<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            
            $table->string('banner')->nullable();
            $table->string('thumbnail')->nullable();

            $table->text('description')->nullable();

            $table->string('venue')->nullable();
            $table->text('location')->nullable();
            $table->boolean('invite_only')->default(0);
            
            $table->double('speaker_price', 12)->default(0);
            $table->double('delegate_price', 12)->default(0);
            $table->double('exhibitor_price',12)->default(0);
            
            $table->integer('currency_id')->nullable();
            $table->integer('user_id');

            $table->integer('category_id')->nullable();
            
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->string('start_time',5)->nullable();
            $table->string('end_time',5)->nullable();

            $table->boolean('include_weekends')->default(0);
            $table->text('map')->nullable();

            $table->enum('payment_method',['COMMISSION', 'PROMOTION', 'FREE'])->default('COMMISSION');

            $table->boolean('collect_revenue')->default(0);
            $table->boolean('promote_event')->default(0);
            $table->boolean('manage_attendees')->default(0);

            $table->boolean('closed')->default(0);
            $table->timestamp('closed_at')->nullable();
            $table->integer('closed_by')->nullable();
            
            $table->boolean('featured')->default(0);
            $table->timestamp('featured_from')->nullable();
            $table->timestamp('featured_until')->nullable();
            $table->integer('featured_days')->nullable();
            $table->double('featured_amount',12)->nullable();
            $table->string('featured_currency')->nullable();
            $table->string('featured_image')->nullable();

            $table->boolean('cancelled')->nullable();
            $table->integer('cancelled_by')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancelled_reason')->nullable();

            $table->double('paypal_collected',12)->default(0);
            $table->double('mpesa_collected',12)->default(0);

            $table->double('commission_percent',12)->default(0);

            $table->double('paypal_commission',12)->default(0);
            $table->double('mpesa_commission',12)->default(0);

            $table->double('total_collected',12)->default(0);
            $table->double('total_commission',12)->default(0);
            
            $table->boolean('withdrawn')->default(0);
            $table->integer('withdrawn_by')->nullable();
            $table->timestamp('withdrawn_at')->nullable();

            $table->string('picker_name')->nullable();
            $table->string('picker_phone')->nullable();
            $table->string('picker_id')->nullable();

            $table->integer('timezone_id')->nullable();
            $table->string('tz')->nullable();
            
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
        Schema::dropIfExists('events');
    }
}
