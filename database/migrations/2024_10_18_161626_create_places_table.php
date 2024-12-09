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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('description', 100);
            $table->integer('max_guest');
            $table->integer('price');
            $table->string('image_path')->default('https://img.freepik.com/fotos-premium/ardilla-sentada-rama-arbol_1048944-30371835.jpg?w=1060');
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
        Schema::dropIfExists('places');
    }
};
