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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->integer('stock');
            $table->integer('minStock');
            $table->foreignId('brandId')->nullable()->constrained('brands')->onDelete('set null');
            $table->text('specifications')->nullable();
            $table->text('details')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->foreignId('categoryId')->nullable()->constrained('categories')->onDelete('set null');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
};
