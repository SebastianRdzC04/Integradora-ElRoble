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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->foreignId('person_id')->constrained('people')->onDelete('cascade');
            $table->rememberToken();
            $table->boolean('status')->default(true);
            $table->string('avatar')->default('https://res.cloudinary.com/ddclkt7n4/image/upload/v1733793457/unpsg410bmgyadi8edr8.jpg');
            $table->string('external_id')->nullable();
            $table->string('external_auth')->nullable();
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
        Schema::dropIfExists('users');
    }
};
