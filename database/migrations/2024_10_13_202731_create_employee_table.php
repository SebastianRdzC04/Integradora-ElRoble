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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personId')->constrained('people');
            $table->string('curp', 18);
            $table->string('rfc', 13);
            $table->string('nss', 11);
            $table->enum('status', ['Active', 'Inactive']);
            $table->text('background')->nullable();
            $table->decimal('dailySalary', 10, 2)->nullable();
            $table->integer('seniority')->nullable();
            $table->date('hireDate');
            $table->foreignId('specialtyId')->constrained('specialties');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }


};
