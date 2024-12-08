<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::unprepared('
            CREATE TRIGGER after_quote_paid_trigger
            AFTER UPDATE ON quotes
            FOR EACH ROW
            BEGIN
                IF NEW.status = "pagada" AND OLD.status != "pagada" THEN
                    INSERT INTO events (
                        quote_id,
                        user_id,
                        date,
                        status,
                        estimated_start_time,
                        estimated_end_time,
                        total_price,
                        advance_payment,
                        remaining_payment,
                        created_at,
                        updated_at
                    )
                    VALUES (
                        NEW.id,
                        1,
                        NEW.date,
                        "Pendiente",
                        NEW.start_time,
                        NEW.end_time,
                        NEW.estimated_price,
                        NEW.espected_advance,
                        NEW.estimated_price - NEW.espected_advance,
                        NOW(),
                        NOW()
                    );
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER after_quote_paid_trigger');
    }
};
