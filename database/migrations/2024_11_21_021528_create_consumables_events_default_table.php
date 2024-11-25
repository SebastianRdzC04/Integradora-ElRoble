<?php
// Nueva migración: create_consumables_events_defaults_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consumables_events_default', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumable_id')->constrained('consumables')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
        
        // Trigger para copiar defaults
        DB::unprepared('
            CREATE TRIGGER after_event_created 
            AFTER INSERT ON events
            FOR EACH ROW
            BEGIN
            INSERT INTO consumables_events (consumable_id, event_id, quantity, created_at, updated_at)
            SELECT 
            consumable_id,
            NEW.id,
            quantity,
            NOW(),
            NOW()
            FROM consumables_events_default;
            END;
        ');
    }
    
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_event_created');

        Schema::dropIfExists('consumables_events_default');
    }
};