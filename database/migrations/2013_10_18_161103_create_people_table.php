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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->date('birthdate');
            $table->enum('gender', ['Masculino', 'Femenino', 'Otro']);
            $table->string('phone', 10);
            $table->integer('age')->nullable();
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER calculate_age_before_insert
            BEFORE INSERT ON people
            FOR EACH ROW
            BEGIN
                -- Calcular la edad basándose en la fecha de nacimiento
                SET NEW.age = TIMESTAMPDIFF(YEAR, NEW.birthdate, CURDATE());
            END;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
        DB::statement("DROP TRIGGER IF EXISTS calculate_age_before_insert");
    }
};
