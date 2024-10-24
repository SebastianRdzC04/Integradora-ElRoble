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
        Schema::create('packages_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages');
            $table->foreignId('service_id')->constrained('services');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->string('description', 255);
            $table->text('details_dj');
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
        Schema::dropIfExists('packages_services');
    }
};
