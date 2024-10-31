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
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('package_id')->nullable()->constrained('packages')->onDelete('set null');
            $table->foreignId('place_id')->nullable()->constrained('places')->onDelete('set null');
            $table->date('date');
            $table->enum('status', ['pendiente', 'pagada', 'cancelada', 'pendiente cotizacion']);
            $table->decimal('estimated_price',10, 2)->default(0);
            $table->decimal('espected_advance',10,2)->default(0);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('type_event', 50);
            $table->integer('guest_count');
            $table->string('owner_name', 50)->nullable();
            $table->string('owner_phone', 50)->nullable();
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
        Schema::dropIfExists('quotes');
    }
};
