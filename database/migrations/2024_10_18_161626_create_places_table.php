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
            $table->string('image_path')->default('https://res.cloudinary.com/ddclkt7n4/image/upload/v1733793829/ddtabcbiewgkxoxz772o.jpg');
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
