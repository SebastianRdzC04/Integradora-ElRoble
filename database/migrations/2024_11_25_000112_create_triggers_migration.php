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
        DB::unprepared('
            CREATE TRIGGER check_quote_date_availability
            BEFORE INSERT ON quotes
            FOR EACH ROW
            BEGIN
                DECLARE quote_count INT;
                DECLARE event_exists INT;
                
                SELECT COUNT(*) INTO quote_count
                FROM quotes
                WHERE date = NEW.date;
                
                SELECT COUNT(*) INTO event_exists
                FROM events
                WHERE date = NEW.date AND status != "Cancelado";
                
                IF quote_count >= 3 THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Ya existen 3 cotizaciones para esta fecha";
                END IF;
                
                IF event_exists > 0 THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Ya existe un evento programado para esta fecha";
                END IF;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER check_event_date_availability
            BEFORE INSERT ON events
            FOR EACH ROW
            BEGIN
                DECLARE event_exists INT;
                
                SELECT COUNT(*) INTO event_exists
                FROM events
                WHERE date = NEW.date 
                AND status != "Cancelado"
                AND id != NEW.id;
                
                IF event_exists > 0 THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Ya existe un evento programado para esta fecha";
                END IF;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER prevent_duplicate_paid_quotes_insert
            BEFORE INSERT ON quotes
            FOR EACH ROW
            BEGIN
                DECLARE paid_quotes INT;
                
                IF NEW.status = "pagada" THEN
                    SELECT COUNT(*) INTO paid_quotes
                    FROM quotes
                    WHERE date = NEW.date 
                    AND status = "pagada";
                    
                    IF paid_quotes > 0 THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Ya existe una cotización pagada para esta fecha";
                    END IF;
                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER prevent_duplicate_paid_quotes_update
            BEFORE UPDATE ON quotes
            FOR EACH ROW
            BEGIN
                DECLARE paid_quotes INT;
                
                IF NEW.status = "pagada" AND OLD.status != "pagada" THEN
                    SELECT COUNT(*) INTO paid_quotes
                    FROM quotes
                    WHERE date = NEW.date 
                    AND status = "pagada"
                    AND id != NEW.id;
                    
                    IF paid_quotes > 0 THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Ya existe una cotización pagada para esta fecha";
                    END IF;
                END IF;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER prevent_exceeding_maximum_stock 
            BEFORE UPDATE ON consumables
            FOR EACH ROW
            BEGIN
                IF NEW.stock > NEW.maximum_stock THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "El stock no puede exceder el máximo permitido";
                END IF;
            END
        ');      
        DB::unprepared('
            CREATE TRIGGER prevent_exceeding_maximum_stock_insert
            BEFORE INSERT ON consumables
            FOR EACH ROW
            BEGIN
                IF NEW.stock > NEW.maximum_stock THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "El stock no puede exceder el máximo permitido";
                END IF;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER prevent_minimum_exceeding_maximum_update
            BEFORE UPDATE ON consumables
            FOR EACH ROW
            BEGIN
                IF NEW.minimum_stock > NEW.maximum_stock THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "El stock mínimo no puede ser mayor al stock máximo";
                END IF;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER prevent_minimum_exceeding_maximum_insert
            BEFORE INSERT ON consumables
            FOR EACH ROW
            BEGIN
                IF NEW.minimum_stock > NEW.maximum_stock THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "El stock mínimo no puede ser mayor al stock máximo";
                END IF;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER prevent_advance_exceeding_price_insert
            BEFORE INSERT ON quotes
            FOR EACH ROW
            BEGIN
                IF NEW.espected_advance > NEW.estimated_price THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "El anticipo no puede ser mayor al precio estimado";
                END IF;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER prevent_advance_exceeding_price_update
            BEFORE UPDATE ON quotes
            FOR EACH ROW
            BEGIN
                IF NEW.espected_advance > NEW.estimated_price THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "El anticipo no puede ser mayor al precio estimado";
                END IF;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER create_package_images
            AFTER INSERT ON packages
            FOR EACH ROW
            BEGIN
                INSERT INTO packages_images (package_id, image_path, created_at, updated_at)
                SELECT 
                    NEW.id,
                    places.image_path,
                    NOW(),
                    NOW()
                FROM places 
                WHERE places.id = NEW.place_id;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER create_package_service_images
            AFTER INSERT ON packages_services
            FOR EACH ROW
            BEGIN
                INSERT INTO packages_images (package_id, image_path, created_at, updated_at)
                SELECT 
                    NEW.package_id,
                    services.image_path,
                    NOW(),
                    NOW()
                FROM services 
                WHERE services.id = NEW.service_id;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER calculate_event_duration
            BEFORE UPDATE ON events
            FOR EACH ROW
            BEGIN
                IF NEW.status = "Finalizado" AND OLD.status != "Finalizado" THEN
                    IF NEW.start_time IS NOT NULL AND NEW.end_time IS NOT NULL THEN
                        SET NEW.duration = 
                            TIMESTAMPDIFF(
                                MINUTE,
                                CONCAT(NEW.date, " ", NEW.start_time),
                                CONCAT(NEW.date, " ", NEW.end_time)
                            );
                    END IF;
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
        DB::unprepared('DROP TRIGGER IF EXISTS check_quote_date_availability');
        DB::unprepared('DROP TRIGGER IF EXISTS check_event_date_availability');
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_duplicate_paid_quotes_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_duplicate_paid_quotes_update');
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_exceeding_maximum_stock');
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_exceeding_maximum_stock_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_minimum_exceeding_maximum_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_minimum_exceeding_maximum_update');
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_advance_exceeding_price_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_advance_exceeding_price_update');
        DB::unprepared('DROP TRIGGER IF EXISTS create_package_images');
        DB::unprepared('DROP TRIGGER IF EXISTS create_package_service_images');
        DB::unprepared('DROP TRIGGER IF EXISTS calculate_event_duration');
    }
};