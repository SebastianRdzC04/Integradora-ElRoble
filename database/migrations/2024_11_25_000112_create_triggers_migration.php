<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER update_quote_status 
            BEFORE UPDATE ON quotes
            FOR EACH ROW 
            BEGIN
                IF NEW.estimated_price != OLD.estimated_price THEN
                    SET NEW.status = "pendiente";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_quote_status');
    }
};