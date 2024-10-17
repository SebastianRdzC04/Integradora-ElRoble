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
        Schema::create('event_consumables', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('consumable_id')->constrained('consumables');
            $table->boolean('prepared')->default(false);
            $table->primary(['event_id', 'consumable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_consumables');
    }
};
