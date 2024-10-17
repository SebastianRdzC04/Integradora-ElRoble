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
        Schema::create('quote_service', function (Blueprint $table) {
            $table->foreignId('quote_id')->constrained('quotes');
            $table->foreignId('service_id')->constrained('services');
            $table->text('specifications');
            $table->primary(['quote_id', 'service_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_service');
    }
};
