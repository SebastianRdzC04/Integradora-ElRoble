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
            $table->foreignId('quote_id')->unique()->constrained('quotes')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->date('date');
            $table->enum('status', ['Pendiente', 'En espera', 'En proceso', 'Finalizado', 'Cancelado'])->default('Pendiente');
            $table->time('estimated_start_time');
            $table->time('start_time')->nullable();
            $table->time('estimated_end_time');
            $table->time('end_time')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('chair_count')->default(0);
            $table->integer('table_count')->default(0);
            $table->integer('table_cloth_count')->default(0);
            $table->decimal('total_price', 10, 2);
            $table->decimal('advance_payment', 10, 2);
            $table->decimal('remaining_payment', 10, 2);
            $table->integer('extra_hours')->nullable();
            $table->decimal('extra_hour_price', 10, 2)->nullable();
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
