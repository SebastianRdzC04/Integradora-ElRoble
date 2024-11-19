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
        Schema::table('services', function (Blueprint $table) {
            $table->integer('cantidad')->after('price')->default(1)->comment('Cantidad de personas para las que aplica el servicio');
        });
    }
    
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('cantidad');
        });
    }    
};
