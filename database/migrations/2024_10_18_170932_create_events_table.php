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
            $table->foreignId('quote_id')->nullable()->constrained('quotes')->onDelete('set null');
            $table->foreignId('date_id')->nullable()->constrained('dates')->onDelete('set null');
            $table->enum('status', ['Pendiente', 'En proceso', 'Finalizado']);
            $table->time('estimated_start_time');
            $table->time('start_time');
            $table->time('estimated_end_time');
            $table->time('end_time');
            $table->integer('duration');
            $table->integer('chair_count');
            $table->integer('table_count');
            $table->integer('table_cloth_count');
            $table->decimal('total_price', 10, 2);
            $table->decimal('advance_payment', 10, 2);
            $table->decimal('remaining_payment', 10, 2);
            $table->integer('extra_hours');
            $table->decimal('extra_hour_price', 10, 2);
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
        Schema::dropIfExists('events');
    }
};
