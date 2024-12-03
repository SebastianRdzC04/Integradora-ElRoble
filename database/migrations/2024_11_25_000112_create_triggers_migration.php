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


        DB::unprepared('
            CREATE TRIGGER update_consumable_stock
            AFTER INSERT ON consumable_records
            FOR EACH ROW
            BEGIN
                UPDATE consumables 
                SET stock = stock + NEW.quantity
                WHERE id = NEW.consumable_id;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER update_consumables_stock_after_event
            AFTER UPDATE ON events
            FOR EACH ROW
            BEGIN
                IF NEW.status = "Finalizado" AND OLD.status != "Finalizado" THEN
                    UPDATE consumables c
                    INNER JOIN consumables_events ce ON c.id = ce.consumable_id AND ce.event_id = NEW.id
                    SET c.stock = c.stock - ce.quantity;
                END IF;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER set_quote_place_from_package
            BEFORE INSERT ON quotes
            FOR EACH ROW
            BEGIN
                IF NEW.package_id IS NOT NULL THEN
                    SET NEW.place_id = (
                        SELECT place_id 
                        FROM packages 
                        WHERE id = NEW.package_id
                    );
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_quote_status');
        DB::unprepared('DROP TRIGGER IF EXISTS update_consumable_stock');
        DB::unprepared('DROP TRIGGER IF EXISTS update_consumables_stock_after_event');
        DB::unprepared('DROP TRIGGER IF EXISTS set_quote_place_from_package');
    }
};