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
            $table->integer('price');
            $table->integer('people_quantity')->nullable();
            $table->integer('coast')->nullable();
            $table->string('image_path')->default('https://res.cloudinary.com/ddclkt7n4/image/upload/v1733793457/unpsg410bmgyadi8edr8.jpg')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('quantifiable')->default(false);
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
