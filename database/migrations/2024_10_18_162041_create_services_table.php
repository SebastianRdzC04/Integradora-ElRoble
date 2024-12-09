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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('description', 255);
            $table->foreignId('service_category_id')->constrained('service_categories');
            $table->decimal('price', 10, 2);
            $table->integer('people_quantity')->nullable();
            $table->decimal('coast', 10, 2)->nullable();
            $table->string('image_path')->default('https://img.freepik.com/foto-gratis/erizo-europeo-manos-habitat-natural-jardin_1150-18212.jpg?t=st=1733702858~exp=1733706458~hmac=c966c772d0abf14180c14636d9fca82cdd19eea314107a46e55512d18a64af13&w=1380')->nullable();
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
        Schema::dropIfExists('services');
    }
};
