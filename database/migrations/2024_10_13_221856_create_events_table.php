<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes');
            $table->decimal('total_cost', 10, 2);
            $table->decimal('advance', 10, 2);
            $table->decimal('remaining_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2);
            $table->enum('advance_payment_status', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->enum('total_payment_status', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->date('event_date');
            $table->integer('chair_count');
            $table->integer('table_count');
            $table->integer('tablecloth_count');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration');
            $table->string('event_type', 45);
            $table->integer('extra_hours')->default(0);
            $table->enum('event_status', ['Cancelled', 'Pending', 'Upcoming', 'In Progress', 'Completed'])->default('Pending');
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
};
