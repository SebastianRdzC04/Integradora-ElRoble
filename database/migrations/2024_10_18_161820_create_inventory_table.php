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
            $table->foreignId('serial_number_type_id')->constrained('serial_number_types_inventory')->onDelete('cascade');
            $table->string('description', 100);
            $table->float('price', 5, 2);
            $table->enum('status', ['disponible', 'no disponible', 'en reparacion', 'en mantenimiento', 'dado de baja'])->default('disponible');
            $table->string('details', 100)->default('Sin detalles');
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
