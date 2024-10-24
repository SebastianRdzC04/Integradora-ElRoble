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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number', 50)->unique();
            $table->string('name', 50);
            $table->string('description', 100);
            $table->foreignId('category_id')->nullable()->constrained('inventory_categories')->onDelete('set null');
            $table->float('price', 5, 2);
            $table->enum('status', ['disponible', 'no disponible', 'en reparacion', 'en mantenimiento', 'dado de baja']);
            $table->string('details', 100);
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
        Schema::dropIfExists('inventory');
    }
};
