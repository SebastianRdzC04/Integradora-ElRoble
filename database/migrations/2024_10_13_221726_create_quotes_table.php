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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->date('event_date');
            $table->integer('guest_count');
            $table->enum('status', ['Accepted', 'Cancelled', 'Pending', 'Served'])->default('Pending');
            $table->decimal('estimated_price', 10, 2);
            $table->decimal('expected_advance', 10, 2);
            $table->text('message');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration');
            $table->string('event_type', 45);
            $table->text('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
};
